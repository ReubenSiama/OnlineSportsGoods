@extends('layout.master')
@section('content')
<h2 class="title text-center">Search Result</h2>
@if(count($result) == 0)
<p class="text-center">
    No result!!!
</p>
@else
<div class="row">
    @foreach($result as $item)
        @include('partials.item',['item'=>$item])
    @endforeach
</div>
@endif
@stop