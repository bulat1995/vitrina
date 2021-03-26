<div class="cart_items">
    <ul class="cart_list">
        @foreach($reviews as $item)
        <li class="cart_item clearfix">
            <div class="cart_item_image">
                @if(!empty($item->photo))
                    <img src="{{ asset(config('my.product.photo.filePathWeb').$item->photo) }}" alt="">
                @else
                    <img src="{{ asset(config('my.global.path.image_not_available')) }}" alt="">
                @endif
                </div>
            <div class="cart_item_info d-flex flex-md-row flex-column justify-content-between">
                <div class="cart_item_name cart_info_col">
                    <div class="cart_item_title">{{ $item->name }}</div>
                    <div class="cart_item_text">{{ $item->review }}</div>
                </div>
                <div class="cart_item_quantity cart_info_col">
                    <div class="cart_item_title"></div>
                    <div class="cart_item_text"></div>
                </div>
                <div class="cart_item_price cart_info_col">
                    {{-- <div class="cart_item_title">{{ __('price') }}</div>
                    <div class="cart_item_text">{{ $item->price }} {!! __('coin') !!}</div> --}}
                </div>
                <div class="cart_item_total cart_info_col">
                    {{-- <div class="cart_item_title">{{__('Total')}}</div>
                    <div class="cart_item_text">{{ $item->total_price }} {!! __('coin') !!}</div> --}}
                </div>
                <div class="cart_item_total cart_info_col">
                    <div class="cart_item_title">{{ __('estimate') }}: {{ $item->estimate }}</div>
                    <div class="cart_item_text">

                    </div>
                </div>
            </div>
        </li>
@endforeach
</ul>
</div>
