@inject('pageData','App\Services\MainPageDataService')


@extends('shop/main')
@section('headScript')
    <link rel="stylesheet" type="text/css" href="/onetech/styles/shop_styles.css">
    <link rel="stylesheet" type="text/css" href="/onetech/styles/cart_styles.css">
    <link rel="stylesheet" type="text/css" href="/onetech/styles/shop_responsive.css">
@endsection

@section('title')
    {{__('cart')}}
@endsection

@section('content')

    	<div class="cart_section">
    		<div class="container">
    			<div class="row">

    				<div class="col-lg-10 offset-lg-1">
    					<div class="cart_container">
    						<div class="cart_title">{{ __('in cart') }}</div>
                            @if (session('success'))
                                <div class="alert alert-success">{{ session()->get('success')}}</div>
                            @endif
                            @if(!empty($cartItems))
                                <div class="cart_items">
                                    <ul class="cart_list">
                                        @php
                                        $totalPrice=0;
                                        @endphp
                                @foreach($cartItems as $item)
                                    @php
                                    $totalPrice+=$item->total_price;
                                    @endphp
                                    <a href="{{ route('shop.product',$item->product_id) }}" target="_blank">
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
        											<div class="cart_item_title">{{ __('name') }}</div>
        											<div class="cart_item_text">{{ $item->name }}</div>
        										</div>
        										<div class="cart_item_quantity cart_info_col">
        											<div class="cart_item_title">{{ __('quantity') }}</div>
        											<div class="cart_item_text">{{ $item->quantity }}</div>
        										</div>
        										<div class="cart_item_price cart_info_col">
        											<div class="cart_item_title">{{ __('price') }}</div>
        											<div class="cart_item_text">{{ $item->price }} {!! __('coin') !!}</div>
        										</div>
        										<div class="cart_item_total cart_info_col">
        											<div class="cart_item_title">{{__('Total')}}</div>
        											<div class="cart_item_text">{{ $item->total_price }} {!! __('coin') !!}</div>
        										</div>
        										<div class="cart_item_total cart_info_col">
        											<div class="cart_item_title"></div>
        											<div class="cart_item_text">
                                                        <form action="{{ route('shop.cart.destroy',$item->id) }}" method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                        <button type="submit" class="btn  btn-danger">{{ __('delete') }}</button>
                                                    </form>
                                                    </div>
        										</div>
        									</div>
        								</li>
                                    </a>
                                @endforeach
                            </ul>
                            </div>
                            <!-- Order Total -->
                                <div class="order_total">
                                <div class="order_total_content text-md-right">
                                <div class="order_total_title">{{ __('price') }}:</div>
                                <div class="order_total_amount">{{ $totalPrice }} {!! __('coin') !!}</div>
                            </div>
                        </div>
                        @else
                                <div class="alert alert-success">{{ __('emptyCart')}}</div>
                        @endif
    					</div>
    				</div>
    			</div>
    		</div>
    	</div>
@endsection
