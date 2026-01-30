<?php

namespace App\Http\Controllers;

use App\Models\Roles;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
    public function users(){
        $users = User::where('statut', '=', 1)->get();
        return view('admin.users', compact('users'));
    }
    public function newUser(){
        return view('admin.newuser');
    }
    public function createUser(Request $request){
        $request->validate([
            'name' => 'required',
            'email' => 'required|unique:users',
            'password' => 'required',
            'language' => 'required',
        ]);
        $user = new User();
        $user->password = Hash::make($request->password);
        $user->email = $request->email;
        $user->name = $request->name;
        $user->language = $request->language;
        $user->save();
        $user->assignRole('admin');
        session()->put('msg', 'user created');
        return redirect('/admin/edit-user/' . $user->id);
    }
    public function editUser(Request $request, int $id){
        $user = User::find($id);
        $success = null;
        if(session()->get('msg') != ''){
            $success = session()->get('msg');
            session()->forget('msg');
        }
        return view('admin.edituser', compact('user', 'success'));
    }
    public function updateUser(Request $request){
        $request->validate([
            'name' => 'required',
            'language' => 'required',
        ]);
        $user = User::find($request->user_id);
        if ($request->password != "")
            $user->password = Hash::make($request->password);
        $user->name = $request->name;
        $user->language = $request->language;
        $user->save();
        session()->put('msg', 'user edited');
        return redirect('/admin/edit-user/' . $user->id);
    }
    public function userRoles(Request $request, int $id){
        $success = null;
        if(session()->get('msg') != ''){
            $success = session()->get('msg');
            session()->forget('msg');
        }
        $user = User::find($id);
        $roles = Roles::orderBy('name', 'asc')->get();
        $user_roles = $user->getRoleNames();
        return view('admin.userroles', compact('user', 'user_roles', 'roles', 'success'));
    }
    public function addUserRol(Request $request, int $id, string $role){
        $user = User::find($id);
        $user->assignRole($role); 
        session()->put('msg', 'rol added');
        return redirect('/admin/user-roles/' . $id);
    }
    public function deleteUserRol(Request $request, int $id, string $role){
        $user = User::find($id);
        $user->removeRole($role);   
        session()->put('msg', 'rol removed');
        return redirect('/admin/user-roles/' . $id);
    }
}
