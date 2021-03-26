@extends('admin.main')

@section('title')
@empty($user->id)
    {{__('adding')}}
    @else
    {{__('editing')}} "{{ $user->name }}"
    @endempty
@endsection

@section('actions')

    @if(empty($user->deleted_at))
    <form action="{{ route('admin.profiles.destroy',$user->id) }}" method="POST">
        @method('DELETE')
        @csrf
        <div class="card mt-1">
            <div class="card-body">
                    <div class="form-group">
                        <input type="submit" class="btn btn-danger" name="delete" value="{{__('deleteUser')}}">
                    </div>
            </div>
        </div>
    </form>
    @endif
@endsection

@section('content')
    @if (session('success'))
            <div class="alert alert-success">{{ session()->get('success')}}</div>
    @endif

    @if($user->exists)
    <form method="POST" action="{{route('admin.profiles.update',$user->id)}}" enctype="multipart/form-data">
    @method('PATCH')
    @else
    <form method="POST" action="{{route('admin.profiles.store')}}" enctype="multipart/form-data">
    @endif
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
                      <input type="text" class="form-control" id="name"  placeholder="" name="name" value="{{old('name',$user->name)}}">
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


                     <div class="form-group">
                         <label for="avatar">{{__('avatar')}}</label>
                          <input type="file" id="customFile" name="avatar">
                     </div>

                     
                         <div class="form-group">
                           <label for="parent">{{__('roles')}}</label>
                           @foreach ($roles as $role)
                               <div class="form-group">
                                    <input type="checkbox" id="role_{{ $role->id }}" name="roles[]" @if($role->has) checked @endif value={{ $role->id }}>
                                    <label for="role_{{ $role->id }}">{{ $role->name }}</label>
                                </div>
                           @endforeach
                         </div>
                        <div class="form-group">
                          <label for="parent">{{__('permissions')}}</label>
                        </div>
                              <input type="hidden" name="permissionsId"  value="">
                        <table class="table ">
                        @php $lastName=''; @endphp
                        @foreach ($permissions as $permission)
                            @php
                                if($permission->name !=$lastName && $lastName!=''){
                                    echo '</tr>';
                                }
                                if($permission->name !=$lastName ){
                                    $lastName=$permission->name;
                                    echo '<tr><th>'.$permission->name.'</th>';
                                }
                            @endphp
                            <td>
                              <input type="checkbox" id="permissionsId[]{{ $permission->id }}"  name="permissionsId[]"  value="{{ $permission->id }}" @if($permission->has==1) checked="true" @endif >
                              <label for="permissionsId[]{{ $permission->id }}"> {{ $permission->action_name }}</label>
                            </td>
                        @endforeach
                        </table>
             


                    <div class="form-group mt-2">
                        @if($user->exists)
                                <input class="btn btn-success pull-right" value="{{__('edit')}}" type="submit">
                            @else
                                <input class="btn btn-primary pull-right" value="{{__('add')}}" type="submit">
                            @endif
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
                    <form action="{{ route('admin.profiles.deleteAvatar',$user->id) }}" method="POST">
                        @method('DELETE')
                        @csrf
                        <input type="hidden" name="deleteLogo" value="{{ $user->id }}">
                        <button type="submit">{{ __('deleteAvatar') }}</button>
                    </form>
                </div>
            </div>
            @endif
            @if(!empty($user->deleted_at))
            <div class="card mt-1">
                <div class="card-body">
                    <div class="form-group">
                        <label for="name">{{__('deletedAt')}}:</label>
                        <input disabled type="text" class="form-control"  value="{{ old('deleted_at',$user->deleted_at) }}">
                    </div>
                    <form action={{ route('admin.profiles.restore',$user->id) }} method="POST">
                        @method('PATCH')
                        @csrf
                        <div class="form-group  form-check ">
                            <input type="hidden" name="withDescedents" value=0>
                            <input type="checkbox" class="form-check-input"  value=1 name="withDescedents" id="restoreWithDescedents">
                            <label for="restoreWithDescedents"> {{__('restoreWithDescedents')}}</label>
                        </div>
                        <div class="form-group">
                            <input type="submit" class=" form-control btn btn-dark"  name="restore" value="{{__('restore')}}">
                        </div>
                    </form>
                </div>
            </div>
            @endif

        </div>
    @endif
</div>

@endsection
