<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\UserSeat;
use App\Models\Student;
use App\Models\User;
use App\Models\SectionSeat;
use Carbon\Carbon;

class SeatController extends Controller
{
    private $status_code = 200;
    // public function getSeats(Request $request) {
    //     return $request->user()->student->section->seats->pluck('seat')->toArray();
    // }

    public function getSeats(Request $request) {
        
        $students = $request->user()->student->section->students->pluck('id')->toArray();
        $occupied = UserSeat::whereIn('student_id', $students)->whereDate('created_at', Carbon::today())->get()->pluck('seat')->toArray();
        $seats = SectionSeat::whereNotIn('seat', $occupied)->where('section_id', $request->user()->student->section_id)->get()->pluck('seat')->toArray();
        return response()->json(['occupied' => $occupied, 'seats' => $seats]);
        // return $request->user()->student->section->seats->pluck('seat')->toArray();
    }

    public function checkSeats(Request $request) {
        $exists = UserSeat::where('student_id', $request->user()->student->id)->whereDate('created_at', Carbon::today())->first();
        $owner = "";
        if (! $exists || $request->in_home == 1) {
            $seat_exists = UserSeat::where('seat', $request->seat)->whereDate('created_at', Carbon::today())->first();
            if (! $seat_exists) {
                return response()->json(['status' => true]);
            } else {
                $owner = $seat_exists->student->user->name;
            }
        }
        return response()->json(['status' => false, 'owner' => $owner]);
    }

    public function useSeat(Request $request) {
        $exists = UserSeat::where('student_id', $request->user()->student->id)->whereDate('created_at', Carbon::today())->first();
        if (! $exists) {
            $seat_exists = UserSeat::where('seat', $request->seat)->whereDate('created_at', Carbon::today())->first();
            if (! $seat_exists) {
                UserSeat::create([
                    'seat' => $request->seat,
                    'student_id' => $request->user()->student->id,
                ]);
                return response()->json(['status' => true]);
            }
        }
        return response()->json(['status' => false]);
    }
}
