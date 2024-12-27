<?php

namespace App\Http\Controllers\admin\Category;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    //عرض صفحة جدول الفئات

    public function index()
    {
        $categories = Category::where('parent_id' , null)->get();
        return view('Admin.Category.category', compact('categories'));
    }

     //عرض صفحة جدول الفئات الفرعية
    public function subCategoryIndex()
    {
        $subCategories = Category::where('parent_id' ,'!=', null)->get();
        return view('Admin.Category.subCategory', compact('subCategories'));
    }

    //عرض صفحة اضافة فئة

    public function create()
    {
        return view('Admin.Category.create');
    }

    //عرض صفحة اضافة فئة فرعية
    public function subCategoryCreate()
    {
        $categories = Category::where('parent_id' , null)->get();
        return view('Admin.Category.subCategoryCreate' , compact('categories'));
    }

    //تخزين الفئات في قاعدة البيانات

    public function store(Request $request)
    {

        $image = $request->file('img')->getClientOriginalName();
        $path = $request->file('img')->storeAs('CategoryImage', $image, 'image');

        Category::create([
            'name' => $request->input('name'),
            'code' => $request->input('code'),
            'status' => $request->input('status'),
            'parent_id' => null,
            'priority' => $request->input('priority'),
            'img' => $path,
            'created_by' => Auth::guard('admin')->user()->id,
        ]);

        return redirect()->route('admin.category.index')->with('success_message', 'Category Created Successfully');

    }

    //تخزين الفئات الفرعية في قاعدة البيانات
    public function subCategoryStore(Request $request)
    {

        $image = $request->file('img')->getClientOriginalName();
        $path = $request->file('img')->storeAs('CategoryImage', $image, 'image');

        $checkExists = Category::where('name',$request->input('name'))->where('code',$request->input('code'))->where('parent_id' , $request->input('parent_id'))->first();
        if($checkExists){
            return redirect()->back()->with('error_message', 'Category already exists');
        }
        Category::create([
            'name' => $request->input('name'),
            'code' => $request->input('code'),
            'status' => $request->input('status'),
            'parent_id' => $request->input('parent_id'),
            'priority' => $request->input('priority'),
            'img' => $path,
            'created_by' => Auth::guard('admin')->user()->id,
        ]);


            return redirect()->route('admin.category.sub.category.index')->with('success_message', 'Sub Category Created Successfully');

    }

    //عرض صفحة تعديل بيانات فئة

    public function edit($id)
    {
        $category = Category::findOrfail($id);
        return view('Admin.Category.edit', compact('category'));
    }

    //عرض صفحة تعديل بيانات فئة فرعية

    public function subCategoryEdit($id)
    {
        $category = Category::findOrfail($id);
        $categories = Category::where('parent_id' , null)->get();
        return view('Admin.Category.subCategoryEdit', compact('category' , 'categories'));
    }

    //تعديل بيانات فئة داخل قاعدة البيانات

    public function update(Request $request, $id)
    {

        $category = Category::findOrFail($id);

        if($request->input('parent_id') != 0){
            return redirect()->back()->with('error_message','Cant Convert Category To Sub Category');
        }
        if ($request->file('img') == null) {

            $this->updateCategoryDataWithoutImage($category,$request);

            return redirect()->route('admin.category.index')->with('success_message', 'Category Updated Successfully');
        } else {
            if ($category->img != null) {

                $image = $request->file('img')->getClientOriginalName();
                $path = $request->file('img')->storeAs('CategoryImage', $image, 'image');

                Storage::disk('image')->delete($category->img);

                $this->updateCategoryData($category,$request,$path);

                return redirect()->route('admin.category.index')->with('success_message', 'Category Updated Successfully');
            } else {

                $image = $request->file('img')->getClientOriginalName();
                $path = $request->file('img')->storeAs('CategoryImage', $image, 'image');

              $this->updateCategoryData($category,$request,$path);

                return redirect()->route('admin.category.index')->with('success_message', 'Category Updated Successfully');
            }
        }
    }

    //تعديل بيانات فئة فرعية داخل قاعدة البيانات
    public function subCategoryUpdate(Request $request, $id)
    {

        $category = Category::findOrFail($id);

        if ($request->file('img') == null) {

            $this->updateCategoryDataWithoutImage($category,$request);

            return redirect()->route('admin.category.sub.category.index')->with('success_message', 'Sub Category Updated Successfully');
        } else {
            if ($category->img != null) {

                $image = $request->file('img')->getClientOriginalName();
                $path = $request->file('img')->storeAs('CategoryImage', $image, 'image');

                Storage::disk('image')->delete($category->img);

                $this->updateCategoryData($category,$request,$path);

                return redirect()->route('admin.category.sub.category.index')->with('success_message', 'Sub Category Updated Successfully');
            } else {

                $image = $request->file('img')->getClientOriginalName();
                $path = $request->file('img')->storeAs('CategoryImage', $image, 'image');

                $this->updateCategoryData($category,$request,$path);

                return redirect()->route('admin.category.sub.category.index')->with('success_message', 'Sub Category Updated Successfully');
            }
        }
    }

    //عرض صفحة جدول الفئات المحذوفين

    public function archive()
    {
        $categories = Category::onlyTrashed()->where('parent_id',null)->get();
        return view('Admin.Category.archive', compact('categories'));
    }

    public function subCategoryArchive()
    {
        $subCategories = Category::onlyTrashed()->where('parent_id' , '!=' , null)->get();
        return view('Admin.Category.subCategoryArchive', compact('subCategories'));
    }

    //حذف فئة ونقلها للارشيف

    public function softDelete($id)
    {
        $category = Category::findOrFail($id);

        $category->delete();

        if($category->parent_id != 0 )
        {
            return redirect()->route('admin.category.sub.category.index')->with('success_message', 'Sub Category Deleted Successfully');
        }

        return redirect()->route('admin.category.index')->with('success_message', 'Category Deleted Successfully');

    }

    //حذف فئة بشكل نهائي

    public function forceDelete($id)
    {
        $category = Category::withTrashed()->where('id', $id)->first();
        $type = '';
        if ($category) {
            Storage::disk('image')->delete($category->img);
            $category->forceDelete();
            if($category->parent_id != 0 )
            {
                $type = 'subCategory';
                return redirect()->route('admin.category.sub.category.archive')->with('success_message', $type.'Deleted Successfully');

            }else{
                $type = 'category';
                return redirect()->route('admin.category.archive')->with('success_message', $type.'Deleted Successfully');
            }
        } else {
            return redirect()->back()->with('error_message', 'Category Not Found');
        }
    }

    //استعادة الفئات المحذوفة من الارشيف

    public function restore($id)
    {
        $type = '';
        $category = Category::withTrashed()->where('id', $id)->first();
        $category->restore();

        if($category->parent_id != 0 )
        {
            $type = 'subCategory';
            return redirect()->route('admin.category.sub.category.archive')->with('success_message', $type.'Restored Successfully');
        }else{
            $type = 'category';
            return redirect()->route('admin.category.archive')->with('success_message', $type.'Restored Successfully');
        }
    }


   public function updateCategoryData($category, $request, $path = null)
    {
        return $category->update([
            'name' => $request->input('name'),
            'code' => $request->input('code'),
            'status' => $request->input('status'),
            'parent_id' => $request->input('parent_id'),
            'priority' => $request->input('priority'),
            'img' => $path,
            'updated_at' => now(),
        ]);
    }

    public function updateCategoryDataWithoutImage($category, $request)
    {
        return $category->update([
            'name' => $request->input('name'),
            'code' => $request->input('code'),
            'status' => $request->input('status'),
            'parent_id' => $request->input('parent_id'),
            'priority' => $request->input('priority'),
            'updated_at' => now(),
        ]);
    }
}
