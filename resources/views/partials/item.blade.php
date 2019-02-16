<div class="col-sm-3">
    <div class="product-image-wrapper">
        <div class="single-products">
            <div class="productinfo text-center">
                @php $images = json_decode($item->image) @endphp
                <div class="image-item-container">
                    <img src="{{ Voyager::image($images[0]) }}" alt="{{ $item->item_name }}">
                </div>
                <h2>₹ {{ $item->price }}</h2>
                <p>
                    {{ $item->item_name }} <br>
                    <small>
                        
                        {!! $item->details != null ? $item->details : "&nbsp;<br>" !!}
                    </small>
                </p>
                <form action="{{ route('addToCart',['id'=>$item->id]) }}" method="post">
                    @csrf()
                    <input type="hidden" name="price" value="{{ $item->price }}">
                    <button type="submit" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Add to cart</button>
                </form>
            </div>
        </div>
    </div>
</div>