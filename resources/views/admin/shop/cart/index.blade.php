@extends('admin.main')

@section('title')
{{__('cart')}}
@endsection


@section('actions')

@endsection
@section('content')
        @if (session('success'))
                <div class="alert alert-success">{{ session()->get('success')}}</div>
        @endif
    <div class="chart-box">
        @if(count($carts)==0)
            <div class="alert alert-warning mt-4" role="alert">
                {{ __('unit is empty') }}
            </div>
        @else
            <table class="table mt-4 table-striped">
            	<tr>
            		<th>{{__('product')}}</th>
            		<th>{{__('count')}}</th>
            	</tr>
                  @foreach ($carts as $parameter)
                      <tr>
                          <td>
                          	<a href="{{route('admin.shop.products.show',$parameter->id)}}" target="_blank">
	                              {{ $parameter->name}}
	                          </a>
                          </td>
                          <td>
                              {{ $parameter->quantity}}
                          </td>
                      </tr>
                  @endforeach
            </table>
            @if($carts->total() > $carts->count())
                        {{ $carts->links() }}
            @endif
        @endif
        </div>
    </div>
@endsection
