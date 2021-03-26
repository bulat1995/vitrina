@extends('admin.main')

@section('title')
@empty($item->slug)
    {{__('siteParameters')}}
    @else
    {{ $item->name }}
    @endempty
@endsection

@section('actions')
    <a href="{{ route('admin.site.parameters.create') }}">
        <button type="button" class="btn btn-primary pull-right mr-3">{{__('add')}}</button>
    </a>
@endsection
@section('content')
        @if (session('success'))
                <div class="alert alert-success">{{ session()->get('success')}}</div>
        @endif
    <div class="chart-box">
            @if(count($items)==0)
                <div class="alert alert-warning mt-4" role="alert">
                    {{ __('unit is empty') }}
                </div>
            @else
            <table class="table mt-4">
              <tbody>
                  @foreach ($items as $item)
                      <tr>
                          <td>
                              <h5 class="card-title">{{ $item->name}}</h5>
                          </td>
                          <td align="right">
                              <a href="{{ route('admin.site.parameters.edit',$item->slug) }}" class="btn btn-success">
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
