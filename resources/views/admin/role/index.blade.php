@extends('admin.main')

@section('title')
    @empty($item->id)
    {{__('Roles')}}
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
                <li class="breadcrumb-item active" aria-current="page">@yield('title')</li>
            </ol>
        </nav>
            <div class="row">
                <div class="col-md-10">
                    <font size=4 class="pl-4">
                        @yield('title')
                    </font>
                </div>
                <div class="col-md-2">
                <a href="{{ route('admin.roles.create') }}">
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
                              <h5 class="card-title"><a href="{{ route('admin.roles.show',$item->id) }}">{{ $item->name}}</a></h5>
                          </td>
                          <td align="right">
                              <a href="{{ route('admin.roles.edit',$item->id) }}" class="btn btn-outline-success">
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
