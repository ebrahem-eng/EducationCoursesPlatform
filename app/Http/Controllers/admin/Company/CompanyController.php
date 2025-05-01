<?php

namespace App\Http\Controllers\admin\Company;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Company;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CompanyController extends Controller
{
    //
   
    public function index()
    {
        $companies = Company::all();
        return view('Admin.Company.index', compact('companies'));
    }

  
    public function create()
    {
        return view('Admin.Company.create');
    }

  
    public function store(Request $request)
    {

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:companies',
            'phone' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'logo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $image = $request->file('logo')->getClientOriginalName();
        $path = $request->file('logo')->storeAs('CompanyImage', $image, 'image');

        Company::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'phone' => $request->input('phone'),
            'address' => $request->input('address'),
            'logo' => $path,
            'website' => $request->input('website'),
            'description' => $request->input('description'),
            'created_by' => Auth::guard('admin')->user()->id,
        ]);

        return redirect()->route('admin.company.index')->with('success_message', 'Company Created Successfully');
    }

    

    public function edit($id)
    {
        $company = Company::findOrfail($id);
        return view('Admin.Company.edit', compact('company'));
    }



    public function update(Request $request, $id)
    {

        $company = Company::findOrFail($id);

        if ($request->file('logo') == null) {
            $company->update([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'phone' => $request->input('phone'),
                'address' => $request->input('address'),
                'website' => $request->input('website'),
                'description' => $request->input('description'),
                'updated_at' => now(),
            ]);

            return redirect()->route('admin.company.index')->with('success_message', 'Company Updated Successfully');
        } else {
            if ($company->logo != null) {
                Storage::disk('image')->delete($company->logo);
                $image = $request->file('logo')->getClientOriginalName();
                $path = $request->file('logo')->storeAs('CompanyImage', $image, 'image');

                $company->update([
                    'name' => $request->input('name'),
                    'email' => $request->input('email'),
                    'phone' => $request->input('phone'),
                    'address' => $request->input('address'),
                    'website' => $request->input('website'),
                    'description' => $request->input('description'),
                    'logo' => $path,
                    'updated_at' => now(),
                ]);

                return redirect()->route('admin.company.index')->with('success_message', 'Company Updated Successfully');
            } else {

                $image = $request->file('logo')->getClientOriginalName();
                $path = $request->file('logo')->storeAs('CompanyImage', $image, 'image');

                $company->update([
                    'name' => $request->input('name'),
                    'email' => $request->input('email'),
                    'phone' => $request->input('phone'),
                    'address' => $request->input('address'),
                    'website' => $request->input('website'),
                    'description' => $request->input('description'),
                    'logo' => $path,
                    'updated_at' => now(),
                ]);
                return redirect()->route('admin.company.index')->with('success_message', 'Company Updated Successfully');
            }
        }
    }

 

    public function delete($id)
    {
        $company = Company::findOrFail($id);

        // Delete logo image from storage if it exists
        if ($company->logo) {
            \Storage::disk('image')->delete($company->logo);
        }

        $company->delete();
        return redirect()->route('admin.company.index')->with('success_message', 'Company Deleted Successfully');
    }

   

    
}
