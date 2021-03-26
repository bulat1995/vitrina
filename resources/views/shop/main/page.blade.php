@inject('pageData','App\Services\MainPageDataService')


@extends('shop/main')


@section('title')
{{ $page->title }}
@endsection

@section('headScript')
    <link rel="stylesheet" type="text/css" href="/onetech/styles/product_styles.css">
    <link rel="stylesheet" type="text/css" href="/onetech/styles/product_responsive.css">
    @if(!$page->can_index)
    <meta name="robots" content="noindex">
    @endif
@endsection


@section('content')
<!-- Single Blog Post -->
<div class="single_post mt-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 offset-lg-2">
                <div class="single_post_title">@yield('title')</div>
                <div class="single_post_text">
                    <p>
                        {!!$page->content!!}
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
