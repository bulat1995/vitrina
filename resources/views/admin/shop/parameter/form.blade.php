@extends('admin.main')

@section('title')
@empty($parameter->id)
    {{__('adding')}}
    @else
    {{__('editing')}} "{{ $parameter->name }}"
    @endempty
@endsection

@section('actions')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.shop.parameters.index') }}">{{__('shopParameters')}}</a></li>
    </ol>
@endsection

@section('content')
    @if (session('success'))
            <div class="alert alert-success">{{ session()->get('success')}}</div>
    @endif

    @if($parameter->exists)
    <form method="POST" action="{{route('admin.shop.parameters.update',$parameter->id)}}" enctype="multipart/form-data">
    @method('PATCH')
    @else
    <form method="POST" action="{{route('admin.shop.parameters.store')}}" enctype="multipart/form-data">
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
                      <label for="name">{{__('parameterName')}}:</label>
                      <input type="text" class="form-control" id="name"  placeholder="{{ __('price') }}" name="name" value="{{old('name',$parameter->name)}}">
                    </div>
                    <div class="form-group">
                      <label for="rating">{{__('parameterRating')}}:</label>
                      <input type="text" class="form-control" id="rating"  placeholder="500" name="rating" value="{{old('rating',$parameter->rating)}}">
                    </div>
                    <div class="form-group">
                      <label for="slug">{{__('parameterType')}}:</label>
                      <select class="form-control" id="inputType"  name="inputType">
                      @foreach($parameter::inputTypes as $inputType)
                          <option @if($parameter->inputType==$inputType) selected @endif value="{{ $inputType }}">{{ __($inputType) }}</option>
                      @endforeach
                      </select>
                    </div>

                    <div class="form-group">
                      <div class="form-check">
                        <input type="hidden"  name="required" value=0>
                        <input type="checkbox" id="gridCheck" name="required" @if($parameter->required) checked @endif value=1>
                        <label class="form-check-label" for="gridCheck">
                          {{__('parameterRequired')}}
                        </label>
                    </div>
                    </div>

                    <div class="form-group">
                      <label for="slug">{{__('parameterRegular')}}:</label>
                      <input type="text" class="form-control" id="regular"  placeholder="/([\w|\W+])/" name="regular" value="{{old('regular',$parameter->regular)}}">
                    </div>
                    <div class="form-group mt-2">
                        @if($parameter->exists)
                            <input class="btn btn-success pull-right" value="{{__('edit')}}" type="submit">
                        @else
                            <input class="btn btn-primary pull-right" value="{{__('add')}}" type="submit">
                        @endif
                    </div>
            </form>
            @if($parameter->exists)
                @if(empty($parameter->deleted_at))
                <form action="{{ route('admin.shop.parameters.destroy',$parameter->id) }}" method="POST">
                    @method('DELETE')
                    @csrf
                    <div class="card mt-1">
                        <div class="form-group">
                            <input type="submit" class="btn btn-danger pull-right"  style="margin-right:20px" name="delete" value="{{__('delete')}}">
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </form>
                @endif
            @endif
    <div class="clearfix"></div>
</div>
</div>
</div>



@endsection
