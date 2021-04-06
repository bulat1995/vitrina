@extends('admin.main')

@section('title')
    @empty($item->id)
    {{__('categories')}}
    @else
    {{ $item->name }}
    @endempty
@endsection
@section('actions')
        @if($item->_lvl!=0)
            <a href="{{ route('admin.shop.categories.edit',$item->id) }}">
                <button type="button" class="btn btn-success">{{__('edit')}}</button>
            </a>
        @endif
        <a href="{{ route('admin.shop.categories.create',$parent_id??0) }}">
            <button type="button" class="btn btn-primary">{{__('add')}}</button>
        </a>

@endsection

@section('content')

    <div class="chart-box">
        <ol class="breadcrumb">
        @empty($item->id)
            <li class="breadcrumb-item active" aria-current="page">{{__('rootCategory')}}</li>
        @else
            <li class="breadcrumb-item"><a href="{{ route('admin.shop.categories.show') }}">{{__('rootCategory')}}</a></li>
            @foreach($breadcrumb as $crumb)
                @if($loop->last)
                    <li class="breadcrumb-item active">{{ $crumb->name }}</li>
                @else
                    <li class="breadcrumb-item "><a href="{{ route('admin.shop.categories.show',$crumb->id) }}">{{ $crumb->name }}</a></li>
                @endif
            @endforeach
        @endempty
    </ol>
        @if (session('success'))
                <div class="alert alert-success">{{ session()->get('success')}}</div>
        @endif

            @if(count($items)==0)
                <div class="alert alert-warning mt-4" role="alert">
                    {{__('emptyModule')}}
                </div>
            @else
            <table class="table mt-4">
              <tbody>
                  @foreach ($items as $itemLoc)
                      <tr>
                          <td scope="row" width="60">
                              @if(!empty($itemLoc->logoPath))
                                  <img width="40" src="{!! asset(Config::get('my.category.filePathWeb').$itemLoc->logoPath) !!}">
                              @endif
                          </td>
                          <td>
                              <h5 class="card-title"><a href="{{ route('admin.shop.categories.show',$itemLoc->id) }}">{{ $itemLoc->name}}</a></h5>
                          </td>
                          <td align="right">
                              <a href="{{ route('admin.shop.categories.edit',$itemLoc->id) }}" class="btn btn-outline-success">
                                  {{__('edit')}}
                              </a>
                          </td>
                      </tr>
                  @endforeach
            </table>
            @endempty
</div>

@if(!empty($item->id))
    <div class="chart-box">
            <div class="row">
                <div class="col-md-8">
                    <font size=4 class="pl-4">
                    @empty($item->id)
                        {{__('products')}}
                    @else
                        @if(!empty ($item->logoPath))
                            <img height="40" align="center" src="{!! asset(Config::get('my.category.filePathWeb').$item->logoPath) !!}">
                        @endif
                         {{__('productsInCategory')}} {{ $item->name }}
                    @endempty
                </font>
            </div>
            <div class="col-md-4">
                <a href="{{ route('admin.shop.products.create',$item->id??1) }}">
                    <button type="button" class="btn btn-primary pull-right mr-3">{{__('addProduct')}}</button>
                </a>
            </div>
        </div>

            @if(!empty($products))


            <table class="table mt-4">
                <tbody>
                    @foreach ($products as $product)
                        <tr>
                            <th scope="row" width="60">
                                @foreach($product->photos as $photo)
                                    @if($loop->first)
                                        <img  width="60" src="{{ asset(Config::get('my.product.photo.filePathWeb').$photo->path) }}" >
                                    @endif
                                @endforeach


                            </th>
                            <td>
                                <h5 class="card-title"><a href="{{ route('admin.shop.products.show',$product->id) }}">{{ $product->name}}</a></h5>
                            </td>
                            <td align="right">
                                <a href="{{ route('admin.shop.products.edit',$product->id) }}" class="btn btn-outline-success">
                                    {{__('edit')}}
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </table>

            @endif
        </div>
    </div>
@endif




@endsection
