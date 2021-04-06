@extends('admin.main')

@section('title')
{{__('staticPages')}}
@endsection

@section('actions')
    <a href="{{ route('admin.pages.create') }}">
        <button type="button" class="btn btn-primary float-right mr-3">{{__('add')}}</button>
    </a>
@endsection
@section('content')
        @if (session('success'))
                <div class="alert alert-success">{{ session()->get('success')}}</div>
        @endif
    <div class="chart-box">
            @if(count($pages)==0)
                <div class="alert alert-warning mt-4" role="alert">
                    {{ __('unit is empty') }}
                </div>
            @else
                <table class="table mt-4">
                  <tbody>
                      @foreach ($pages as $page)
                          <tr>
                              <th scope="row" >
                                  {{$page->slug}}
                              </th>
                              <td>
                                  <h5 class="card-title"><a href="{{ route('admin.pages.show',$page->id) }}">{{ $page->title}}</a></h5>
                              </td>
                              <td>
                                  @if(empty($page->in_menu))
                                      {{ __('not published') }}
                                  @else
                                        {{ __('published') }}
                                  @endif
                              </td>
                              <td align="right">
                                  <a href="{{ route('admin.pages.edit',$page->id) }}" class="btn btn-success">
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
