@extends('layout.master')
@section('title','Checkout')
@section('content')

<section id="cart_items">
    <div class="container">
        <div class="breadcrumbs">
            <ol class="breadcrumb">
                <li><a href="#">Home</a></li>
                <li class="active">Shopping Cart</li>
            </ol>
        </div>
        <div class="table-responsive cart_info">
            <table class="table table-condensed">
                <thead>
                    <tr class="cart_menu">
                        <td class="image">Item</td>
                        <td class="description"></td>
                        <td class="price">Price</td>
                        <td class="quantity text-center">Quantity</td>
                        <td class="total">Total</td>
                        <td></td>
                    </tr>
                </thead>
                <tbody>
                    @php $sub_total = 0; $gst = 0; $gst_cost = 0; @endphp
                    @foreach(Auth::user()->cart as $carts)
                    <tr>
                        <td class="cart_product">
                            @php $image = json_decode($carts->item->image) @endphp
                            <!-- <div class="cart-image"> -->
                                <img class="img img-responsive" height="100" width="100" src="{{ Voyager::image($image[0]) }}" alt="{{ $carts->item->item_name }}">
                            <!-- </div> -->
                        </td>
                        <td class="cart_description">
                            <h4>{{ $carts->item->item_name }}</h4>
                            <br>
                        </td>
                        <td class="cart_price">
                            <p>₹{{ $carts->price }}</p>
                        </td>
                        <td class="cart_quantity text-center">
                                {{ $carts->quantity }}
                        </td>
                        <td class="cart_total">
                            <p class="cart_total_price">₹{{ $carts->price * $carts->quantity }}</p>
                        </td>
                    </tr>
                    @php
                        $sub_total += $carts->price * $carts->quantity;
                        $gst_cost = 18/100 * ($carts->price * $carts->quantity);
                        $gst += $gst_cost;
                    @endphp
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</section> <!--/#cart_items-->
@if(Auth::user()->cart->count() != 0)
<section id="do_action">
    <div class="container">
        <div class="row">
            <div class="col-sm-6 col-sm-offset-3">
                <div class="total_area">
                    <ul>
                        <li>Cart Sub Total <span>₹{{ $sub_total }}</span></li>
                        <li>GST <span>₹{{ $gst }}</span></li>
                        <li>Total <span>₹{{ $sub_total + $gst_cost }}</span></li>
                    </ul>
                    <br>
                    <div class="payment-options" style="margin:0;">
                            <span>
                                <label onclick="paymentType('Cash On Delivery')"><input type="radio" name="payment_mode" value="Cash On Delivery"> Cash On Delivery</label>
                            </span>
                        <span>
                            <label onclick="paymentType('Online')"><input checked type="radio" name="payment_mode" value="Online"> Online Payment</label>
                        </span>
                        <br>
                        <form id="razorpay" action="{{ route('placeOrder') }}?type=Online" method="POST">
                            <ul id="onlinePay">
                                <li>
                                    Shipping Address:
                                    <ul class="list-group">
                                        @php $count = 1; @endphp
                                        @foreach(Auth::user()->shippingAddress as $address)
                                        <li class="list-group-item radio" style="background-color: white;">
                                            <label onclick="setAddress('{{ $address->id }}')">
                                                    {{ $address->name }}
                                                    <br>
                                                    {{ $address->address_line_1 }}
                                                    <br>
                                                    {{ $address->address_line_2 }},
                                                <br>
                                                <input {{ $count == 1 ? 'checked' : '' }} type="radio" name="address" value="{{ $address->id }}" class="pull-right">
                                                {{ $address->city }}, {{ $address->state }}
                                                <br>
                                                Pin Code : {{ $address->pin_code }}
                                                <br>
                                                Contact : {{ $address->contact }}
                                                <br>
                                                Address Type : {{ $address->address_type }}
                                            </label>
                                        </li>
                                        @php $count++ @endphp
                                        @endforeach
                                    </ul>
                                </li>
                            </ul>
                            @csrf()
                            <input type="hidden" name="amount" value="{{ ($sub_total + $gst_cost) * 100 }}">
                            <!-- Note that the amount is in paise = 50 INR -->
                            <script
                                src="https://checkout.razorpay.com/v1/checkout.js"
                                data-key="rzp_test_IHD5kg3JafsZh8"
                                data-amount="{{ ($sub_total + $gst_cost) * 100 }}"
                                data-buttontext="Place Order"
                                data-name="E Shopper"
                                data-description="Checkout"
                                data-image=""
                                data-prefill.name=""
                                data-prefill.email=""
                                data-theme.color="#F37254">
                            </script>
                            <input type="hidden" value="Hidden Element" name="hidden">
                        </form>
                        <form action="{{ route('placeOrder') }}?type=Cash On Delivery" method="POST">
                            @csrf
                            <ul id="cashOD" class="hidden">
                                <li>
                                    Shipping Address:
                                    <ul class="list-group">
                                        @php $count = 1; @endphp
                                        @foreach(Auth::user()->shippingAddress as $address)
                                        <li class="list-group-item radio" style="background-color: white;">
                                            <label onclick="setAddress('{{ $address->id }}')">
                                                    {{ $address->name }}
                                                    <br>
                                                    {{ $address->address_line_1 }}
                                                    <br>
                                                    {{ $address->address_line_2 }},
                                                <br>
                                                <input {{ $count == 1 ? 'checked' : '' }} type="radio" value="{{ $address->id }}" name="address" class="pull-right">
                                                {{ $address->city }}, {{ $address->state }}
                                                <br>
                                                Pin Code : {{ $address->pin_code }}
                                                <br>
                                                Contact : {{ $address->contact }}
                                                <br>
                                                Address Type : {{ $address->address_type }}
                                            </label>
                                        </li>
                                        @php $count++ @endphp
                                        @endforeach
                                    </ul>
                                </li>
                            </ul>
                            <button id="cod" type="submit" class="hidden">Place Order</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section><!--/#do_action-->
@endif
<script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
<script>
    function paymentType(arg){
        if(arg == "Cash On Delivery"){
            document.getElementById('cod').className = "razorpay-payment-button";
            document.getElementById('razorpay').className = "hidden";
            document.getElementById('cashOD').className = "";
            document.getElementById('onlinePay').className = "hidden";
        }else{
            document.getElementById('cod').className = "hidden";
            document.getElementById('razorpay').className = "";
            document.getElementById('cashOD').className = "hidden";
            document.getElementById('onlinePay').className = "";
        }
    }
    function setAddress(arg){

    }
</script>
@stop