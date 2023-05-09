<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\RoomSeat;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    public function index (Request $request) {
        $rooms = Room::withSearch($request)->get();
        return view('rooms.index',[
            'rooms' => $rooms,
        ]);
    }

    public function create(Request $request) 
    {
        return view('rooms.create');
    }

    public function add(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255|unique:rooms,name',
        ]);

        $room = Room::create([
            'name' => $request->name,
        ]);

        return back()->with('success','Successfully added new room!');
    }

    public function edit(Room $room, Request $request)
    {
        return view('rooms.edit', [
            'room' => $room,
        ]);
    }

    public function update(Room $room, Request $request)
    {
        $request->validate([
            'name' => 'required|max:255|unique:rooms,name,'.$room->id,
        ]);

        $room->update([
            'name' => $request->name,
        ]);
        
        return back()->with('success','Successfully edited room!');
    }

    public function destroy(Room $room, Request $request)
    {
        $room->delete();

        return back()->with('success','Successfully deleted room!');
    }

    public function seat(Room $room, Request $request) {
        // dd();
        return view('rooms.seats',[
            'room' => $room,
            'max_row' => 6,
            'seat_per_row' => 5,
            'seats' => $room->seats->pluck('seat')->toArray(),
        ]);
    }
    public function seatAdd(Room $room, Request $request) {
        if(! RoomSeat::where('seat', $request->seat)->where('room_id', $room->id)->first()) {
            RoomSeat::create([
                'room_id' => $room->id,
                'seat' => $request->seat,
            ]);
        }
        return response()->json(['id' => $request->seat]);
    }
    public function seatRemove(Room $room, Request $request) {
        $seat = RoomSeat::where('seat', $request->seat)->where('room_id', $room->id)->first();
        if($seat) {
            $seat->delete();
        }
        return response()->json(['id' => $request->seat]);
    }
}
