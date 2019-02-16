<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Razorpay\Api\Api;
use Auth;
use App\Item;
use App\ItemCategory as Category;
use App\Brand;
use App\Advertisement;
use App\FeatureItem;
use App\Cart;
use App\Order;
use App\OrderedItem;
use App\Payment;

class HomeController extends Controller
{
    public function index()
    {
        $featuredIds = FeatureItem::pluck('item_id');
        $items = Item::whereNotIn('id',$featuredIds)->paginate(20);
        $advertisements = Advertisement::where('status','Display')->get();
        $featuerdItems = FeatureItem::get();
        return view('home',['items'=>$items,'advertisements'=>$advertisements,'featuredItems'=>$featuerdItems]);
    }
    public function getLogin()
    {
        if(Auth::check() || Auth::viaRemember()){
            return redirect('/');
        }
        return view('pages.login');
    }
    public function logout()
    {
        Auth::logout();
        return back();
    }
    public function searchItem(Request $request)
    {
        if(Auth::check())
            $cart = $cart = Auth::user()->cart->count();
        else
            $cart = 0;
        $result = Item::where('item_name','LIKE','%'.$request->q.'%')
                    ->get();
        return view('pages.search',['result'=>$result]);
    }
    public function getCategory($category)
    {
        $category = Category::where('category_name',$category)->first();
        return view('pages.itemGroups',['items'=>$category->item]);
    }
    public function getBrands($brand)
    {
        $brands = Brand::where('brand_name',$brand)->first();
        return view('pages.itemGroups',['items'=>$brands->item]);
    }
    public function getContact()
    {
        return view('pages.contactUs');
    }
    public function Cart()
    {
        $cart_list = Cart::where('user_id',Auth::user()->id)->get();
        $cart = Auth::user()->cart->count();
        return view('pages.cart',['cart_list'=>$cart_list]);
    }
    public function checkout()
    {
        return view('pages.checkout');
    }
    public function placeOrder(Request $request)
    {
        $type = $request->type;
        $shippingAddress = $request->address;
        $data = [
            $shippingAddress,
            $request->all()
        ];
        switch($type){
            case "Cash On Delivery":
                return $this->saveOrder($data);
                break;
            case "Online":
                $api_key = "rzp_test_IHD5kg3JafsZh8";
                $api_secret = "BN2cNs9hLfNHqu9aMVtNSr90";
                $payment_id = $request->razorpay_payment_id;
                $api = new Api($api_key, $api_secret);
                $payment = $api->payment->fetch($payment_id);
                $captured = $payment->capture(array('amount' => $request->amount));
                if($captured->captured == "true"){
                    return $this->saveOrder($data);
                }else{
                    return back()->with('Error','Payment Not Successful');
                }
                break;
        }
    }
    public function saveOrder($request)
    {
        $order = New Order;
        $order->order_number = uniqid("OSG");
        $order->user_id = Auth::user()->id;
        $order->shipping_address_id = $request[0];
        $order->status = "Order Placed";
        $order->payment_type = $request[1]['type'];
        $order->payment_status = $request[1]['type'] == "Cash On Delivery" ? 'Pending' : 'Paid';
        $order->save();
        foreach(Auth::user()->cart as $cart){
            $orderItem = New OrderedItem;
            $orderItem->order_id = $order->id;
            $orderItem->item_id = $cart->item_id;
            $orderItem->quantity = $cart->quantity;
            $orderItem->price = $cart->price;
            $orderItem->amount = $cart->price * $cart->quantity;
            $orderItem->save();
            $cart->delete();
            if($order->payment_type == "Online"){
                $payment = New Payment;
                $payment->order_id = $order->id;
                $payment->user_id = $order->user_id;
                $payment->item_id = $orderItem->item_id;
                $payment->quantity = $orderItem->quantity;
                $payment->amount = $orderItem->amount;
                $payment->save();
            }
        }
        return $this->sendSMS($order);
    }
    public function getOrders()
    {
        return view('pages.orders');
    }
    public function cancelOrder($id)
    {
        $order = Order::findOrFail($id);
        $order->status = "Cancelled";
        $order->save();
        return back();
    }
    public function sendSMS($order)
    {
        $username = Auth::user()->name;
        $orderNumber = $order->order_number;
        $address1 = $order->shippingAddress->address_line_1;
        $city = $order->shippingAddress->city;
        $state = $order->shippingAddress->state;
        $text = "Hello $username, your order has been placed successfully. Your order number is $orderNumber and will be delivered to $address1, $city, $state.";
        $number = $order->shippingAddress->contact;
        $postFields = "{ \"sender\": \"OSPORT\", \"route\": \"4\", \"country\": \"91\", \"sms\": [ { \"message\": \"$text\", \"to\": [ \"$number\" ] } ] }";
        $curl = \curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "http://api.msg91.com/api/v2/sendsms",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => $postFields,
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_HTTPHEADER => array(
                "authkey: 262963AwvPTRWWlKc5c6629ce",
                "content-type: application/json"
            ),
        ));
        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            echo $response;
        }
        return redirect()->route('orders');
    }
    public function changeStatus($status,$id)
    {
        $order = Order::findOrFail($id);
        $order->status = $status;
        if($status == "Delivered" && $order->payment_status == "Pending"){
            $order->payment_status = "Paid";
        }
        $order->save();
        return back();
    }
    public function viewOrder($id)
    {
        $order = Order::findOrFail($id);
        return view('vendor.voyager.orders.orderedItems',['order'=>$order]);
    }
}
