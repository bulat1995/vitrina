@extends('admin.main')

@section('title')
    {{ __('searchBy') }}:"{{ $searchValue }}"
@endsection
@section('content')
    <div class="chart-box">
          <h4>{{ __('searchBy') }}</h4>
          <!-- Nav tabs -->
          <ul class="nav nav-tabs" role="tablist">
              @foreach($results as $result=>$section)
                  <li role="presentation" @if($loop->first)  class="active" @endif><a href="#{{ $result }}" aria-controls="{{ $result }}" role="tab" data-toggle="tab" aria-expanded="true">{{ __($result) }} {{ count($section) }}</a></li>
              @endforeach
          </ul>

          <!-- Tab panes -->
          <div class="tab-content m-top-2">
              @php
                $layouts=[
                    'users'=>'admin.user.profile.item',
                    'messages'=>'admin.user.message.item',
                    'categories'=>'admin.shop.category.item',
                    'products'=>'admin.shop.product.item',
                    'pages'=>'admin.shop.page.item',
                ];
              @endphp
              @foreach($results as $result=>$section)
              <div role="tabpanel" class="tab-pane @if($loop->first) active @endif" id="{{ $result }}">
                  @if($section->count()>0)
                      @include($layouts[$result],$section)
                  @else
                      <div class="alert alert-warning">{{ __('notFound') }}</div>
                  @endif
              </div>
              @endforeach
          </div>
        </div>
@endsection
