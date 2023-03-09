<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\UserSeat;
use Carbon\Carbon;

class SeatController extends Controller
{
    private $status_code = 200;
    public function getSeats(Request $request) {
        return $request->user()->student->section->seats->pluck('seat')->toArray();
    }

    public function checkSeats(Request $request) {
        $exists = UserSeat::where('student_id', $request->user()->student)->whereDate('created_at', Carbon::today())->first();
        if (! $exists) {
            $seat_exists = UserSeat::where('seat', $request->seat)->whereDate('created_at', Carbon::today())->first();
            if (! $seat_exists) {
                return response()->json(['status' => true]);
            }
        }
        return response()->json(['status' => false]);
    }

    public function useSeat(Request $request) {
        return response()->json([123]);
        $exists = UserSeat::where('student_id', $request->user()->student)->whereDate('created_at', Carbon::today())->first();
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
