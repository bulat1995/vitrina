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
@section('title')
    {{__('userProfile')}} {{ $user->name}}
@endsection

@section('actions')
    <a href="{{ route('admin.profiles.edit',$user->id) }}" class="btn btn-success">
        {{__('edit')}}
    </a>
    <a href="{{ route('admin.messages.show',$user->id) }}" class="btn btn-primary">
        {{__('send message')}}
    </a>
@endsection
@section('content')
      <div class="cart_section">
        <div class="container">
          <div class="row">

            <div class="col-lg-10 offset-lg-1">
              <div class="cart_container">
                <div class="cart_title pb-5">{{__('userProfile')}}</div>


                        @if (session('success'))
                                <div class="alert alert-success">{{ session()->get('success')}}</div>
                        @endif
                      
                          <div class="user-img float-left mr-4">
                            @if(!empty($user->avatar))
                              <img src="{{ asset(config('my.user.filePathWeb').$user->avatar) }}" width="200" alt="User Image">
                              @else
                              <img src="/images/user.svg" width="200" alt="User Image">
                              @endif
                          </div>
                      
                      
                        <div class="mail-contnet">
                          <h4>{{ $user->firstName}} {{ $user->secondName}}
                              <span class="desig"> {{ $user->email}}</span>
                            <a class="float-right" href="{{route('shop.profile.edit',auth()->user()->id)}}">{{__('edit')}}</a>
                           
                          </h4>
                          <p class="m-bot-2">{{ $user->address }}</p>
                          <p class="m-bot-2">{{ $user->birthday }}</p>
                          <h5><b>{{ __('roles') }}:</b>
                          </h5>
                              @foreach($user->roles as $role)
                                  {{ $role->name }},
                              @endforeach
                        </div>
                      
                    </div>
          <div class="clearfix"></div>
    </div>
    </div>
    </div>
    </div>
@endsection
