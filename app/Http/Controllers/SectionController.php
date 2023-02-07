<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Section;
use App\Models\SectionSeat;
use App\Models\SectionTeacher;
use App\Models\Teacher;

class SectionController extends Controller
{
    public function index(Request $request) 
    {
        $sections = Section::withSearch($request)->get();
        return view('sections.index',[
            'sections' => $sections,
        ]);
    }

    public function create(Request $request) 
    {
        $teachers = Teacher::all();
        return view('sections.create', [
            'teachers' => $teachers,
        ]);
    }

    public function add(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255|unique:sections,name',
            'teacher' => 'required',
        ]);

        $section = Section::create([
            'name' => $request->name,
        ]);

        SectionTeacher::create([
            'teacher_id' => $request->teacher,
            'section_id' => $section->id,
        ]);

        return back()->with('success','Successfully added new section!');
    }

    public function edit(Section $section, Request $request)
    {
        $teachers = Teacher::all();
        return view('sections.edit', [
            'section' => $section,
            'teachers' => $teachers,
        ]);
    }

    public function update(Section $section, Request $request)
    {
        $request->validate([
            'name' => 'required|max:255|unique:sections,name,'.$section->id,
            'teacher' => 'required',
        ]);

        $section->update([
            'name' => $request->name,
        ]);
        if ($section->section_teacher) {
            $section->section_teacher->update([
                'teacher_id' => $request->teacher,
            ]);
        } else {
            SectionTeacher::create([
                'teacher_id' => $request->teacher,
                'section_id' => $section->id,
            ]);
        }
        
        return back()->with('success','Successfully edited section!');
    }

    public function students(Section $section, Request $request)
    {
        return view('sections.students', [
            'section' => $section,
            'students' => $section->students,
        ]);
    }

    public function destroy(Section $section, Request $request)
    {
        if ($section->section_teacher) {
            $section->section_teacher->delete();
        }
        
        $section->delete();

        return back()->with('success','Successfully deleted section!');
    }

    public function seat(Section $section, Request $request) {
        // dd();
        return view('sections.seats',[
            'section' => $section,
            'max_row' => 6,
            'seat_per_row' => 5,
            'seats' => $section->seats->pluck('seat')->toArray(),
        ]);
    }
    public function seatAdd(Section $section, Request $request) {
        if(! SectionSeat::where('seat', $request->seat)->where('section_id', $section->id)->first()) {
            SectionSeat::create([
                'section_id' => $section->id,
                'seat' => $request->seat,
            ]);
        }
        return response()->json(['id' => $request->seat]);
    }
    public function seatRemove(Section $section, Request $request) {
        $seat = SectionSeat::where('seat', $request->seat)->where('section_id', $section->id)->first();
        if($seat) {
            $seat->delete();
        }
        return response()->json(['id' => $request->seat]);
    }
}
