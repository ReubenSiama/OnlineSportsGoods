@extends('layout.master')
@section('title','Account')
@section('content')

<div class="shopper-informations">
        <div class="row">
            <div class="col-sm-3">
                <div class="shopper-info">
                    <p>Shopper Information</p>
                    <form action="{{ route('updateUser') }}" method="POST">
                        @csrf
                        <input name="name" value="{{ Auth::user()->name }}" type="text" placeholder="User Name">
                        <input name="email" value="{{ Auth::user()->email }}" type="email" placeholder="Email">
                        <small>(Leave blank to keep same password)</small>
                        <input name="password" type="password" placeholder="Password">
                        <button type="submit" class="btn btn-primary">Update</button>
                        <a class="btn btn-primary" href="">Cancel</a>
                    </form>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="order-message">
                    <p>Shipping Addresses</p>
                    @if(Auth::user()->shippingAddress->count() != 0)
                    <ul class="list-group">
                        @foreach(Auth::user()->shippingAddress as $address)
                            <li class="list-group-item">
                                {{ $address->name }}
                                <a href="{{ route('deleteAddress',['id'=>$address->id]) }}" class="pull-right">
                                    <span class="glyphicon glyphicon-trash"></span>
                                </a>
                                <br>
                                {{ $address->address_line_1 }}
                                <a href="{{ route('account') }}?edit={{ $address->id }}" class="pull-right">
                                    <span class="glyphicon glyphicon-edit"></span>
                                </a>
                                <br>
                                {{ $address->address_line_2 }},
                                <br>
                                {{ $address->city }}, {{ $address->state }}
                                <br>
                                Pin Code : {{ $address->pin_code }}
                                <br>
                                Contact : {{ $address->contact }}
                                <br>
                                Address Type : {{ $address->address_type }}
                            </li>
                        @endforeach
                    </ul>
                    @else
                    <p class="text-center">
                        <small>
                            Please Add Shipping Address
                        </small>
                    </p>
                    @endif
                </div>	
            </div>					
            <div class="col-sm-5 clearfix">
                <div class="bill-to">
                    <p>Add Shipping Address</p>
                    <div class="form-one address-form">
                        <form method="POST" action="{{ route('add_address') }}">
                            @csrf
                            @if(isset($_GET['edit']))
                            <input type="hidden" name="id" value="{{ $addressEdit->id }}">
                            @endif
                            <input value="{{ isset($_GET['edit']) ? $addressEdit->name : '' }}" required name="name" type="text" placeholder="Name *">
                            <input value="{{ isset($_GET['edit']) ? $addressEdit->address_line_1 : '' }}" required name="address_one" type="text" placeholder="Address 1 *">
                            <input value="{{ isset($_GET['edit']) ? $addressEdit->address_line_2 : '' }}" required name="address_two" type="text" placeholder="Address 2 *">
                            <input value="{{ isset($_GET['edit']) ? $addressEdit->contact : '' }}" required name="contact" type="text" placeholder="Contact *">
                            <input value="{{ isset($_GET['edit']) ? $addressEdit->city : '' }}" required name="city" type="text" placeholder="City *">
                            <input value="{{ isset($_GET['edit']) ? $addressEdit->state : '' }}" required name="state" type="text" placeholder="State *">
                            <input value="{{ isset($_GET['edit']) ? $addressEdit->pin_code : '' }}" required name="pin" type="text" placeholder="Pin Code *">
                            <select required name="address_type" id="address_type">
                                <option value="">--Address Type--</option>
                                <option {{ isset($_GET['edit']) ? $addressEdit->address_type == 'Home' ? 'selected' : '' : '' }} value="Home">Home</option>
                                <option {{ isset($_GET['edit']) ? $addressEdit->address_type == 'Office' ? 'selected' : '' : '' }} value="Office">Office</option>
                            </select>
                            <button type="submit" class="btn btn-primary form-control" href="">{{ isset($_GET['edit']) ? 'Save' : 'Add Address' }}</button>
                            <br><br>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop