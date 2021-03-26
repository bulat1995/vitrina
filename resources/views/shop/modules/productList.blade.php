@if(!empty($products))
    @foreach($products as $product)
        <div style="width:244px;display:inline-block;text-align:center;border:1px solid #eee;padding:10px;margin:5px;">
            <a href="{{route('shop.product',$product->id) }}">
                @if(!empty($product->photo))
                        <img  src="{{ asset(Config::get('my.product.photo.filePathWeb').$product->photo) }}" width="100%">
                @else
                    <img src="/images/no_image_available.png" width="100%">
                @endif
                </a>
                <div class="product_name"><div><a href="{{route('shop.product',$product->id) }}">{{ $product->name }}</a></div></div>
                <div class="product_price">{{ $product->price }}  {!! __('coin') !!} </div>
        </div>
    @endforeach
@else
    @include('shop.modules.emptyBlock')
@endif
