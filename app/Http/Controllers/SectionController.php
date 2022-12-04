<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Section;

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
        return view('sections.create');
    }

    public function add(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255|unique:sections,name',
        ]);

        Section::create([
            'name' => $request->name,
        ]);

        return back()->with('success','Successfully added new section!');
    }

    public function edit(Section $section, Request $request)
    {
        // dd($section->name);
        return view('sections.edit', [
            'section' => $section,
        ]);
    }

    public function update(Section $section, Request $request)
    {
        $request->validate([
            'name' => 'required|max:255|unique:sections,name,'.$section->id,
        ]);

        $section->update([
            'name' => $request->name,
        ]);

        return back()->with('success','Successfully edited section!');
    }

    public function destroy(Section $section, Request $request)
    {
        $section->delete();

        return back()->with('success','Successfully deleted section!');
    }
}
