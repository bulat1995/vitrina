@inject('pageData','App\Services\MainPageDataService')
<!DOCTYPE html>
<html lang="en">
<head>
    <title>@yield('title')</title>
    @yield('meta')
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="/onetech/styles/bootstrap4/bootstrap.min.css">
    <link href="/onetech/plugins/fontawesome-free-5.0.1/css/fontawesome-all.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" type="text/css" href="/onetech/plugins/OwlCarousel2-2.2.1/owl.carousel.css">
    <link rel="stylesheet" type="text/css" href="/onetech/plugins/OwlCarousel2-2.2.1/owl.theme.default.css">
    <link rel="stylesheet" type="text/css" href="/onetech/plugins/OwlCarousel2-2.2.1/animate.css">
    <link rel="stylesheet" type="text/css" href="/onetech/styles/responsive.css">
    <link rel="shorcut icon" href="/favicon.png" type="image/png">
    @yield('headScript')
    <script>
	function simpleSearch(value){
			var searchValue = value;
			if(value.length>3){
				var request = $.ajax({
				  url: "/api/search",
				  type: "POST",
				  data: {_token:"{{csrf_token()}}", search : searchValue},
				  dataType: "json"
				});
				request.done(function(msg) {
					$('#searchItems').empty();
					if(msg.data.length>0){
						msg.data.forEach(function(currentValue,index,array){
							$('#searchItems').append('<a href="/product/'+currentValue.id+'"><li>'+currentValue.name+'</li></a>');
						})
					}
				});

			}
	}
</script>
<style>
	#searchItems{
		background:#fff;
		border:1px solid #eee;
		border-radius:0px 0px 5px 5px;
	}

	#searchItems a{
		color:#555;
	}
	#searchItems li{
		padding:5px;
		padding-left:20px;
		cursor: pointer;
		border-top:1px solid #eee;
	}

	#searchItems li:hover{
		background:#eee;
	}

</style>

</head>
<body>

