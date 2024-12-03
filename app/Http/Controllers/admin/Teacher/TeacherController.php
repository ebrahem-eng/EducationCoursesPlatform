<?php

namespace App\Http\Controllers\admin\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class TeacherController extends Controller
{
    //

    //عرض صفحة جدول المدرسين

    public function index()
    {
        $teachers = Teacher::all();
        return view('Admin.Teacher.index', compact('teachers'));
    }

    //عرض صفحة اضافة مدرس

    public function create()
    {
        return view('Admin.Teacher.create');
    }

    //تخزين المدرسين في قاعدة البيانات

    public function store(Request $request)
    {
        $password = $request->input('password');
        $image = $request->file('img')->getClientOriginalName();
        $path = $request->file('img')->storeAs('TeacherImage', $image, 'image');

        Teacher::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make($password),
            'phone' => $request->input('phone'),
            'status' => $request->input('status'),
            'age' => $request->input('age'),
            'gender' => $request->input('gender'),
            'img' => $path,
            'created_by' => Auth::guard('admin')->user()->id,
        ]);

        return redirect()->route('admin.teacher.index')->with('success_message', 'Teacher Created Successfully');
    }

    //عرض صفحة تعديل بيانات مدرس

    public function edit($id)
    {
        $teacher = Teacher::findOrfail($id);
        return view('Admin.Teacher.edit', compact('teacher'));
    }

    //تعديل بيانات مدرس داخل قاعدة البيانات

    public function update(Request $request, $id)
    {

        $teacher = Teacher::findOrFail($id);

        if ($request->file('img') == null) {
            $teacher->update([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'phone' => $request->input('phone'),
                'status' => $request->input('status'),
                'age' => $request->input('age'),
                'gender' => $request->input('gender'),
                'updated_at' => now(),
            ]);

            return redirect()->route('admin.teacher.index')->with('success_message', 'Teacher Updated Successfully');
        } else {
            if ($teacher->img != null) {
                Storage::disk('image')->delete($teacher->img);
                $image = $request->file('img')->getClientOriginalName();
                $path = $request->file('img')->storeAs('TeacherImage', $image, 'image');

                $teacher->update([
                    'name' => $request->input('name'),
                    'email' => $request->input('email'),
                    'phone' => $request->input('phone'),
                    'status' => $request->input('status'),
                    'age' => $request->input('age'),
                    'gender' => $request->input('gender'),
                    'img' => $path,
                    'updated_at' => now(),
                ]);

                return redirect()->route('admin.teacher.index')->with('success_message', 'Teacher Updated Successfully');
            } else {

                $image = $request->file('img')->getClientOriginalName();
                $path = $request->file('img')->storeAs('TeacherImage', $image, 'image');

                $teacher->update([
                    'name' => $request->input('name'),
                    'email' => $request->input('email'),
                    'phone' => $request->input('phone'),
                    'status' => $request->input('status'),
                    'age' => $request->input('age'),
                    'gender' => $request->input('gender'),
                    'img' => $path,
                    'updated_at' => now(),
                ]);
                return redirect()->route('admin.teacher.index')->with('success_message', 'Teacher Updated Successfully');
            }
        }
    }

    //عرض صفحة جدول المدرسين المحذوفين

    public function archive()
    {
        $teachers = Teacher::onlyTrashed()->get();
        return view('Admin.Teacher.archive', compact('teachers'));
    }

    //حذف المدرس ونقله للارشيف

    public function softDelete($id)
    {
        $teacher = Teacher::findOrFail($id);

        $teacher->delete();

        return redirect()->route('admin.teacher.index')->with('success_message', 'Teacher Deleted Successfully');
    }

    //حذف مدرس بشكل نهائي

    public function forceDelete($id)
    {
        $teacher = Teacher::withTrashed()->where('id', $id)->first();
        if ($teacher) {
            Storage::disk('image')->delete($teacher->img);
            $teacher->forceDelete();

            return redirect()->route('admin.teacher.archive')->with('success_message', 'Teacher Deleted Successfully');
        } else {
            return redirect()->back()->with('error_message', 'Teacher Not Found');
        }
    }

    //استعادة المدرس المحذوف من الارشيف

    public function restore($id)
    {
        Teacher::withTrashed()->where('id', $id)->restore();

        return redirect()->route('admin.teacher.archive')->with('success_message', 'Teacher Restored Successfully');
    }
}
