@extends('admin.main')

@section('title')
{{__('reviews')}}
@endsection


@section('actions')

@endsection
@section('content')
        @if (session('success'))
                <div class="alert alert-success">{{ session()->get('success')}}</div>
        @endif
    <div class="chart-box">
        @if(count($reviews)==0)
            <div class="alert alert-warning mt-4" role="alert">
                {{ __('unit is empty') }}
            </div>
        @else
            <table class="table mt-4 table-striped">
              <tr>
                <th>{{ __('image') }}</th>
                <th>{{ __('product') }}</th>
                <th>{{ __('review') }}</th>
                <th>{{ __('estimate') }}</th>
                <th>{{ __('user') }}</th>
              </tr>
                  @foreach ($reviews as $parameter)
                      <tr>
                          <td>
                              <a target="_blank" href="{{ route('admin.shop.products.show',$parameter->product_id) }}">
                                @if(!empty($parameter->photo))
                                 <img  src="{{ asset(Config::get('my.product.photo.filePathWeb').$parameter->photo) }}"  width="60">
                                @else
                                Нет изображения
                                @endif
                                
                              </a>
                          </td>
                          <td>
                              <a target="_blank" href="{{ route('admin.shop.products.show',$parameter->product_id) }}">{{ $parameter->product_name}}</a>
                          </td>
                          <td>
                              <a href="{{ route('admin.shop.reviews.edit',$parameter->id) }}">{{ $parameter->review}}</a>
                          </td>
                          <td>
                              <a href="{{ route('admin.shop.reviews.edit',$parameter->id) }}">{{ $parameter->estimate}}</a>
                          </td>
                          <td>
                              <a href="{{ route('admin.profiles.show',$parameter->user_id) }}">{{ $parameter->username}}</a>
                          </td>
                      </tr>
                  @endforeach
            </table>
            @if($reviews->total() > $reviews->count())
                        {{ $reviews->links() }}
            @endif
        @endif
        </div>
    </div>
@endsection
