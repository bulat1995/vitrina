@extends('admin.main')

@section('title')
@empty($parameter->id)
    {{__('adding')}}
    @else
    {{__('editing')}} "{{ $parameter->name }}"
    @endempty
@endsection

@section('content')
    @if (session('success'))
            <div class="alert alert-success">{{ session()->get('success')}}</div>
    @endif
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.shop.parameters.index') }}">{{__('shop.parameters')}}</a></li>
            <li class="breadcrumb-item active" aria-current="page">@yield('title')</li>
        </ol>
    </nav>
    @if($parameter->exists)
    <form method="POST" action="{{route('admin.shop.parameters.update',$parameter->id)}}" enctype="multipart/form-data">
    @method('PATCH')
    @else
    <form method="POST" action="{{route('admin.shop.parameters.store')}}" enctype="multipart/form-data">
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
                      <label for="name">{{__('Parameter name')}}:</label>
                      <input type="text" class="form-control" id="name"  placeholder="Добавление нового пользователя" name="name" value="{{old('name',$parameter->name)}}">
                    </div>


                    <div class="form-group">
                      <label for="slug">{{__('Parameter type')}}:</label>
                      <select class="form-control" id="inputType"  name="inputType">
                          @foreach($parameter::inputTypes as $inputType)
                              <option>{{ $inputType }}</option>
                          @endforeach
                      </select>
                    </div>


                    <div class="form-group">
                      <div class="form-check">
                        <input type="hidden"  name="required" value=0>
                        <input type="checkbox" id="gridCheck" name="required" @if($parameter->required) checked @endif value=1>
                        <label class="form-check-label" for="gridCheck">
                          {{__('Parameter required')}}
                        </label>
                    </div>
                    </div>

                    <div class="form-group">
                      <label for="slug">{{__('Parameter regular')}}:</label>
                      <input type="text" class="form-control" id="regular"  placeholder="admin.users.create" name="regular" value="{{old('regular',$parameter->regular)}}">
                    </div>
                    <div class="form-group mt-2">
                        @if($parameter->exists)
                                <input class="btn btn-outline-success float-right" value="{{__('edit')}}" type="submit">
                            @else
                                <input class="btn btn-outline-primary float-right" value="{{__('add')}}" type="submit">
                            @endif
                    </div>
                </div>
            </div>
        </div>
    </form>
    @if($parameter->exists)
        <div class="col-md-3">
        @if(empty($parameter->deleted_at))
        <form action="{{ route('admin.shop.parameters.destroy',$parameter->id) }}" method="POST">
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
