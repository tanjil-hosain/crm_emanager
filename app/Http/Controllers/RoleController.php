<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function create(){
        return view('crm_emanager.backend.role.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'=>'required|unique:roles,name'
        ]);

        Role::create([
            'name'=>$request->name,
            'guard_name'=>'web'
        ]);
        return redirect()->back()->with('success', 'Role Created Successfully');

    }
}
