@extends('layout.master')
@section('title','Orders')
@section('content')
<section id="cart_items">
    <div class="container">
        <div class="breadcrumbs">
            <ol class="breadcrumb">
                <li><a href="/">Home</a></li>
                <li class="active">Orders</li>
            </ol>
        </div>
        <div class="table-responsive cart_info">
            <table class="table table-condensed">
                <thead>
                    <tr class="cart_menu">
                        <td class="image">Order Number</td>
                        <td class="description">Items</td>
                        <td class="price">Status</td>
                        <td class="price">Ship To</td>
                        <td class="total">Cancel</td>
                        <td></td>
                    </tr>
                </thead>
                <tbody>
                    @php $sub_total = 0; $gst = 0; $gst_cost = 0; @endphp
                    @foreach(Auth::user()->order->sortByDesc('created_at') as $order)
                    <tr>
                        <td class="cart_product">
                            <br><br>
                            {{ $order->order_number }}
                        </td>
                        <td class="cart_description">
                            <table class="table table-hover">
                                <tr>
                                    <th>Item</th>
                                    <th>Quantity</th>
                                    <th>Price</th>
                                    <th>Amount</th>
                                </tr>
                                @foreach($order->orderedItem as $item)
                                <tr>
                                    <td>{{ $item->item->item_name }}</td>
                                    <td>{{ $item->quantity }}</td>
                                    <td>₹{{ $item->price }}</td>
                                    <td>₹{{ $item->amount }}</td>
                                </tr>
                                <br>
                                @endforeach
                            </table>
                        </td>
                        <td class="cart_price">
                            {{ $order->status }}
                        </td>
                        <td class="cart_price">
                            {{ $order->shippingAddress->name }},<br>
                            {{ $order->shippingAddress->address_line_1 }},<br>
                            {{ $order->shippingAddress->address_line_2 }},<br>
                            {{ $order->shippingAddress->contact }}
                        </td>
                        <td class="cart_delete">
                            @if($order->status != "Delivered" && $order->status != "Cancelled")
                            <br>
                            <br>
                            <a class="cart_quantity_delete" href="{{ route('cancel',['id'=>$order->id]) }}"><i class="fa fa-times"></i> Cancel</a>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</section>
@stop