<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateCategoryRequest;
use App\Models\Category;
use Illuminate\Support\Facades\Session;

class CategoryController extends Controller implements BaseInterface
{
    function index()
    {
        $categories = Category::all();
        return view('categories.list', compact('categories'));

    }

    function create()
    {
        return view('categories.add');
    }

    function destroy($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();
        Session::flash('success', 'Xóa thể loại thành công');
        return redirect()->route('categories.index');
    }

    function store(CreateCategoryRequest $request)
    {
        $category = new Category();
        $category->name = $request->name;
        $category->save();
        Session::flash('success', 'Tạo mới thể loại thành công');
        return redirect()->route('categories.index');

    }

    function edit($id)
    {
        $category = Category::findOrFail($id);
        return view('categories.update', compact('category'));
    }

    function update(UpdateCategoryRequest $request, $id)
    {
        $category = Category::findOrFail($id);
        $category->name = $request->name;
        $category->save();
        Session::flash('success', 'Cập nhật thể loại thành công');
        return redirect()->route('categories.index');
    }
}
