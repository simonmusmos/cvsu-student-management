<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Section;

class SeatController extends Controller
{
    private $status_code = 200;
    public function getSeats(Request $request) {
        return $request->user()->student->section->seats->pluck('seat')->toArray();
    }
}
