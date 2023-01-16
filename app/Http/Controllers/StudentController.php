<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Section;
use App\Models\User;
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
            'email' => 'required|email|max:255|unique:users,email',
            'student_number' => 'required|max:255|unique:students,student_number',
            'section' => 'required',
        ]);

        $user = User::create([
            'name' => $request->first_name . ' ' . $request->last_name,
            'email' => $request->email,
            'user_type_id' => 2,
            'password' => $request->student_number,
        ]);

        Student::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'student_number' => $request->student_number,
            'section_id' => $request->section,
            'user_id' => $user->id,
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
            'email' => 'required|email|max:255|unique:users,email,'.$student->user->user_id,
            'student_number' => 'required|max:255|unique:students,student_number,'.$student->id,
            'section' => 'required',
        ]);

        $student->user->update([
            'name' => $request->first_name . ' ' . $request->last_name,
            'email' => $request->email,
            // 'password' => bcrypt($request->student_number),
        ]);

        $student->update([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'student_number' => $request->student_number,
            'section_id' => $request->section,
            // 'password' => bcrypt($request->student_number),
        ]);

        return back()->with('success','Successfully edited student!');
    }

    public function destroy(Student $student, Request $request)
    {
        $student->user()->delete();
        $student->delete();

        return back()->with('success','Successfully deleted student!');
    }
}
