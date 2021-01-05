@extends('admin.main')

@section('title')
{{ $product->name }}
@endsection

@section('content')
    @if (session('success'))
            <div class="alert alert-success">{{ session()->get('success')}}</div>
    @endif
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.shop.categories.show') }}">Корневая категория</a></li>
            @foreach($breadcrumb as $crumb)
                    <li class="breadcrumb-item "><a href="{{ route('admin.shop.categories.show',$crumb->id) }}">{{ $crumb->name }}</a></li>
            @endforeach
            <li class="breadcrumb-item active">{{ $product->name }}</li>
        </ol>
    </nav>

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
                      <label for="slug">{{__('Product price')}}:</label>
                      <input type="text" class="form-control" id="price"  placeholder="308" name="price" value="{{old('price',$product->price)}}">
                    </div>

                    <div id="carouselExampleControls" class="carousel slide carousel-fade" data-ride="carousel">
                      <div class="carousel-inner">
                          @foreach($product->photos as $photo)
                              <div class="carousel-item @if($loop->first) active @endif">
                                  <img src="{{ asset('storage/'.$photo->path) }}" class="d-block w-100" alt="...">
                                  <div class="carousel-caption d-none d-md-block" style="background:rgba(0,0,0,150)">
                                      <h5>Second slide label</h5>
                                      <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                                    </div>
                              </div>
                        @endforeach
                      </div>
                      <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                      </a>
                      <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                      </a>
                    </div>



                    @foreach($params as $param)
                    <div class="form-group">
                      <label for="slug">{{$param->name}}:</label>

                      @switch($param->inputType)
                          @case('digits')
                          <input required type="text" class="form-control"  pattern="{{$param->regular }}" name="param[{{ $param->id }}]" placeholder="{{$param->name}}" name="regular" value="{{old("param[][$param->value]",$param->value)}}">
                          @break;
                          @case('textarea')
                          <textarea required type="text" pattern="{{$param->regular }}" name="param[{{ $param->id }}]" class="form-control">{{$param->value}} {{old("param[][$param->id]",$product->regular)}}</textarea>
                          @break;
                          @default
                          <input type="text" required class="form-control"    pattern="{{$param->regular }}" name="param[{{ $param->id }}]" placeholder="{{$param->name}}" name="regular" value="{{old("param[][$param->id]",$param->value)}}">
                          @break;
                      @endswitch
                  @endforeach

                </div>
            </div>
        </div>

</div>

@endsection
