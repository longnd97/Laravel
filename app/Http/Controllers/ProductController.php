<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $books = Book::all();
        return view('frontend.products.list', compact('books'));
    }

    public function addToCart($id)
    {
        $book = Book::findOrFail($id);
        $cart = session()->get('cart', []);
        if (isset($cart[$id])) {
            $cart[$id]['quantity']++;
        } else {
            $cart[$id] = [
                'name' => $book->name,
                'price' => $book->price,
                'quantity' => 1
            ];
        }
        session()->put('cart', $cart);
        return redirect()->back();
    }

    public function showCart()
    {
        $cart = session()->get('cart', []);
        return view('frontend.products.cart', compact('cart'));
    }

    public function removeItem($id)
    {
        $cart=session()->get('cart',[]);
        unset($cart[$id]);
        session()->put('cart',$cart);
        return redirect()->back();
    }

    public function updateItem($id,$quantity)
    {
        $cart=session()->get('cart',[]);
        $cart[$id]['quantity']=$quantity;
        session()->put('cart',$cart);
        return redirect()->back();
    }
}
