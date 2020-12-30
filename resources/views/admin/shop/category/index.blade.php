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
                  @foreach ($items as $item)
                      <tr>
                          <th scope="row" width="60">
                              @if(!empty ($item->logoPath))
                                  <img height="40" align="center" src="{!! asset('storage/'.$item->logoPath) !!}">
                              @endif
                          </th>
                          <td>
                              <h5 class="card-title"><a href="{{ route('admin.shop.categories.show',$item->id) }}">{{ $item->name}}</a></h5>
                              <span style="color:#999">Устройств: {{ ($item->_rgt - $item->_lft -1)/2}}</span>
                          </td>
                          <td align="right">
                              <a href="{{ route('admin.shop.categories.edit',$item->id) }}" class="btn btn-outline-success">
                                  {{__('edit')}}
                              </a>
                          </td>
                      </tr>
                  @endforeach
            </table>
            @endempty
        </div>
    </div>
@endsection
