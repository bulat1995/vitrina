@extends('admin.main')

@section('title')
Товары
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
            <li class="breadcrumb-item active">Товары</li>
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
        </div>

</div>

@endsection
