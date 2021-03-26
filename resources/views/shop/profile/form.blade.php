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
   {{__('editProfile')}}
@endsection

@section('content')
    @if (session('success'))
            <div class="alert alert-success">{{ session()->get('success')}}</div>
    @endif

      <div class="cart_section">
        <div class="container">
          <div class="row">

            <div class="col-lg-10 offset-lg-1">
              <div class="cart_container">
                <div class="cart_title pb-5">{{__('editProfile')}}</div>

  
    <form method="POST" action="{{route('shop.profile.update',$user->id)}}" enctype="multipart/form-data">
    @method('PATCH')
    @csrf
    <div class="row">
        <div class="col-md-9">
            <div class="chart-box">
                <div class="card-body">
                    @if ($errors->any())
                        @foreach ($errors->all() as $error)
                            <div class="alert alert-danger">{{ $error }}</div>
                        @endforeach
                    @endif
                    <div class="form-group">
                      <label for="name">{{__('Nickname')}}</label>
                      <input type="text" class="form-control" id="name"  name="name" value="{{old('name',$user->name)}}">
                    </div>
                    <div class="form-group">
                      <label for="slug">{{__('Email')}}</label>
                      <input type="text" class="form-control" id="email"  placeholder="E-mail" name="email" value="{{old('email',$user->email)}}">
                    </div>
                    <div class="form-group">
                      <label for="slug">{{__('firstname and secondName')}}</label>
                          <div class="row">
                              <div class="col-md-6">
                                <input type="text" class="form-control" placeholder="{{ __('firstName') }}" name="firstName" value="{{old('firstName',$user->firstName)}}">
                              </div>
                              <div class="col-md-6">
                                <input type="text" class="form-control" placeholder="{{ __('secondName') }}" name="secondName" value="{{old('secondName',$user->secondName)}}">
                              </div>
                          </div>
                     </div>
                     <div class="form-group">
                         <label for="slug">{{__('birthday')}}</label>
                         <input type="date" class="form-control" id="birthday"  name="birthday" value="{{old('birthday',$user->birthday)}}">
                     </div>

                     <div class="form-group">
                       <label for="address">{{__('address')}}</label>
                       <input type="text" class="form-control" id="address"  placeholder="{{__('address')}}" name="address" value="{{old('address',$user->address)}}">
                     </div>
                     

         

                     <div class="form-group form-check">
                       <input type="hidden"  name="keep_old_password" value=0>
                       <input type="checkbox" id="keeppassword"  name="keep_old_password" value=1>
                       <label for="keeppassword">{{__('keep old password')}}</label>
                     </div>


                     <div class="form-group">
                       <label for="password">{{__('password')}}</label>
                       <input type="password" class="form-control" id="password"  placeholder="{{__('password')}}" name="password" value="">
                     </div>


                      <div class="form-group">
                       <label for="password_confirm">{{__('password_confirm')}}</label>
                       <input type="password" class="form-control" id="password_confirm"  placeholder="{{__('password_confirmation')}}" name="password_confirmation" value="">
                     </div>



                     <div class="form-group">
                         <label for="avatar">{{__('avatar')}}</label>
                          <input type="file" id="customFile" name="avatar">
                     </div>


                    <div class="form-group mt-2">
                        <button class="btn btn-success"  type="submit">{{__('edit')}}</button>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
    </form>
    @if($user->exists)
        <div class="col-md-3">
            @if(!empty($user->avatar))
            <div class="chart-box">
                <div class="card-body">
                    <div class="form-group">
                        {{__('avatar')}}
                            <img src="{{ asset(config('my.user.filePathWeb').$user->avatar) }}" width="100%">
                    </div>
                    <form action="{{ route('shop.profile.deleteAvatar',['id'=>$user->id]) }}" method="POST">
                        @method('DELETE')
                        @csrf
                        <button type="submit">{{ __('Delete avatar') }}</button>
                    </form>
                </div>
            </div>
            @endif
        </div>
    @endif
</div>

</div>
</div>
</div>
</div>
</div>
</div>
</div>

@endsection
