<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Section;

class StudentController extends Controller
{
    public function index(Request $request) 
    {
        $students = Student::withSearch($request)->get();
        
        return view('students.index',[
            'students' => $students,
        ]);
    }

    public function create(Request $request) 
    {
        $sections = Section::all();
        return view('students.create',[
            'sections' => $sections,
        ]);
    }

    public function add(Request $request)
    {
        $request->validate([
            'first_name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:students,email',
            'student_number' => 'required|max:255|unique:students,student_number',
            'section' => 'required',
        ]);

        Student::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'student_number' => $request->student_number,
            'section_id' => $request->section,
            'password' => bcrypt($request->student_number),
        ]);

        return back()->with('success','Successfully added new student!');
    }

    public function edit(Student $student, Request $request)
    {
        $sections = Section::all();
        return view('students.edit', [
            'student' => $student,
            'sections' => $sections,
        ]);
    }

    public function update(Student $student, Request $request)
    {
        $request->validate([
            'first_name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:students,email,'.$student->id,
            'student_number' => 'required|max:255|unique:students,student_number,'.$student->id,
            'section' => 'required',
        ]);

        $student->update([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'student_number' => $request->student_number,
            'section_id' => $request->section,
            // 'password' => bcrypt($request->student_number),
        ]);

        return back()->with('success','Successfully edited student!');
    }

    public function destroy(Student $student, Request $request)
    {
        $student->delete();

        return back()->with('success','Successfully deleted student!');
    }
}
