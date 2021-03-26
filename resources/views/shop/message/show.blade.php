@inject('pageData','App\Services\MainPageDataService')


@extends('shop/main')
@section('headScript')
    <link rel="stylesheet" type="text/css" href="/onetech/styles/product_styles.css">
    <link rel="stylesheet" type="text/css" href="/onetech/styles/product_responsive.css">

    <meta name="robots" content="noindex">

@endsection


@section('title')
    {{__('messages')}}
@endsection

@section('content')


            <div class="single_post mt-4">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-10 offset-lg-2">

                                <div class="single_post_title">@yield('title') [@ {{ $user->name }}]</div>

                        <h5>{{ $user->firstName }} {{ $user->secondName }}
                            </h5>
                        <div class="chart-box" style="overflow-y:scroll;height:50vh;">
                              @if(count($messages)<1)
                                  <div class="alert alert-warning">{{__('history of messages is empty')}}</div>
                              @else
                                @foreach($messages as $message)
                                    <div class=" sl-item @if($message->sender == Auth::user()->id) sl-success @else sl-primary @endif">
                                        <div class="sl-content @if(!$message->readed) alert alert-info @endif">

                                            <table width="100%">
                                                <tr>
                                                    <td align="left" width="33%">
                                                        <small class="text-muted">
                                                            <i class="fa fa-user position-left"></i>
                                                            @if($message->sender == Auth::user()->id) {{ Auth::user()->name }} @else {{$user->name}} @endif
                                                            </small>
                                                    </td>
                                                    <td align="left">
                                                        <small class="text-muted pb-3">
                                                            <i class="fa fa-calendar position-left"></i> {{ date("h:i d-m-Y",strtotime($message->created_at)) }}
                                                        </small>
                                                    </td>
                                                    <td align="right"  width="20%">
                                                        @if(Auth::user()->id==$message->sender || !$message->readed)
                                                            <form action="{{ route('shop.messages.destroy',$message->id) }}" method="post">
                                                                @method('delete')
                                                                @csrf
                                                                <input type="hidden" name="id" value="{{ $message->id }}">
                                                                <input type="hidden" name="sender" value="{{ Auth::user()->id}}">
                                                                <input type="hidden" name="recepient" value="{{ $message->recepient }}">
                                                                <button type="submit" class="btn btn-sm btn-danger">{{ __('delete') }}</button>
                                                            </form>
                                                        @endif
                                                    </td>
                                                </tr>
                                            </table>
                                            <p>
                                                {{ $message->message }}
                                                @if(!$message->readed && Auth::user()->id==$message->sender)
                                                    <a href="{{ route('shop.messages.edit',$message->id) }}">[{{ __('edit') }}]</button></a>
                                                @endif
                                            </p>
                                            <div class="clearfix"></div>
                                        </div>
                                    </div>
                                 @endforeach
                             @endif
                         </div>
                        <div class="clearfix"></div>
                        @include('shop.message.form')
                    <div class="clearfix"></div>
                  </div>
                </div>
                </div>
            </div>
        </div>

@endsection
