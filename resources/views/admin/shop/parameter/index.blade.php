@extends('admin.main')

@section('title')
{{__('shop.parameters')}}
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
                <a href="{{ route('admin.shop.parameters.create') }}">
                    <button type="button" class="btn btn-outline-primary float-right mr-3">{{__('add')}}</button>
                </a>
                </div>
          </div>
            @if(count($parameters)==0)
                <div class="alert alert-warning mt-4" role="alert">
                    Данный раздел пока не заполнен
                </div>
            @else
            <table class="table mt-4">
              <tbody>
                  @foreach ($parameters as $parameter)
                      <tr>
                          <td>
                              <a href="{{ route('admin.shop.parameters.edit',$parameter->id) }}">{{ $parameter->name}}</a>
                          </td>
                      </tr>
                  @endforeach
            </table>

            {{-- @if($parameters->total() > $parameters->count())
                        {{ $parameters->links() }}
            @endif --}}

            @endempty
        </div>
    </div>
@endsection
