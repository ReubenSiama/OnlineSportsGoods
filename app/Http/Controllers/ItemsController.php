<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Cart;
use Auth;

class ItemsController extends Controller
{
    public function addToCart(Request $request,$id)
    {
        $cart = Cart::where('item_id',$id)->where('user_id',Auth::user()->id)->first();
        if($cart != null){
            $cart->quantity = $cart->quantity + 1;
            $cart->save();
        }else{
            $cart = New Cart;
            $cart->user_id = Auth::user()->id;
            $cart->item_id = $id;
            $cart->quantity = 1;
            $cart->price = $request->price;
            $cart->save();
        }
        return back();
    }
    public function updateCart($type,$id)
    {
        switch($type){
            case "add":
                $cart = Cart::where('id',$id)->where('user_id',Auth::user()->id)->first();
                $cart->quantity = $cart->quantity + 1;
                $cart->save();
                break;
            case "subtract":
                $cart = Cart::where('id',$id)->where('user_id',Auth::user()->id)->first();
                if($cart->quantity != 1)
                    $cart->quantity = $cart->quantity - 1;
                $cart->save();
                break;
            case "delete":
                $cart = Cart::where('id',$id)->where('user_id',Auth::user()->id)->first();
                $cart->delete();
                break;
        }
        return back();
    }
}
