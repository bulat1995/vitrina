@inject('messageData','App\Services\MessageDataService')
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="shorcut icon" href="/images/logo.png" type="image/png">
<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
<title>{{__('controlPanel')}}: @yield('title')</title>

<!-- Bootstrap -->
<link rel="stylesheet" href="/bootstrap/css/bootstrap.min.css">

<!-- Google Font -->
<link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" rel="stylesheet">

<!-- Template style -->
<link rel="stylesheet" href="/admin/dist/css/style.css">
<link rel="stylesheet" href="/admin/dist/et-line-font/et-line-font.css">
<link rel="stylesheet" href="/admin/dist/font-awesome/css/font-awesome.min.css">
<link type="text/css" rel="stylesheet" href="/admin/dist/weather/weather-icons.min.css">
<link type="text/css" rel="stylesheet" href="/admin/dist/weather/weather-icons-wind.min.css">

<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

<script src="/admin/plugins/charts/code/highcharts.js"></script>
</head>

<body class="sidebar-mini">
<div class="wrapper">

  <!-- Main Header -->
  <header class="main-header dark-bg">

    <!-- Logo -->
    <a href="{{ route('admin.pages.index') }}" class="logo dark-bg">
    <!-- mini logo for sidebar mini 50x50 pixels -->
    <span class="logo-mini"><img src="/images/logo.png" alt="Ovio"></span>
    {{-- <span class="logo-mini"><img src="/admin/dist/img/logo.png" alt="Ovio"></span> --}}
    <!-- logo for regular state and mobile devices -->
    <span class="logo-lg"><img src="/images/logo.png" alt="Ovio" style="margin-right:10px;"><img src="/images/logo-text.png" alt="Ovio"></span> </a>
    {{-- <span class="logo-lg"><img src="/admin/dist/img/logo-lg.png" alt="Ovio"></span> </a> --}}

    <!-- Header Navbar -->
    <nav class="navbar navbar-static-top" role="navigation">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button"> <span class="sr-only">Toggle navigation</span> </a>
      <div class="pull-left search-box">
        <form action="{{ route('admin.search') }}" method="POST" class="search-form">
            @csrf
          <div class="input-group">
            <input type="text" name="search" class="form-control" required placeholder="{{ __('search') }}">
            <span class="input-group-btn">
            <button type="submit"  id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i> </button>
            </span></div>
        </form>
        <!-- search form --> </div>
      <!-- Navbar Right Menu -->
      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <li class="dropdown messages-menu"> <a href="#" class="dropdown-toggle" data-toggle="dropdown"> <i class="icon-chat"></i>
            <div class="notify"> @if($messageData->getCountNewMessages()>0)<span class="heartbit"></span> <span class="point"></span> @endif  </div>
            </a>
            <ul class="dropdown-menu">
              <li class="header">{{__('messages')}}: {{ $messageData->getCountNewMessages() }} </li>
              <li>
                <ul class="menu">
                    @foreach($messageData->partnersBlock() as $message)

                      <li><a href="{{ route('admin.messages.show',$message->id) }}">
                        <div class="pull-left">
                            @if(!empty($message->avatar))
                                <img src="{!! asset('storage/'.$message->avatar) !!}" class="img-circle" alt="User Image">
                            @else
                                <img src="/images/user.svg" class="img-circle" alt="User Image">
                            @endif
                        </div>
                        <h4>{{ $message->name }}</h4>
                        <p><small><i class="fa fa-clock-o"></i> {{ date('h:i d.m.Y',strtotime($message->last_message)) }}</small></p>
                        </a></li>
                    @endforeach
                </ul>
              </li>
              <li class="footer"><a href="{{ route('admin.messages.index') }}">{{__('seeAllMessages')}}</a></li>
            </ul>
          </li>
          <!-- messages-menu -->


          <!-- Tasks Menu -->
          <!-- User Account Menu -->
          <li class="dropdown user user-menu"> <a href="#" class="dropdown-toggle" data-toggle="dropdown">

             @if(!empty(Auth::user()->avatar))
              <img src="{!! asset(config('my.user.filePathWeb').Auth::user()->avatar) !!}" class="user-image" alt="User Image">
            @else
              <img src="/images/user.svg" class="user-image" alt="User Image">
            @endif


              <span class="hidden-xs">{{ Auth::user()->name }}</span>
          </a>
            <ul class="dropdown-menu">
              <li class="user-header">
                <div class="pull-left user-img">
                   @if(!empty(Auth::user()->avatar))
                      <img src="{!! asset(config('my.user.filePathWeb').Auth::user()->avatar) !!}" class="img-responsive" alt="User Image">
                    @else
                      <img src="/images/user.svg" class="img-responsive" alt="User Image">
                    @endif
                </div>
                <p class="text-left">{{ Auth::user()->firstName }} {{ Auth::user()->secondName }} <small>{{ Auth::user()->email }}</small> </p>
                <div class="view-link text-left">
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button><i class="fa fa-power-off"></i> {{__('logout')}}</button>
                    </form>
                </div>
              </li>
              <li><a href="{{ route('admin.profiles.show',auth()->user()->id) }}"><i class="icon-profile-male"></i> {{__('profile')}}</a></li>
              <li><a href="{{ route('admin.messages.index') }}"><i class="icon-envelope"></i> {{__('messages')}}</a></li>
              <li><a href="{{ route('admin.profiles.edit',auth()->user()->id) }}"><i class="icon-gears"></i> {{__('profileEdit')}}</a></li>
            </ul>
          </li>
        </ul>
      </div>
    </nav>
  </header>
  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar dark-bg">
    @include('admin.mainMenu')
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <div>
            <div class="pull-left">
                <font size=5>@yield('title')</font>
            </div>
            <div class="pull-right">@yield('actions')</div>
            <div class="clearfix"></div>
        </div>
    </section>
    <!-- Main content -->
    <section class="content container-fluid">
            @yield('content')
    </section>
    <!-- content -->
  </div>
  <!-- content-wrapper -->

  <!-- Main Footer -->
  <footer class="main-footer dark-bg">
    <div class="pull-right hidden-xs"> {{__('version')}} 1.0</div>
    </footer>
</div>
<!-- wrapper -->

<!-- jQuery -->
<script src="/admin/dist/js/jquery.min.js"></script>
<script src="/bootstrap/js/bootstrap.min.js"></script>
<script src="/admin/dist/js/ovio.js"></script>

<!-- charts -->
<script src="/admin/plugins/charts/code/modules/exporting.js"></script>
<script src="/admin/plugins/charts/chart-functions.js"></script>
@yield('bottomInsert')
</body>
</html>
