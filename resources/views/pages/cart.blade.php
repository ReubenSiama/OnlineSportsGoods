@extends('layout.master')
@section('title','Cart')
@section('content')
<section id="cart_items">
    <div class="container">
        <div class="breadcrumbs">
            <ol class="breadcrumb">
                <li><a href="/">Home</a></li>
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
                        <td class="quantity">Quantity</td>
                        <td class="total">Total</td>
                        <td></td>
                    </tr>
                </thead>
                <tbody>
                    @php $sub_total = 0; $gst = 0; $gst_cost = 0; @endphp
                    @foreach($cart_list as $carts)
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
                        <td class="cart_quantity">
                            <div class="cart_quantity_button">
                                <a class="cart_quantity_up" href="{{ route('updateCart',['add','id'=>$carts->id]) }}"> + </a>
                                <input disabled class="cart_quantity_input" type="text" name="quantity" value="{{ $carts->quantity }}" autocomplete="off" size="2">
                                <a class="cart_quantity_down" href="{{ route('updateCart',['subtract','id'=>$carts->id]) }}"> - </a>
                            </div>
                        </td>
                        <td class="cart_total">
                            <p class="cart_total_price">₹{{ $carts->price * $carts->quantity }}</p>
                        </td>
                        <td class="cart_delete">
                            <a class="cart_quantity_delete" href="{{ route('updateCart',['delete','id'=>$carts->id]) }}"><i class="fa fa-times"></i></a>
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

<section id="do_action">
    <div class="container">
        <div class="row">
            <div class="col-sm-6 col-sm-offset-3">
                <div class="total_area">
                    <ul>
                        <li>Cart Sub Total <span>₹{{ $sub_total }}</span></li>
                        <li>GST <span>₹{{ $gst }}</span></li>
                        <!-- <li>Shipping Cost <span>Free</span></li> -->
                        <li>Total <span>₹{{ $sub_total + $gst_cost }}</span></li>
                    </ul>
                        <!-- <a class="btn btn-default update" href="">Update</a> -->
                        <a class="btn btn-default check_out form-control" href="{{ route('checkout') }}">Check Out</a>
                </div>
            </div>
        </div>
    </div>
</section><!--/#do_action-->

@stop
