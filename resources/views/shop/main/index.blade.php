
@extends('shop/main')


@section('headScript')
    <link rel="stylesheet" type="text/css" href="/onetech/plugins/slick-1.8.0/slick.css">
    <link rel="stylesheet" type="text/css" href="/onetech/styles/main_styles.css">

        <link rel="stylesheet" type="text/css" href="/onetech/styles/product_styles.css">
        <link rel="stylesheet" type="text/css" href="/onetech/styles/product_responsive.css">
@endsection

@section('title'){{ config('app.name') }}@endsection

@section('content')
    @include('shop.modules.slider')
    <div class="new_arrivals">
		<div class="container">
			<div class="row">
				<div class="col">
					<div class="tabbed_container">
						<div class="tabs clearfix tabs-right">
							<div class="new_arrivals_title">{{__('products')}}</div>
							<ul class="clearfix">
								<li class="active">{{__('news') }}</li>
							</ul>
							<div class="tabs_line"><span></span></div>
						</div>
						<div class="row">
							<div class="col-lg-12" style="z-index:1;">
                                    @include('shop.modules.productList')
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
    {{-- @include('shop.modules.recent') --}}
    @if(!empty($last_viewed))
        @include('shop.modules.viewed')
    @endif
@endsection
