@extends('admin.main')

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
        @if (session('success'))
                <div class="alert alert-success">{{ session()->get('success')}}</div>
        @endif
        <div class="chart-box">
                    <div class="row">
                      <div class="col-md-3">
                          <div class="user-img pull-left">
                                @if(!empty($user->avatar))
                                  <img src="{!! asset(config('my.user.filePathWeb').$user->avatar) !!}" class="img-circle img-responsive" alt="User Image">
                                  @else
                                  <img src="/images/user.svg" class="img-circle img-responsive" alt="User Image">
                                  @endif
                              </div>
                      </div>
                      <div class="col-md-9">
                        <div class="mail-contnet">
                          <h4>{{ $user->firstName}} {{ $user->secondName}}
                              <span class="desig"> {{ $user->email}}</span>
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
                    </div>
          <div class="clearfix"></div>
    </div>
@endsection
