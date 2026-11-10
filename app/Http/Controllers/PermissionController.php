<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission as ModelsPermission;

class PermissionController extends Controller
{
    public function create(){
         return view('crm_emanager.backend.permission.create');
    }

    public function store( Request $request){
        $request->validate([
            'name' => 'required|string|unique:permissions,name'
        ]);

        ModelsPermission::create([
            'name'=>$request->name

        ]);
        return redirect()->back()->with('success', 'Permission Created Successfully');

    }
   
}
