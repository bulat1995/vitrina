@inject('pageData','App\Services\MainPageDataService')


@extends('shop/main')
@section('headScript')
    <link rel="stylesheet" type="text/css" href="/onetech/styles/shop_styles.css">
    <link rel="stylesheet" type="text/css" href="/onetech/styles/cart_styles.css">
    <link rel="stylesheet" type="text/css" href="/onetech/styles/shop_responsive.css">
@endsection

@section('title')
    {{__('reviews')}}
@endsection

@section('content')

    	<div class="cart_section">
    		<div class="container">
    			<div class="row">

    				<div class="col-lg-10 offset-lg-1">
    					<div class="cart_container">
    						<div class="cart_title">{{ __('reviews') }}</div>
                            @if (session('success'))
                                <div class="alert alert-success">{{ session()->get('success')}}</div>
                            @endif
                            @if(count(  $reviews)>0)
                                <div class="cart_items">
                                    <ul class="cart_list">

                                @foreach($reviews as $item)

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
        											<div class="cart_item_title">{{ $item->name }}</div>
        											<div class="cart_item_text">{{ $item->review }}</div>
        										</div>
        										<div class="cart_item_total cart_info_col">
        											<div class="cart_item_title">
                                                        <a href="{{ route('shop.reviews.edit',$item->id) }}">{{ __('edit') }}</a>
                                                    </div>
        											<div class="cart_item_text">

                                                        <form action="{{ route('shop.reviews.destroy',$item->product_id) }}" method="POST">
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

                        @else
                                <div class="alert alert-success">{{ __('emptyReview')}}</div>
                        @endif
    					</div>
    				</div>
    			</div>
    		</div>
    	</div>
@endsection
