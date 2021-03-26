@inject('pageData','App\Services\MainPageDataService')
@extends('shop/main')


@section('headScript')
    <link rel="stylesheet" type="text/css" href="/onetech/styles/product_styles.css">
    <link rel="stylesheet" type="text/css" href="/onetech/styles/product_responsive.css">
    <link rel="stylesheet" type="text/css" href="/onetech/styles/main_styles.css">
    <link rel="stylesheet" type="text/css" href="/onetech/styles/contact_styles.css">
    <link rel="stylesheet" type="text/css" href="/onetech/styles/contact_responsive.css">
    <link rel="stylesheet" type="text/css" href="/onetech/styles/cart_styles.css">
@endsection


@section('footerScript')
    <script src="/onetech/js/product_custom.js"></script>
@endsection
@section('title'){{ $product->name }}@endsection

@section('content')

    <!-- Single Product -->

	<div class="single_product">
		<div class="container">
            @if (session('success'))
                <div class="alert alert-success">{{ session()->get('success')}}</div>
            @endif
			<div class="row">

				<!-- Images -->
				<div class="col-lg-2 order-lg-1 order-2">
					<ul class="image_list" style="height:525px;overflow-y:scroll">
                        @foreach($product->photos as $photo)
						<li data-image="{{asset(Config::get('my.product.photo.filePathWeb').$photo->path)}}">
                            <img src="{{asset(Config::get('my.product.photo.filePathWeb').$photo->path)}}">
                        </li>
                        @endforeach
					</ul>
				</div>

				<!-- Selected Image -->
				<div class="col-lg-5 order-lg-2 order-1">
					<div class="image_selected">
                        @foreach($product->photos as $photo)
                            @if($loop->first)<img src="{{asset(Config::get('my.product.photo.filePathWeb').$photo->path)}}" >@endif
                        @endforeach
                    </div>
				</div>

				<!-- Description -->
				<div class="col-lg-5 order-3">
					<div class="product_description">
						<div class="product_category">{{ $product->category }}</div>
						<div class="product_name">{{ $product->name }}</div>
                        <div class="product_price">{{ $product->price }}  {!! __('coin') !!}</div>
						<div class="rating_r rating_r_4 product_rating"><i></i><i></i><i></i><i></i><i></i></div>
						<div class="product_text">
                            @foreach($params as $param)
                                <p>
                                  <b>{{$param->name}}:</b>

                                        @if($param->inputType=='option')
                                            @php
                                                $par=explode('|',$param->regular);
                                                echo $par[$param->value];
                                            @endphp
                                        @else
                                            {{$param->value}}
                                        @endif

                                </p>
                              @endforeach
                        </div>
                        <div class="order_info d-flex flex-row">
                            @if(!Auth::guest())
                                @include('shop.cart.form')
                            @endif
						</div>
					</div>
				</div>
            </div>
            @if(!Auth::guest())
            <div class="container">
                @include('shop.review.form')
            </div>
            @endif
            @if($reviews->count()>0)
                <div class="row">
                    <div class="col-lg-10 offset-lg-1">
                        <div class="contact_form_container">
                            <div class="container">
                            @include('shop.modules.recentLine')
                            </div>
                        </div>
                    </div>
                </div>
            @endif
		</div>
	</div>


@endsection
