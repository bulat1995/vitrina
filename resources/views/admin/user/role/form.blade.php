@extends('admin.main')

@section('title')
@empty($role->id)
    {{__('adding')}}
    @else
    {{__('editing')}} "{{ $role->name }}"
    @endempty
@endsection

@section('content')
    <div class="row">
        <div class="col-md-9">
            <div class="chart-box">
            @if($role->exists)
                <form method="POST" action="{{route('admin.roles.update',$role->id)}}" enctype="multipart/form-data">
                    @method('PATCH')
                @else
                    <form method="POST" action="{{route('admin.roles.store')}}" enctype="multipart/form-data">
                    @endif
                    @csrf
            <div class="card">

                <div class="card-body">
                    @if (isset($errors))
                    @if ($errors->any())
                        @foreach ($errors->all() as $error)
                            <div class="alert alert-danger">{{ $error }}</div>
                        @endforeach
                    @endif
                    @endif
                    <div class="form-group">
                      <label for="name">{{__('roleName')}}</label>
                      <input type="text" class="form-control" id="name"  placeholder="" name="name" value="{{old('name',$role->name)}}">
                    </div>
                    <div class="form-group">
                      <label for="slug">{{__('slugRole')}}</label>
                      <input type="text" class="form-control" id="slug"  placeholder="Designer" name="slug" value="{{old('slug',$role->slug)}}">
                    </div>
                    <div class="form-group">
                      <label for="parent">{{__('permissions')}}</label>
                    </div>

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
                        @if($role->exists)
                                <input class="btn btn-success pull-right" value="{{__('edit')}}" type="submit">
                            @else
                                <input class="btn btn-primary pull-right" value="{{__('add')}}" type="submit">
                            @endif
                    </div>
                    <div class="clearfix"></div>
                </form>
                </div>
            </div>
        </div>
    </div>
    @if($role->exists)
        <div class="col-md-3">
            <div class="chart-box">
                <div class="card-body">
                    <div class="form-group">
                        <label for="name">{{__('created')}}:</label>
                        <input disabled type="text" class="form-control" value="{{ old('created_at',$role->created_at) }}">
                    </div>
                    <div class="form-group">
                        <label for="name">{{__('edited')}}:</label>
                        <input disabled type="text" class="form-control"  value="{{ old('updated_at',$role->updated_at) }}">
                    </div>
                </div>
            </div>
            @if(!empty($role->deleted_at))
            <div class="chart-box mt-1">
                <div class="card-body">
                    <div class="form-group">
                        <label for="name">{{__('deletedAt')}}:</label>
                        <input disabled type="text" class="form-control"  value="{{ old('deleted_at',$role->deleted_at) }}">
                    </div>
                    <form action={{ route('admin.roles.restore',$role->id) }} method="POST">
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
        @if(empty($role->deleted_at))
        <form action="{{ route('admin.roles.destroy',$role->id) }}" method="POST">
            @method('DELETE')
            @csrf
            <div class="chart-box mt-1">
                <div class="card-body">

                        <div class="form-group">
                            <input type="submit" class="btn btn-danger pull-right" name="delete" value="{{__('delete')}}">
                        </div>
                </div>
                <div class="clearfix"></div>
            </div>
        </form>
        @endif
        </div>
    @endif
</div>

@endsection
