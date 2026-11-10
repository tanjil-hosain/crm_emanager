<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::all();
        return view('crm_emanager.backend.profile.index' , compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
       $roles= Role::all();
        return view('crm_emanager.backend.profile.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'role'=> 'required|exists:roles,name',
            'mobile' => 'nullable|string',
            'address' => 'nullable',
            'photo' => 'nullable|image|mimes:png,jpg'
        ]);


        $photo = null;

        if ($request->hasFile('photo')) {
            $photo = uploadImage($request->file('photo') , 'uploads/users');
        }

       $user= User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
            'mobile' => $request->mobile,
            'address' => $request->address,
            'photo' => $photo,
        ]);
       
        $user->assignRole($request->role);
        return redirect()->route('users.index')
            ->with('success', 'User created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = User::findOrFail($id);
        $roles = Role::all();
        return view('crm_emanager.backend.profile.edit', compact('user', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
            $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'role' => 'required|exists:roles,name',
            'mobile' => 'nullable|string',
            'address' => 'nullable',
            'photo' => 'nullable|image|mimes:png,jpg'
        ]);


        $user = User::findOrFail($id);
        $photo = $user->photo;

        if ($request->hasFile('photo')) {
            $photo = uploadImage($request->file('photo') , 'uploads/users', $user->photo);
        }

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'mobile' => $request->mobile,
            'address' => $request->address,
            'photo' => $photo,
        ]);

        $user->syncRoles([$request->role]);
        return redirect()->route('users.index')
            ->with('success', 'User Updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::findOrFail($id);

        $user->delete();
        return redirect()->route('users.index')->with('success', 'Usere deleted');
        
    }

    public function trash(){
        $users = User::onlyTrashed()->latest()->get();

        return view('crm_emanager.backend.profile.trash', compact('users'));
    }

    public function restore($id){
        $user= User::onlyTrashed()->findOrFail($id);
        $user->restore();

        return redirect()->route('users.trash')->with('success', 'User restored');

    }

    public function forceDelete($id){
        $user = User::onlyTrashed()->findOrFail($id);

        $user->forceDelete();
        return redirect()->route('users.trash')->with('success', 'User Permanently deleted');
    }
}
