@extends('admin.main')

@section('title')
{{__('shopParameters')}}
@endsection


@section('actions')
    <a href="{{ route('admin.shop.parameters.create') }}">
        <button type="button" class="btn btn-primary">{{__('add')}}</button>
    </a>
@endsection
@section('content')
        @if (session('success'))
                <div class="alert alert-success">{{ session()->get('success')}}</div>
        @endif
    <div class="chart-box">
        @if(count($parameters)==0)
            <div class="alert alert-warning mt-4" role="alert">
                {{ __('unit is empty') }}
            </div>
        @else
            <table class="table mt-4">
                  @foreach ($parameters as $parameter)
                      <tr>
                          <td>
                              <a href="{{ route('admin.shop.parameters.edit',$parameter->id) }}">{{ $parameter->name}}</a>
                          </td>
                      </tr>
                  @endforeach
            </table>
            @if($parameters->total() > $parameters->count())
                        {{ $parameters->links() }}
            @endif
        @endif
        </div>
    </div>
@endsection
