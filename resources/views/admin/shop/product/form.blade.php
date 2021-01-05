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
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.shop.categories.show') }}">{{__('products')}}</a></li>
            <li class="breadcrumb-item active" aria-current="page">@yield('title')</li>
        </ol>
    </nav>
    @if($product->exists)
    <form method="POST" action="{{route('admin.shop.products.update',$product->id)}}" enctype="multipart/form-data">
    @method('PATCH')
    @else
    <form method="POST" action="{{route('admin.shop.products.store',$product->category_id)}}" enctype="multipart/form-data">
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
                      <label for="name">{{__('Product name')}}:</label>
                      <input type="text" class="form-control" id="name"  placeholder="Philips s308" name="name" value="{{old('name',$product->name)}}">
                    </div>



                    <div class="form-group">
                      <label for="name">{{__('Images')}}:</label>
                      <input type="file" class="form-control-file" id="images"  name="images[]" multiple>
                    </div>


                    <div class="form-group">
                      <label for="category_id">{{__('Parent Category')}}: {{ $category->name }}</label>
                    </div>

                    <div class="form-group">
                      <label for="slug">{{__('Product price')}}:</label>
                      <input type="text" class="form-control" id="price"  placeholder="308" name="price" value="{{old('price',$product->price)}}">
                    </div>
                    @foreach($params as $param)
                                <div class="form-group">
                                    <label for="slug">{{$param->name}}:</label>

                                    @switch($param->inputType)
                                        @case('digits')
                                        <input @if($param->required) required @endif type="text" class="form-control"  pattern="{{$param->regular }}" name="param[{{ $param->id }}]" placeholder="{{$param->name}}" name="regular" value="{{old("param[][$param->value]",$param->value)}}">
                                            @break;
                                            @case('textarea')
                                            <textarea  @if($param->required) required @endif  type="text" pattern="{{$param->regular }}" name="param[{{ $param->id }}]" class="form-control">{{$param->value}} </textarea>
                                                @break;
                                                @default
                                                <input type="text"  @if($param->required) required @endif  class="form-control"    pattern="{{$param->regular }}" name="param[{{ $param->id }}]" placeholder="{{$param->name}}" name="regular" value="{{old("param[][$param->id]",$param->value)}}">
                                                    @break;
                                                @endswitch
                                            </div>
                    @endforeach

                    <div class="form-group mt-2">
                        @if($product->exists)
                                <input class="btn btn-outline-success float-right" value="{{__('edit')}}" type="submit">
                            @else
                                <input class="btn btn-outline-primary float-right" value="{{__('add')}}" type="submit">
                            @endif
                    </div>
                </div>
            </div>
        </div>
    </form>
<div class="col-md-3">
    @if($product->exists)
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
              <label for="name">{{__('Loaded Images')}}:</label>
              <br>
              @foreach($product->photos as $photo)
                  <form action="{{ route('admin.shop.products.photos.destroy',$photo->id) }}" method="POST">
                      @csrf
                      @method('DELETE')
                      <a target="_blank" href="{{ asset('storage/'.$photo->path) }}">
                        <img src="{{ asset('storage/'.$photo->path) }}" style="max-width:100%;margin:2px;">
                        </a>
                      <input type="submit" value="Удалить фото">
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
                            <input type="submit" class="btn btn-outline-danger float-right" name="delete" value="{{__('delete')}}">
                        </div>
                </div>
            </div>
        </form>
        @endif
    @endif
</div>
</div>

@endsection
