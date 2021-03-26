@extends('admin.main')

@section('title')
@empty($parameter->slug)
    {{__('adding')}}
    @else
    {{__('editing')}} "{{ $parameter->name }}"
    @endempty
@endsection
@section('content')
    <div class="row">
        <div class="col-md-9">
            <div class="chart-box">
            @if($parameter->exists)
                <form method="POST" action="{{route('admin.site.parameters.update',$parameter->slug)}}" enctype="multipart/form-data">
                    @method('PATCH')
                @else
                    <form method="POST" action="{{route('admin.site.parameters.store')}}" enctype="multipart/form-data">
                    @endif
                    @csrf
            <div class="card">
                <div class="card-body">
                    @if ($errors->any())
                        @foreach ($errors->all() as $error)
                            <div class="alert alert-danger">{{ $error }}</div>
                        @endforeach
                    @endif
                    <div class="form-group">
                      <label for="name">{{__('parameterName')}}</label>
                      <input type="text" class="form-control" id="name"  placeholder="" name="name" value="{{old('name',$parameter->name)}}">
                    </div>
                    <div class="form-group">
                      <label for="slug">{{__('parameterSlug')}}</label>
                      <input type="text" class="form-control" id="slug"  placeholder="numberPhone" name="slug" value="{{old('slug',$parameter->slug)}}">
                    </div>
                    <div class="form-group">
                      <label for="slug">{{__('parameterValue')}}</label>
                      <textarea type="text" class="form-control" id="value"  placeholder="+7 900 000 00 00" name="value" >{{old('value',$parameter->value)}}</textarea>
                    </div>
                    <div class="form-group mt-2">
                        @if($parameter->exists)
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
    @if($parameter->exists)
        <div class="col-md-3">
            <div class="chart-box">
                <div class="card-body">
                    <div class="form-group">
                        <label for="name">{{__('created')}}:</label>
                        <input disabled type="text" class="form-control" value="{{ old('created_at',$parameter->created_at) }}">
                    </div>
                    <div class="form-group">
                        <label for="name">{{__('edited')}}:</label>
                        <input disabled type="text" class="form-control"  value="{{ old('updated_at',$parameter->updated_at) }}">
                    </div>
                </div>
                <form action="{{ route('admin.site.parameters.destroy',$parameter->slug) }}" method="POST">
                    @csrf
                    @method('delete')
                    <input type="submit" class="btn pull-right btn-danger" value="{{ __('delete') }}">
                </form>
                <div class="clearfix"></div>
            </div>
        </div>
    @endif
</div>

@endsection
