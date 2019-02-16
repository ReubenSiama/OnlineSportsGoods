<div class="col-sm-2">
    <div class="product-image-wrapper">
        <div class="single-products">
            <div class="productinfo text-center">
                @php $images = json_decode($featured->item->image) @endphp
                <div class="image-item-container">
                    <img src="{{ Voyager::image($images[0]) }}" alt="{{ $featured->item->item_name }}">
                </div>
                <h2>₹ {{ $featured->new_price }}</h2>
                <p>{{ $featured->item->item_name }}</p>
                <form action="{{ route('addToCart',['id'=>$featured->item->id]) }}" method="post">
                    @csrf()
                    <input type="hidden" name="price" value="{{ $featured->new_price }}">
                    <button type="submit" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Add to cart</button>
                </form>
            </div>
            <div class="product-overlay">
                <div class="overlay-content">
                    <h2>₹ {{ $featured->new_price }}</h2>
                    <p>{{ $featured->item->item_name }}</p>
                    <form action="{{ route('addToCart',['id'=>$featured->item->id]) }}" method="post">
                        @csrf()
                        <input type="hidden" name="price" value="{{ $featured->new_price }}">
                        <button type="submit" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Add to cart</button>
                    </form>
                </div>
            </div>
            @if($featured->feature_type == "New")
            <img src="images/home/new.png" class="new" alt="" />
            @elseif($featured->feature_type == "Sale")
            <img src="images/home/sale.png" class="new" alt="" />
            @endif
        </div>
    </div>
</div>