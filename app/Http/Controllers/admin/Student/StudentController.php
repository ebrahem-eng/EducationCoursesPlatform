<?php

namespace App\Http\Controllers\admin\Student;

use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class StudentController extends Controller
{
    //

    public function index()
    {
        $students = Student::all();
        return view("Admin.Student.index",compact('students'));
    }

    public function edit($id)
    {
        $student = Student::findOrFail($id);
        return view('Admin.Student.edit',compact('student'));
    }

    public function update(Request $request, $id)
    {

        $student = Student::findOrFail($id);

        if ($request->file('img') == null) {
            $student->update([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'phone' => $request->input('phone'),
                'status' => $request->input('status'),
                'age' => $request->input('age'),
                'gender' => $request->input('gender'),
                'updated_at' => now(),
            ]);

            return redirect()->route('admin.student.index')->with('success_message', 'Student Updated Successfully');
        } else {
            if ($student->img != null) {
                $userImageDirectory = 'StudentImage/' . $student->id;
                Storage::disk('image')->delete($student->img);
                $image = $request->file('img')->getClientOriginalName();
                $path = $request->file('img')->storeAs($userImageDirectory, $image, 'image');

                $student->update([
                    'name' => $request->input('name'),
                    'email' => $request->input('email'),
                    'phone' => $request->input('phone'),
                    'status' => $request->input('status'),
                    'age' => $request->input('age'),
                    'gender' => $request->input('gender'),
                    'img' => $path,
                    'updated_at' => now(),
                ]);

                return redirect()->route('admin.student.index')->with('success_message', 'Student Updated Successfully');
            } else {
                $userImageDirectory = 'StudentImage/' . $student->id;
                $image = $request->file('img')->getClientOriginalName();
                $path = $request->file('img')->storeAs($userImageDirectory, $image, 'image');

                $student->update([
                    'name' => $request->input('name'),
                    'email' => $request->input('email'),
                    'phone' => $request->input('phone'),
                    'status' => $request->input('status'),
                    'age' => $request->input('age'),
                    'gender' => $request->input('gender'),
                    'img' => $path,
                    'updated_at' => now(),
                ]);
                return redirect()->route('admin.student.index')->with('success_message', 'Student Updated Successfully');
            }
        }
    }
}
