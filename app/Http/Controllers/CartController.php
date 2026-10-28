<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|integer', 
            'qty' => 'required|integer',
        ]);

        $data = $request->all();

        $product = Product::findOrFail($data['product_id']);
        $cart = new Cart();
        $cart->addToCart($product, $data['qty']);

        return view('cart.cart-modal');
    }

    public function show()
    {
        return view('cart.cart-modal');
    }

    public function delItem($product_id)
    {
        $cart = new Cart();
        $cart->delItem($product_id);
        return view('cart.cart-modal');
    }

    public function clear()
    {
        session()->forget('cart');        
        session()->forget('cart_qty');
        session()->forget('cart_total');  
        return view('cart.cart-modal');  
    }
}