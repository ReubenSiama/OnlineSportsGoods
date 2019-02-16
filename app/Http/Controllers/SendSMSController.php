<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class SendSMSController extends Controller
{
    public function sendSMS($number,$text)
    {
        // $username = Auth::user()->name;
        // $orderNumber = $order->order_number;
        // $address1 = $order->shippingAddress->address_line_1;
        // $city = $order->shippingAddress->city;
        // $state = $order->shippingAddress->state;
        // if($order->status == "Order Placed"){
        //     $text = "Hello $username, your order has been placed successfully. Your order number is $orderNumber and will be delivered to $address1, $city, $state.";
        // }elseif($order->status == "Cancelled"){
        //     $text = "Hello $username, your order $orderNumber has been cancelled.";
        // }
        // $number = $order->shippingAddress->contact;
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
        // return redirect()->route('orders');
    }
}
