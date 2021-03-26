@extends('admin.main')

@section('title')
{{__('shopSliders')}}
@endsection


@section('actions')
    <a href="{{ route('admin.shop.sliders.create') }}">
        <button type="button" class="btn btn-primary">{{__('add')}}</button>
    </a>
@endsection
@section('content')
        @if (session('success'))
                <div class="alert alert-success">{{ session()->get('success')}}</div>
        @endif
    <div class="chart-box">
        @if(count($sliders)==0)
            <div class="alert alert-warning mt-4" role="alert">
                {{ __('unit is empty') }}
            </div>
        @else
            <table class="table mt-4 table-striped">
                  @foreach ($sliders as $parameter)
                      <tr>
                          <td width="200px">
                              <a href="{{ route('admin.shop.sliders.edit',$parameter->id) }}"><img src="{!! asset(Config::get('my.slider.filePathWeb').$parameter->image)!!}" width="200px"></a>
                          </td>
                          <td width="300px">
                              <a href="{{ route('admin.shop.sliders.edit',$parameter->id) }}">{{ $parameter->title}}</a>
                          </td>
                          <td>
                              <a href="{{ route('admin.shop.sliders.edit',$parameter->id) }}">{{ $parameter->describe}}</a>
                          </td>
                          <td width="80px" align="right">
                              @if($parameter->show)
                                  {{ __('published') }}
                              @else
                                  {{ __('not published') }}
                              @endif
                          </td>
                      </tr>
                  @endforeach
            </table>
            @if($sliders->total() > $sliders->count())
                {{ $sliders->links() }}
            @endif
        @endif
        </div>
    </div>
@endsection
