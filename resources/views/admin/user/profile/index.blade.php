@extends('admin.main')

@section('title')
    {{__('users')}}
@endsection

@section('actions')

@endsection
@section('content')
        @if (session('success'))
                <div class="alert alert-success">{{ session()->get('success')}}</div>
        @endif
    <div class="chart-box">
            @if(count($users)==0)
                <div class="alert alert-warning mt-4" role="alert">
                    {{ __('unit is empty') }}
                </div>
            @else
            <table class="table">
                <thead>
                    <th>{{ __('avatar') }} </th>
                    <th>{{ __('Nickname') }}  </th>
                    <th>{{ __('roles') }} </th>
                    <th></th>
                </thead>
              <tbody>
                  @foreach ($users as $user)
                      <tr>
                          <th scope="row" width="60">
                                @if(empty($user['avatar']))
                                <img height="40" align="center" src="/images/user.svg" width="100%">
                                @else
                                <img height="40" align="center" src="{{ asset(config('my.user.filePathWeb').$user['avatar']) }}" width="100%">
                                @endif
                          </th>
                          <td>
                              <h5 class="card-title"><a href="{{ route('admin.profiles.show',$user['id']) }}">{{ $user['name']}}</a></h5>
                          </td>
                          <td>
                              @foreach($user['roles'] as $role)
                                  <p>{{$role['name']}}</p>
                              @endforeach
                          </td>
                          <td align="right">
                              <a href="{{ route('admin.profiles.edit',$user['id']) }}" class="btn btn-success">
                                  {{__('edit')}}
                              </a>
                          </td>
                      </tr>
                  @endforeach
            </table>
            @endempty
        </div>
    </div>
@endsection
