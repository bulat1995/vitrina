@inject('pageData','App\Services\MainPageDataService')


@extends('shop/main')
@section('headScript')
<link href="/onetech/styles/shop_styles.css" rel="stylesheet" type="text/css"/>
<link href="/onetech/styles/cart_styles.css" rel="stylesheet" type="text/css"/>
<link href="/onetech/styles/shop_responsive.css" rel="stylesheet" type="text/css"/>
<link href="/onetech/styles/contact_styles.css" rel="stylesheet" type="text/css"/>
<link href="/onetech/styles/contact_responsive.css" rel="stylesheet" type="text/css"/>
<link href="/onetech/styles/cart_styles.css" rel="stylesheet" type="text/css"/>
@endsection

@section('title')
    {{__('edit review')}}
@endsection

@section('content')
<div class="cart_section">
    <div class="container">
        @if (session('success'))
        <div class="alert alert-success">
            {{ session()->get('success')}}
        </div>
        @endif
        <div class="container">
            <div class="row">
                <div class="col-lg-10 offset-lg-1">
                    <div class="cart_items">
                        <div class="contact_form_title">
                            <a href="{{ route('shop.product',$product->id) }}" target="_blank">
                                {{__('product')}}: {{ $product->name }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @include('shop.review.form')
    </div>
</div>
@endsection
