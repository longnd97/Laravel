<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateBookRequest;
use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class BookController extends Controller implements BaseInterface
{
    function index()
    {
        $books = Book::all();
        $categories = Category::all();
        return view('books.list', compact('books', 'categories'));

    }

    function create()
    {
        $categories = Category::all();
        return view('books.add', compact('categories'));
    }

    function destroy($id)
    {
        $book = Book::findOrFail($id);
        $book->delete();
        Session::flash('success', 'Xóa sách thành công');
        return redirect()->route('books.index');
    }

    function store(CreateBookRequest $request)
    {
        $book = new Book();
        $book->name = $request->name;
        $book->desc = $request->desc;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $path = $image->store('images', 'public');
            $book->image = $path;
        }
        $book->status = $request->status;
        $book->price = $request->price;
        $book->category_id = $request->category_id;
        $book->save();
        Session::flash('success', 'Tạo mới sách thành công');
        return redirect()->route('books.index');

    }

    function edit($id)
    {
        $book = Book::findOrFail($id);
        $categories = Category::all();
        return view('books.update', compact('book', 'categories'));
    }

    function update(Request $request, $id)
    {
        $book = Book::findOrFail($id);
        $book->name = $request->name;
        $book->save();
        Session::flash('success', 'Cập nhật sách thành công');
        return redirect()->route('books.index');
    }

    public function search(Request $request)
    {
        $keyword = $request->input('keyword');
        if (!$keyword) {
            return redirect()->route('books.index');
        }
        $books = Book::where('name', 'LIKE', '%' . $keyword . '%');
        return view('books.list', compact('books'));
    }
}