<div class="super_container">
	<!-- Header -->
	<header class="header">
		<!-- Top Bar -->
		<div class="top_bar">
			<div class="container">
				<div class="row">
					<div class="col d-flex flex-row">
						<div class="top_bar_contact_item">
                                <div class="top_bar_icon">
                                <img src="/onetech/images/phone.png" alt="">
                            </div>
                            {!! $pageData->get('phoneNumber') !!}
                        </div>
						<div class="top_bar_contact_item">
                            <div class="top_bar_icon">
                                <img src="/onetech/images/mail.png" alt="">
                            </div>
                            <a href="mailto:{!! $pageData->get('email') !!}">{!! $pageData->get('email') !!}</a>
                        </div>
						<div class="top_bar_content ml-auto">
							<div class="top_bar_menu">
								<ul class="standard_dropdown top_bar_dropdown">
									<li>
										<a href="#">{{__('language')}}<i class="fas fa-chevron-down"></i></a>
										<ul>
											@foreach(config('my.global.language.list') as $lang=>$value)
												<li><a href="{{ route('language',$lang)}}">{{$value}}</a></li>
											@endforeach
										</ul>
									</li>
                                    @if(!Auth::guest())
                                        <li>
                                            <a href="#"><img src="/onetech/images/user.png" width="12px"> {{ Auth::user()->name }}</a>
                                            <ul>
                                                @role('adminPanel')
                                                    <li><a href="{{ route('admin.shop.categories.show') }}" target="_blank">{{__('controlPanel') }}</a></li>
                                                @endrole
                                                <li><a href="{{ route('shop.profile.index') }}">{{__('profile')}}</a></li>
                                                <li><a href="{{ route('shop.messages.index') }}"><i class="fa fa-file"></i>{{ __('messages') }}</a></li>
                                                <li><a href="{{ route('shop.cart.index') }}">{{ __('cart') }}</a></li>
                                                <li><a href="{{ route('shop.reviews.index') }}"><i class="fa fa-file"></i>{{ __('reviews') }}</a></li>
                                                <li>
                                                    <form id="logout" action="{{ route('logout') }}" method="post">
                                                        @csrf
                                                    </form>
                                                    <a href="" onclick="document.getElementById('logout').submit();return false">{{__('logout')}}</a>
                                                </li>
                                            </ul>
                                        </li>
                                    @endif
								</ul>
							</div>
                            @if(Auth::guest())
							<div class="top_bar_user">
								<div class="user_icon"><img src="/onetech/images/user.svg" alt=""></div>
								<div><a href="{{ route('register') }}">{{ __('Register') }}</a></div>
								<div><a href="{{ route('login') }}">{{ __('Login') }}</a></div>
							</div>
                            @endif
						</div>
					</div>
				</div>
			</div>
		</div>

		<!-- Header Main -->

		<div class="header_main">
			<div class="container">
				<div class="row">

					<!-- Logo -->
					<div class="col-lg-3 col-sm-3 col-4 order-1">
						<div class="logo_container">
                            <div class="logo">
                            	<a href="{{ route('shop') }}">
                            		<img src="/onetech/images/logoFront.png" width="240px">
                            	</a>
                            </div>
						</div>
					</div>



					<!-- Search -->
					<div class="col-lg-7 col-12 order-lg-2 order-3 text-lg-left text-right">
						<div class="header_search">
							<div class="header_search_content">
								<div class="header_search_form_container">
									<form action="{{ route('shop.search') }}" method="get" class="header_search_form clearfix">
										<input type="search" name="search" required="required" class="header_search_input" id="searchValue" onkeyup="simpleSearch(this.value)" placeholder="{{__('findProduct')}}" onblur="(function(){setTimeout(function(){$('#searchItems').empty()},100);})()">
										<button type="submit" class="header_search_button trans_300" value="Submit"><img src="/onetech/images/search.png" alt=""></button>
                                        @csrf
									</form>
									<ul id="searchItems">								
									</ul>
								</div>
							</div>
						</div>
					</div>

					<!-- Wishlist -->
					 <div class="col-lg-2 col-9 order-lg-3 order-2 text-lg-left text-right pull-right">

					</div>


                </div>
			</div>
		</div>

		<!-- Main Navigation -->

		<nav class="main_nav">
			<div class="container">
				<div class="row">
					<div class="col">

						<div class="main_nav_content d-flex flex-row">

							<!-- Categories Menu -->

							<div class="cat_menu_container">
								<div class="cat_menu_title d-flex flex-row align-items-center justify-content-start">
									<div class="cat_burger"><span></span><span></span><span></span></div>
									<div class="cat_menu_text">{{__('categories')}}</div>
								</div>

								<ul class="cat_menu">
                                    @php $curLevel=1;@endphp
                                    @foreach($pageData->getCategoryList() as $category)
                                        @for($i=$curLevel;$i>$category->_lvl;$i--)
                                            </ul></li>
                                        @endfor
                                        @if($category->_rgt-$category->_lft==1 )
                                            <li><a href="{{ route('shop.products',$category->id) }}" >{{ $category->name }}</a></li>
                                        @elseif($category->_rgt-$category->_lft>1  )
                                            <li class="hassubs"><a href="{{ route('shop.products',$category->id) }}" >{{ $category->name }}<i class="fas fa-chevron-right"></i></a><ul class="sub-menu">
                                            @endif
                                            @php
                                            $curLevel=$category->_lvl;
                                            @endphp
                                    @endforeach
								</ul>
							</div>

							<!-- Main Nav Menu -->

							<div class="main_nav_menu ml-auto">
								<ul class="standard_dropdown main_nav_dropdown">
                                    @foreach($pageData->getLastNews() as $item)
                                        <li><a href="{{ route('shop.page',$item->slug) }}">{{ $item->title }}</a></li>
                                    @endforeach
								</ul>
							</div>
							<!-- Menu Trigger -->

                            <div class="menu_trigger_container ml-auto">
								<div class="menu_trigger d-flex flex-row align-items-center justify-content-end">
									<div class="menu_burger">
										<div class="menu_trigger_text">{{__('menu')}}</div>
										<div class="cat_burger menu_burger_inner"><span></span><span></span><span></span></div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</nav>

		<!-- Menu -->

		<div class="page_menu">
			<div class="container">
				<div class="row">
					<div class="col">
						<div class="page_menu_content">
							<div class="page_menu_search">
								<form action="{{route('shop.search')}}" method="get">
                                    @csrf
									<input type="search" name="search" required="required" class="page_menu_search_input" placeholder="{{__('findProduct')}}">
								</form>
							</div>
							<ul class="page_menu_nav">
								<li class="page_menu_item has-children">
									<a href="#">{{__('language')}}<i class="fa fa-angle-down"></i></a>
									<ul class="page_menu_selection">
											@foreach(config('my.global.language.list') as $lang=>$value)
												<li><a onclick="location.href=(this.href)" href="{{ route('language',$lang)}}">{{$value}}<i class="fa fa-angle-down"></i></a></li>
											@endforeach

									
									</ul>
								</li>
                                @foreach($pageData->getLastNews() as $item)
                                <li  class="page_menu_item has-children"><a href="{{ route('shop.page',$item->slug) }}">{{ $item->title }}</a></li>
                                @endforeach
							</ul>
							<div class="menu_contact">
								<div class="menu_contact_item">
                                    <div class="menu_contact_icon">
                                        <img src="/onetech/images/phone_white.png" alt="">
                                    </div>
                                    {!! $pageData->get('phoneNumber') !!}
                                </div>
								<div class="menu_contact_item">
                                    <div class="menu_contact_icon">
                                        <img src="/onetech/images/mail_white.png" alt="">
                                    </div>
                                    <a href="mailto:{!! $pageData->get('email') !!}">{!! $pageData->get('email') !!}</a>
                                </div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

	</header>
	@yield('content')
	<!-- Newsletter -->
	<!-- Footer -->
	<footer class="footer">
		<div class="container">
			<div class="row">
				<div class="col-lg-3 footer_col">
					<div class="footer_column footer_contact">
						<div class="logo_container">
							<div class="logo"><a href="#">
                                <img src="/onetech/images/logoFront.png">
                                </a>
                            </div>
						</div>
                        <div class="footer_social">
                            <ul>
                                {!! $pageData->get('social') !!}
                            </ul>
                        </div>

					</div>
				</div>
				<div class="col-lg-2 offset-lg-2">
					<div class="footer_column">
                        <div class="footer_title">{{__('haveAQuestion')}}</div>
                        <div class="footer_phone">{!! $pageData->get('phoneNumber') !!}</div>
                        <div class="footer_contact_text">
                            <p>{!! $pageData->get('address') !!}</p>
                        </div>
                    </div>
                </div>
				<div class="col-lg-2 offset-lg-2">
					<div class="footer_column">
						<div class="footer_title">{{__('pages')}}</div>
						<ul class="footer_list">
                            @foreach($pageData->getLastNews() as $item)
                                <li><a href="{{ route('shop.page',$item->slug) }}">{{ $item->title }}</a></li>
                            @endforeach
						</ul>
					</div>
				</div>
			</div>
		</div>
	</footer>

	<!-- Copyright -->

</div>

<script src="/onetech/js/jquery-3.3.1.min.js"></script>
<script src="/onetech/styles/bootstrap4/popper.js"></script>
<script src="/onetech/styles/bootstrap4/bootstrap.min.js"></script>
<script src="/onetech/plugins/greensock/TweenMax.min.js"></script>
<script src="/onetech/plugins/greensock/TimelineMax.min.js"></script>
<script src="/onetech/plugins/scrollmagic/ScrollMagic.min.js"></script>
<script src="/onetech/plugins/greensock/animation.gsap.min.js"></script>
<script src="/onetech/plugins/greensock/ScrollToPlugin.min.js"></script>
<script src="/onetech/plugins/OwlCarousel2-2.2.1/owl.carousel.js"></script>
<script src="/onetech/plugins/slick-1.8.0/slick.js"></script>
<script src="/onetech/plugins/easing/easing.js"></script>
<script src="/onetech/js/custom.js"></script>
@yield('footerScript')
</body>

</html>
