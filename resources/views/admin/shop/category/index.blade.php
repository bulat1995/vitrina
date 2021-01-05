@extends('admin.main')

@section('title')
    @empty($item->id)
    Категории
    @else
    {{ $item->name }}
    @endempty
@endsection

@section('content')
        @if (session('success'))
                <div class="alert alert-success">{{ session()->get('success')}}</div>
        @endif
    <div class="card">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
            @empty($item->id)
                <li class="breadcrumb-item active" aria-current="page">{{__('Root Category')}}</li>
            @else
                <li class="breadcrumb-item"><a href="{{ route('admin.shop.categories.show') }}">Корневая категория</a></li>
                @foreach($breadcrumb as $crumb)
                    @if($loop->last)
                        <li class="breadcrumb-item active">{{ $crumb->name }}</li>
                    @else
                        <li class="breadcrumb-item "><a href="{{ route('admin.shop.categories.show',$crumb->id) }}">{{ $crumb->name }}</a></li>
                    @endif
                @endforeach
            @endempty
            </ol>
        </nav>
            <div class="row">
                <div class="col-md-8">
                    <font size=4 class="pl-4">
                    @empty($item->id)
                        Корневая категория
                    @else
                            @if(!empty ($item->logoPath))
                                <img height="40" align="center" src="{!! asset('storage/'.$item->logoPath) !!}">
                            @endif
                        {{ $item->name }}
                    @endempty
                    </font>
                </div>
                <div class="col-md-4">
                    @if($item->_lvl!=0)
                        <a href="{{ route('admin.shop.categories.edit',$item->id) }}">
                            <button type="button" class="btn btn-outline-success">{{__('edit')}}</button>
                        </a>
                    @endif
                    <a href="{{ route('admin.shop.categories.create',$parent_id??0) }}">
                        <button type="button" class="btn btn-outline-primary float-right mr-3">{{__('add')}}</button>
                    </a>
                </div>
          </div>

            @if(count($items)==0)
                <div class="alert alert-warning mt-4" role="alert">
                    Данный раздел пока не заполнен
                </div>
            @else
            <table class="table mt-4">
              <tbody>
                  @foreach ($items as $itemLoc)
                      <tr>
                          <th scope="row" width="60">
                              @if(!empty ($itemLoc->logoPath))
                                  <img height="40" align="center" src="{!! asset('storage/'.$itemLoc->logoPath) !!}">
                              @endif
                          </th>
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

            <div class="row">
                <div class="col-md-8">
                    <font size=4 class="pl-4">
                    @empty($item->id)
                        Товары
                    @else
                        @if(!empty ($item->logoPath))
                            <img height="40" align="center" src="{!! asset('storage/'.$item->logoPath) !!}">
                        @endif
                         Товары: [{{ $item->name }}]
                    @endempty
                </font>
            </div>
            <div class="col-md-4">
                <a href="{{ route('admin.shop.products.create',$parent_id??0) }}">
                    <button type="button" class="btn btn-outline-primary float-right mr-3">{{__('addProduct')}}</button>
                </a>
            </div>
        </div>

            @if(!empty($products))


            <table class="table mt-4">
                <tbody>
                    @foreach ($products as $product)
                        <tr>
                            <th scope="row" width="60">
                                @if(!empty ($product->logoPath))
                                    <img height="40" align="center" src="{!! asset('storage/'.$product->logoPath) !!}">
                                @endif
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




@endsection
