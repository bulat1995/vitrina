@extends('admin.main')

@section('title')
@empty($product->id)
    {{__('adding')}}
    @else
    {{__('editing')}} "{{ $product->name }}"
    @endempty
@endsection

@section('content')
    @if (session('success'))
            <div class="alert alert-success">{{ session()->get('success')}}</div>
    @endif
    <div class="row">
        <div class="col-md-9">
            <div class="chart-box">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.shop.categories.show') }}">{{__('products')}}</a></li>
                        <li class="breadcrumb-item active" aria-current="page">@yield('title')</li>
                    </ol>
                </nav>
            <div class="card">
                <div class="card-body">
                    @if($product->exists)
                        <form method="POST" action="{{route('admin.shop.products.update',$product->id)}}" enctype="multipart/form-data">
                            @method('PATCH')
                        @else
                            <form method="POST" action="{{route('admin.shop.products.store',$product->category_id)}}" enctype="multipart/form-data">
                            @endif
                            @csrf
                    @if ($errors->any())
                        @foreach ($errors->all() as $error)
                            <div class="alert alert-danger">{{ $error }}</div>
                        @endforeach
                    @endif
                    <div class="form-group">
                      <label for="name">{{__('productName')}}:</label>
                      <input type="text" class="form-control" id="name"  placeholder="Philips s308" name="name" value="{{old('name',$product->name)}}">
                    </div>
                    <div class="form-group">
                      <label for="name">{{__('loadedImages')}}:</label>
                      <input type="file" class="form-control-file" id="images"  name="images[]" multiple>
                    </div>
                    <div class="form-group">
                      <label for="category_id">{{__('parentCategory')}}: {{ $category->name }}</label>
                    </div>
                    <div class="form-group">
                      <label for="slug">{{__('price')}}:</label>
                      <input type="text" class="form-control" id="price"  placeholder="308" name="price" value="{{old('price',$product->price)}}">
                    </div>
                    @foreach($params as $param)
                        <div class="form-group">
                            <label for="slug">{{$param->name}}:</label>
                            @switch($param->inputType)
                                @case('digit')
                                    <input @if($param->required) required @endif type="number" class="form-control"  name="parameters[{{ $param->id }}]" placeholder="0"  value="{{old("parameters.$param->id",$param->value)}}">
                                @break;

                                @case('input')
                                    <input @if($param->required) required @endif type="text" class="form-control"  pattern="{{$param->regular }}" name="parameters[{{ $param->id }}]" value="{{old("parameters.$param->id",$param->value)}}">
                                @break

                                @case('text')
                                    <textarea  @if($param->required) required @endif pattern="{{$param->regular }}" name="parameters[{{ $param->id }}]" class="form-control">{{$param->value}}</textarea>
                                @break;

                                @case('date')
                                    <input @if($param->required) required @endif type="date" class="form-control"  name="parameters[{{ $param->id }}]" value="{{old("parameters.$param->id",$param->value)}}">
                                @break;

                                @case('url')
                                    <input @if($param->required) required @endif type="url" class="form-control" name="parameters[{{ $param->id }}]" name="regular" value="{{old("parameters.$param->id",$param->value)}}">
                                @break;

                                @case('option')

                                    <select class="form-control" name="parameters[{{ $param->id }}]" @if($param->required) required @endif>
                                        @foreach (explode('|',$param->regular) as $key=>$value )
                                            <option @if($param->value==$key) selected @endif value={{ $key}}>{{$value}}</option>
                                        @endforeach
                                    </select>
                                @break;

                                {{-- @case('groups')
                                    @foreach (explode('|',$param->regular) as $key=>$value )
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input" name="parameters[{{ $param->id }}][]" id="parameters[{{ $param->id }}]{{ $key }}" value={{$key}}>
                                            <label for="parameters[{{ $param->id }}]{{ $key }}" class="form-check-label">{{$value}}</label>
                                        </div>
                                    @endforeach
                                @break; --}}


                                @default
                                    <input type="text"  @if($param->required) required @endif  class="form-control"    pattern="{{$param->regular }}" name="parameters[{{ $param->id }}]" placeholder="{{$param->name}}" name="regular" value="{{old("parameters.$param->id",$param->value)}}">
                                @break;

                            @endswitch
                        </div>
                    @endforeach
                    <div class="form-group mt-2">
                        @if($product->exists)
                                <input class="btn btn-success pull-right" value="{{__('edit')}}" type="submit">
                            @else
                                <input class="btn btn-primary pull-right" value="{{__('add')}}" type="submit">
                            @endif
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
        </form>
            </div>
            </div>

<div class="col-md-3">
    @if($product->exists)
    <div class="chart-box">
        <div class="card">
            <div class="card-body">
                <div class="form-group">
                    <label for="name">{{__('created')}}:</label>
                    <input disabled type="text" class="form-control" value="{{ old('created_at',$product->created_at) }}">
                </div>
                <div class="form-group">
                    <label for="name">{{__('edited')}}:</label>
                    <input disabled type="text" class="form-control"  value="{{ old('updated_at',$product->updated_at) }}">
                </div>


            <div class="form-group">
              <label for="name">{{__('loadedImages')}}:</label>
              <br>
              @foreach($product->photos as $photo)
                  <form action="{{ route('admin.shop.products.photos.destroy',$photo->id) }}" method="POST">
                      @csrf
                      @method('DELETE')
                      <a target="_blank" href="{{ asset('storage/'.$photo->path) }}">
                        <img src="{{ asset(Config::get('my.product.photo.filePathWeb').$photo->path) }}" style="max-width:100%;margin:2px;">
                        </a>
                      <input type="submit" value="{{__('deleteImage')}}">
                  </form>
              @endforeach
            </div>
            </div>
        </div>

        @if(empty($product->deleted_at))
        <form action="{{ route('admin.shop.products.destroy',$product->id) }}" method="POST">
            @method('DELETE')
            @csrf
            <div class="card mt-1">
                <div class="card-body">
                        <div class="form-group">
                            <input type="submit" class="btn btn-danger pull-right" name="delete" value="{{__('delete')}}">
                        </div>
                </div>
                <div class="clearfix"></div>
            </div>
        </form>
        @endif
    @endif
</div>
</div>
</div>

@endsection
