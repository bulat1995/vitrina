@extends('admin.main')

@section('title')
{{ $product->name }}
@endsection

@section('actions')
    <a href="{{ route('admin.shop.products.edit',$product->id) }}">
        <button type="button" class="btn btn-success">{{__('edit')}}</button>
    </a>
@endsection
@section('content')
    @if (session('success'))
            <div class="alert alert-success">{{ session()->get('success')}}</div>
    @endif
    <div class="row">
            <div class="chart-box">
                <div class="card-body">
                    @if ($errors->any())
                        @foreach ($errors->all() as $error)
                            <div class="alert alert-danger">{{ $error }}</div>
                        @endforeach
                    @endif
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.shop.categories.show') }}">{{__('rootCategory')}}</a></li>
                        @foreach($breadcrumb as $crumb)
                            <li class="breadcrumb-item "><a href="{{ route('admin.shop.categories.show',$crumb->id) }}">{{ $crumb->name }}</a></li>
                        @endforeach
                        <li class="breadcrumb-item active">{{ $product->name }}</li>
                        </ol>
                    </nav>
                    <div class="col-md-5">
                    <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
                    <!-- Indicators -->
                            <ol class="carousel-indicators">
                                <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
                                @for($i=1;$i<count($product->photos);$i++)
                                    <li data-target="#carousel-example-generic" data-slide-to="{{ $i }}"></li>
                                @endfor
                            </ol>
                        <!-- Wrapper for slides -->
                            <div class="carousel-inner" role="listbox">
                                @foreach($product->photos as $photo)
                                    <div class="item @if($loop->first) active @endif">
                                    <img src="{{ asset(config('my.product.photo.filePathWeb').$photo->path) }}" alt=""  width="100%" class="img-responsive">
                                    </div>
                                @endforeach
                            <!-- Controls -->
                                <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
                                    <span class="fa fa-chevron-left" aria-hidden="true"></span>
                                    <span class="sr-only">Previous</span>
                                </a>
                                <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
                                    <span class="fa fa-chevron-right" aria-hidden="true"></span>
                                    <span class="sr-only">Next</span>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-7">
            <h3 style="font-size:28px;"> {{$product->name}}</h3>
            <h3 style="font-size:24px;color:#ff5733;">{{__('price')}}: {{$product->price}} &#8381;</h3>
                @foreach($params as $param)
                    <div class="form-group">
                      <b>{{$param->name}}</b>
                        <div>
                            @if($param->inputType=='option')
                                @php
                                    $par=explode('|',$param->regular);
                                    echo $par[$param->value];
                                @endphp
                            {{-- @elseif($param->inputType=='group')
                                    @php
                                        $par=explode('|',$param->regular);
                                        foreach(explode('|',$param->regular) as $par);
                                        echo $par[$param->value];
                                    @endphp
                                    --}}
                            @else
                                {{$param->value}}
                            @endif
                        </div>
                    </div>
                  @endforeach

    </div>
                </div>
                <div class="clearfix"></div>
            </div>
    </div>

@endsection
