@extends('voyager::master')

@section('page_title', __('voyager::generic.viewing').' Order Details')

@section('page_header')
    <div class="container-fluid">
        <h1 class="page-title">
            <i class="voyager-list"></i> Order Details
        </h1>
    </div>
@stop

@section('content')
    <div class="page-content browse container-fluid">
        @include('voyager::alerts')
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <div class="panel panel-bordered">
                    <div class="panel-body">
                        <div class="table-responsive">
                        @if($order->status == "Cancelled")
                            <div class="alert alert-danger text-center">
                                CANCELLED   
                            </div>
                        @endif
                            <table id="dataTable" class="table table-hover">
                                Order Id : {{ $order->order_number }}
                                <br><br>
                                Ship To: <br>
                                <address style="margin-left: 40px;">
                                    {{ $order->shippingAddress->name }}, <br>
                                    {{ $order->shippingAddress->address_line_1 }}, <br>
                                    {{ $order->shippingAddress->address_line_2 }}, <br>
                                    {{ $order->shippingAddress->city }}, {{ $order->shippingAddress->state }}, <br>
                                    Contact : {{ $order->shippingAddress->contact }} <br>
                                </address>
                                <thead>
                                    <tr>
                                        <td colspan="4" class="text-center"><h4><b>Items</b></h4></td>
                                    </tr>
                                    <tr>
                                       <!-- headers -->
                                        <th>Item Name</th>
                                        <th class="text-center">Quantity</th>
                                        <th style="text-align: right">Price</th>
                                        <th style="text-align: right">Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $sub_total = 0; $gst = 0; $gst_cost = 0; @endphp
                                    @foreach($order->orderedItem as $ordered)
                                    <tr>
                                        <td>{{ $ordered->item->item_name }}</td>
                                        <td class="text-center">{{ $ordered->quantity }}</td>
                                        <td style="text-align: right">{{ $ordered->price }}</td>
                                        <td style="text-align: right">{{ $ordered->amount }}</td>
                                    </tr>
                                    @php
                                        $sub_total += $ordered->price * $ordered->quantity;
                                        $gst_cost = 18/100 * ($ordered->price * $ordered->quantity);
                                        $gst += $gst_cost;
                                    @endphp
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="col-md-4">
                                <table class="table">
                                    <tr>
                                        <td>Sub Total</td>
                                        <td>:</td>
                                        <td style="text-align: right;">₹{{ $sub_total }}</td>
                                    </tr>
                                    <tr>
                                        <td>GST</td>
                                        <td>:</td>
                                        <td style="text-align: right;">₹{{ $gst }}</td>
                                    </tr>
                                    <tr>
                                        <td>Total</td>
                                        <td>:</td>
                                        <td style="text-align: right;">₹{{ $sub_total + $gst_cost }}</td>
                                    </tr>
                                </table>
                            </div>
                            <p class="pull-right">
                                Amount Payable : {{ $order->payment_status == "Paid" || $order->status == "Cancelled" ? 0 : $sub_total + $gst_cost }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@stop

@section('css')

    <link rel="stylesheet" href="{{ voyager_asset('lib/css/responsive.dataTables.min.css') }}">

@stop

@section('javascript')
    <!-- DataTables -->
 
        <script src="{{ voyager_asset('lib/js/dataTables.responsive.min.js') }}"></script>
 
@stop
