<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class UserController extends Controller implements BaseInterface, UserInterface
{

    function index()
    {
        $users = User::all();
        return view('users.list', compact('users'));

    }

    function detail($id)
    {
        echo $id;
    }

    function getComment($idUser, $idComment = 1)
    {

    }

    function create()
    {
        $roles = Role::all();
        return \view('users.add', compact('roles'));
    }

    function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->roles()->detach();
        $user->delete();
        Session::flash('success', 'Xóa người dùng thành công');
        return redirect()->route('users.index');
    }

    function getPostOfUser($idUser)
    {
    }

    function store(CreateUserRequest $request)
    {
        DB::beginTransaction();
        try {
            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = $request->password;
            $user->save();
            $user->roles()->sync($request->role);
            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
        }
        Session::flash('success', 'Tạo mới người dùng thành công');
        return redirect()->route('users.index');

    }

    function edit($id)
    {
        $user = User::findOrFail($id);
        $roles = Role::all();
        return view('users.update', compact('user', 'roles'));
    }

    function update(UpdateUserRequest $request, $id)
    {
        DB::beginTransaction();
        try {
            $user = User::findOrFail($id);
            $user->name = $request->name;
            $user->email = $request->email;
            $user->save();
            $user->roles()->sync($request->role);
            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
        }
        Session::flash('success', 'Cập nhật người dùng thành công');
        return redirect()->route('users.index');
    }

    public function search(Request $request)
    {
        $keyword = $request->input('keyword');
        if (!$keyword) {
            return redirect()->route('users.index');
        }
        $users = User::where('name', 'LIKE', '%' . $keyword . '%');
        return view('users.list', compact('users'));
    }
}
