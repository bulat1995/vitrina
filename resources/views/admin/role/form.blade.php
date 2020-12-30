@extends('admin.main')

@section('title')
@empty($role->id)
    {{__('adding')}}
    @else
    {{__('editing')}} "{{ $role->name }}"
    @endempty
@endsection

@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.roles.index') }}">{{__('Roles')}}</a></li>
            <li class="breadcrumb-item active" aria-current="page">@yield('title')</li>
        </ol>
    </nav>
    @if($role->exists)
    <form method="POST" action="{{route('admin.roles.update',$role->id)}}" enctype="multipart/form-data">
    @method('PATCH')
    @else
    <form method="POST" action="{{route('admin.roles.store')}}" enctype="multipart/form-data">
    @endif
    @csrf
    <div class="row">
        <div class="col-md-9">
            <div class="card">
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
                    @if ($errors->any())
                        @foreach ($errors->all() as $error)
                            <div class="alert alert-danger">{{ $error }}</div>
                        @endforeach
                    @endif
                    <div class="form-group">
                      <label for="name">{{__('Role name')}}</label>
                      <input type="text" class="form-control" id="name"  placeholder="Дизайнер" name="name" value="{{old('name',$role->name)}}">
                    </div>
                    <div class="form-group">
                      <label for="slug">{{__('Slug role')}}</label>
                      <input type="text" class="form-control" id="slug"  placeholder="Designer" name="slug" value="{{old('slug',$role->slug)}}">
                    </div>
                    <div class="form-group">
                      <label for="parent">{{__('permissions')}}</label>
                        @foreach ($permissions as $permission)
                         <div class="form-group form-check">
                              <input type="checkbox" id="permissions_id[]{{ $permission->id }}"  name="permissions_id[]"  value="{{ $permission->id }}" @if($permission->has==1) checked="true" @endif >
                              <label for="permissions_id[]{{ $permission->id }}">{{ $permission->name }}</label>
                          </div>
                        @endforeach
                    </div>
                    <div class="form-group mt-2">
                        @if($role->exists)
                                <input class="btn btn-outline-success float-right" value="{{__('edit')}}" type="submit">
                            @else
                                <input class="btn btn-outline-primary float-right" value="{{__('add')}}" type="submit">
                            @endif
                    </div>
                </div>
            </div>
        </div>
    </form>
    @if($role->exists)
        <div class="col-md-3">
            <div class="card">
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
            <div class="card mt-1">
                <div class="card-body">
                    <div class="form-group">
                        <label for="name">Удалено:</label>
                        <input disabled type="text" class="form-control"  value="{{ old('deleted_at',$role->deleted_at) }}">
                    </div>
                    <form action={{ route('admin.roles.restore',$role->id) }} method="POST">
                        @method('PATCH')
                        @csrf
                        <div class="form-group  form-check ">
                            <input type="hidden" name="withDescedents" value=0>
                            <input type="checkbox" class="form-check-input"  value=1 name="withDescedents" id="restoreWithDescedents">
                            <label for="restoreWithDescedents"> Восстановить с потомками</label>
                        </div>
                        <div class="form-group">
                            <input type="submit" class=" form-control btn btn-outline-dark"  name="restore" value="{{__('restore')}}">
                        </div>
                    </form>
                </div>
            </div>
            @endif
        @if(empty($role->deleted_at))
        <form action="{{ route('admin.roles.destroy',$role->id) }}" method="POST">
            @method('DELETE')
            @csrf
            <div class="card mt-1">
                <div class="card-body">

                        <div class="form-group">
                            <input type="submit" class="btn btn-outline-danger float-right" name="delete" value="{{__('delete')}}">
                        </div>
                </div>
            </div>
        </form>
        @endif
        </div>
    @endif
</div>

@endsection
