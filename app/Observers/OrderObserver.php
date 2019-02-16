<?php

namespace App\Observers;

use App\Order;
use App\Payment;
use App\Http\Controllers\SendSMSController;
use Auth;

class OrderObserver
{
    /**
     * Handle the order "created" event.
     *
     * @param  \App\Order  $order
     * @return void
     */
    public function created(Order $order)
    {
        //
    }

    /**
     * Handle the order "updated" event.
     *
     * @param  \App\Order  $order
     * @return void
     */
    public function updated(Order $order)
    {
        $username = $order->user->name;
        $orderNumber = $order->order_number;
        $number = $order->shippingAddress->contact;
        $status = $order->status;
        $text2 = $order->payment_type == "Cash On Delivery" ? "Please pay the amount payable." : "";
        switch($status){
            case 'Confirmed':
                $text = "Hello $username, your order $orderNumber has been confirmed. Thank you for shopping with us.";
                break;
            case 'Dispatched':
                $text = "Hello $username, your order $orderNumber has been dispatched. Thank you for shopping with us.";
                break;
            case 'Arriving Today':
                $text = "Arriving today!! Hello $username, your order $orderNumber will arrive today. $text2";
                break;
            case 'Delivered':
                $text = "Hello $username, your order $orderNumber has been delivered.";
                if($order->payment_type == "Cash On Delivery"){
                    foreach($order->orderedItem as $orderItem){
                        $payment = New Payment;
                        $payment->order_id = $order->id;
                        $payment->user_id = $order->user_id;
                        $payment->item_id = $orderItem->item_id;
                        $payment->quantity = $orderItem->quantity;
                        $payment->amount = $orderItem->amount;
                        $payment->save();
                    }
                }
                break;
            case 'Cancelled':
                $text = "You have cancelled your order $orderNumber";
                break;
        }
        $sendSMS = New SendSMSController;
        $sendSMS->sendSMS($number,$text);
    }

    /**
     * Handle the order "deleted" event.
     *
     * @param  \App\Order  $order
     * @return void
     */
    public function deleted(Order $order)
    {
        //
    }

    /**
     * Handle the order "restored" event.
     *
     * @param  \App\Order  $order
     * @return void
     */
    public function restored(Order $order)
    {
        //
    }

    /**
     * Handle the order "force deleted" event.
     *
     * @param  \App\Order  $order
     * @return void
     */
    public function forceDeleted(Order $order)
    {
        //
    }
}
