@extends('admin.main')

@section('title')
@empty($permission->id)
    {{__('adding')}}
    @else
    {{__('editing')}} "{{ $permission->name }}"
    @endempty
@endsection

@section('content')
    @if (session('success'))
            <div class="alert alert-success">{{ session()->get('success')}}</div>
    @endif
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.permissions.index') }}">{{__('permissions')}}</a></li>
            <li class="breadcrumb-item active" aria-current="page">@yield('title')</li>
        </ol>
    </nav>
    @if($permission->exists)
    <form method="POST" action="{{route('admin.permissions.update',$permission->id)}}" enctype="multipart/form-data">
    @method('PATCH')
    @else
    <form method="POST" action="{{route('admin.permissions.store')}}" enctype="multipart/form-data">
    @endif
    @csrf
    <div class="row">
        <div class="col-md-9">
            <div class="chart-box">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-8">
                            <font size=3>
                                @yield('title')
                            </font>
                        </div>
                    </div>
                  </div>
                <div class="card-body">
                    @if (isset($errors))
                    @if ($errors->any())
                        @foreach ($errors->all() as $error)
                            <div class="alert alert-danger">{{ $error }}</div>
                        @endforeach
                    @endif
                    @endif
                    <div class="form-group">
                      <label for="name">{{__('permissionName')}}:</label>
                      <input type="text" class="form-control" id="name"  placeholder="{{ __('permissionName') }}" name="name" value="{{old('name',$permission->name)}}">
                    </div>

                    <div class="form-group">
                      <label for="action_name">{{__('permissionActionName')}}:</label>
                      <input type="text" class="form-control" id="action_name"  placeholder="{{__('adding')}}" name="action_name" value="{{old('action_name',$permission->action_name)}}">
                    </div>

                    <div class="form-group">
                      <label for="slug">{{__('permissionSlug')}}:</label>
                      <input type="text" class="form-control" id="slug"  placeholder="admin.users.create" name="slug" value="{{old('slug',$permission->slug)}}">
                    </div>
                    <div class="form-group mt-2">
                        @if($permission->exists)
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
    @if($permission->exists)
        <div class="col-md-3">
            <div class="chart-box">
                <div class="card-body">
                    <div class="form-group">
                        <label for="name">{{__('created')}}:</label>
                        <input disabled type="text" class="form-control" value="{{ old('created_at',$permission->created_at) }}">
                    </div>
                    <div class="form-group">
                        <label for="name">{{__('edited')}}:</label>
                        <input disabled type="text" class="form-control"  value="{{ old('updated_at',$permission->updated_at) }}">
                    </div>
                </div>
            </div>
        @if(empty($permission->deleted_at))
        <form action="{{ route('admin.permissions.destroy',$permission->id) }}" method="POST">
            @method('DELETE')
            @csrf
            <div class="card mt-1">
                <div class="card-body">

                        <div class="form-group">
                            <input type="submit" class="btn btn-danger pull-right" name="delete" value="{{__('delete')}}">
                        </div>
                        <div class="clearfix"></div>
                </div>
            </div>
        </form>
        @endif
        </div>
    @endif
</div>

@endsection
