@extends('admin.main')

@section('title')
{{__('permissions')}}
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
                <a href="{{ route('admin.permissions.create') }}">
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
                          <td>
                              <a href="{{ route('admin.permissions.edit',$item->id) }}">{{ $item->name}}</a>
                          </td>
                      </tr>
                  @endforeach
            </table>

            @if($items->total() > $items->count())
              <br>
              <div class="pagination justify-content-center">
                <div class="col-md-12">
                    <div class="card">
                      <div class="card-body">
                        {{ $items->links() }}
                      </div>
                    </div>
                </div>
              </div>
            @endif

            @endempty
        </div>
    </div>
@endsection
