@inject('pageData','App\Services\MainPageDataService')

@extends('shop/main')

@section('headScript')
    <link rel="stylesheet" type="text/css" href="/onetech/styles/shop_styles.css">
    <link rel="stylesheet" type="text/css" href="/onetech/styles/shop_responsive.css">
@endsection
@section('title'){{__('searchProduct')}} @endsection

@section('content')
    <div class="shop">
        <div class="container">
            <div class="row">
                <div class="col-lg-3">
                    <!-- Shop Sidebar -->
                        @include('shop.modules.searchBlock')
                </div>

                <div class="col-lg-9">
                    <!-- Shop Content -->
                    <div class="shop_content">
                        <div class="shop_bar clearfix">
                            <div class="shop_product_count">{{__('finded')}}: <span>{{ $productsCount }}</span></div>
                            <div class="shop_sorting row">
                                @include('shop.modules.searchSelect')
                            </div>
                        </div>
                        @include('shop.modules.productList')
                        <!-- Shop Page Navigation -->
                        @include('shop.modules.paginate')
                </div>
            </div>
        </div>
    </div>

@endsection
