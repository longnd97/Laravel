<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
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
        return \view('users.add');
    }

    function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        Session::flash('success', 'Xóa người dùng thành công');
        return redirect()->route('users.index');
    }

    function getPostOfUser($idUser)
    {
    }

    function store(CreateUserRequest $request)
    {
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = $request->password;
        $user->save();
        Session::flash('success', 'Tạo mới người dùng thành công');
        return redirect()->route('users.index');

    }

    function edit($id)
    {
        $user = User::findOrFail($id);
        return view('users.update', compact('user'));
    }

    function update(UpdateUserRequest $request, $id)
    {
        $user = User::findOrFail($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->save();
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
