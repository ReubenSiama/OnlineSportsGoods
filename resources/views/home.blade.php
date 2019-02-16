@extends('layout.master')
@section('title','Home | Sports Goods')
@section('top_area')
    @include('layout.carousel')
@stop
@section('content')
<!-- Items -->
@if(count($featuredItems) != 0)
<div class="features_items"><!--features_items-->
    <h2 class="title text-center">Featured Items</h2>
    <div class="row">
        @foreach($featuredItems as $featuredItem)
            @include('partials.featureItems',['featured'=>$featuredItem])
        @endforeach
    </div>
</div>
@endif
<h2 class="title text-center">Our Products</h2>
<div class="row">
    @foreach($items as $item)
        @include('partials.item',['item'=>$item])
    @endforeach
</div>
<div class="row text-center">
    {{ $items->links() }}
</div>
@stop