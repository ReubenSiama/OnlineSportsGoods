@extends('layout.master')
@section('title', Request::is('category/*') ? 'Categories' : 'Brands')
@section('content')
<!-- Items -->
@foreach($items as $item)
    @include('partials.item',['item'=>$item])
@endforeach
@stop
