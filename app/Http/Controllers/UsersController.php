<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use App\ShippingAddress;
use App\User;
use App\Cart;
use Auth;

class UsersController extends Controller
{
    public function postRegister(UserRequest $request)
    {
        $user = New User;
        $user->role_id = 2;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->save();
        Auth::login($user);
        return redirect('/');
    }
    public function postLogin(Request $request)
    {
        $remember = $request->remember ? 1:0;
        if(Auth::attempt(['email'=>$request->email,'password'=>$request->password],$remember)){
            return back();
        }else{
            return back()->with('Error','Username or password incorrect');
        }
    }
    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }
    public function getAccount(Request $request)
    {
        $cart = Auth::user()->cart->count();
        if($request->edit){
            $address = ShippingAddress::findOrFail($request->edit);
        }else{
            $address = null;
        }
        return view('pages.account',['cart'=>$cart,'addressEdit'=>$address]);
    }
    public function addAddress(Request $request)
    {
        if($request->id){
            $address = ShippingAddress::findOrFail($request->id);
        }else{
            $address = New ShippingAddress;
        }
        $address->user_id = Auth::user()->id;
        $address->name = $request->name;
        $address->address_line_1 = $request->address_one;
        $address->address_line_2 = $request->address_two;
        $address->contact = $request->contact;
        $address->city = $request->city;
        $address->state = $request->state;
        $address->pin_code = $request->pin;
        $address->address_type = $request->address_type;
        $address->save();
        return redirect()->route('account');
    }
    public function updateUser(Request $request)
    {
        $user = Auth::user();
        $user->name = $request->name;
        $user->email = $request->email;
        if($request->password)
            $user->password = bcrypt($request->password);
        $user->save();
        return back();
    }
    public function deleteAddress($id)
    {
        $address = ShippingAddress::findOrFail($id);
        $address->delete();
        return back();
    }
}
