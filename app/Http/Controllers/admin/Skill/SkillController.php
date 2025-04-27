<?php

namespace App\Http\Controllers\admin\Skill;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Skill;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class SkillController extends Controller
{
    public function index()
    {
        $skills = Skill::all();
        return view('Admin.Skill.index', compact('skills'));
    }

    public function create()
    {
        return view('Admin.Skill.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255|unique:skills,name',
            'image' => 'required|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        $image = $request->file('image')->getClientOriginalName();
        $path = $request->file('image')->storeAs('SkillImage', $image, 'image');

        Skill::create([
            'name' => $validatedData['name'],
            'image' => $path,
            'created_by' => Auth::guard('admin')->user()->id,
        ]);

        // Add before the route admin.skill
        return redirect()->route('admin.skill.index')->with('success_message', 'Skill Created Successfully');
    }
    

    public function edit($id)
    {
        $skill = Skill::findOrFail($id);
        return view('Admin.Skill.edit', compact('skill'));
    }

    public function update(Request $request, $id)
    {
        $skill = Skill::findOrFail($id);

        // Validate input
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        // Check if the name exists in other records
        $nameExists = Skill::where('name', $validatedData['name'])
            ->where('id', '!=', $id)
            ->exists();

        if ($nameExists) {
            return redirect()->back()->withInput()->with('error_message', 'The skill name has already been taken.');
        }

        // Update logic
        if ($request->file('image') == null) {
            $skill->update([
                'name' => $validatedData['name'],
                'updated_at' => now(),
            ]);
        } else {
            if ($skill->image != null) {
                Storage::disk('image')->delete($skill->image);
            }
            $image = $request->file('image')->getClientOriginalName();
            $path = $request->file('image')->storeAs('SkillImage', $image, 'image');
            $skill->update([
                'name' => $validatedData['name'],
                'image' => $path,
                'updated_at' => now(),
            ]);
        }
        // Add before the route admin.skill
        return redirect()->route('admin.skill.index')->with('success_message', 'Skill Updated Successfully');
    }

    public function delete($id)
    {
        $skill = Skill::findOrFail($id);
        if ($skill->image != null) {
            Storage::disk('image')->delete($skill->image);
        }
        $skill->delete();
        // Add before the route admin.skill
        return redirect()->route('admin.skill.index')->with('success_message', 'Skill Deleted Successfully');
    }
}
