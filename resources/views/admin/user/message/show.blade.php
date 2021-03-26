@extends('admin.main')

@section('title')
    {{__('messages')}}
@endsection

@section('content')
    <div class="col-md-4">
              <div class="chart-box" style="overflow-y:scroll;height:70vh;">
                <h4>{{ __('users') }}</h4>
                @foreach($users as $partner)
                <div class="message-widget">
                    <a href="{{ route('admin.messages.show',  $partner->id ) }}">
                          <div class="user-img pull-left">
                              <object class="img-circle img-responsive" data="/images/user.svg" type="image/png" >
                                  <img class="img-circle img-responsive" src="{!! asset('storage/'.$partner->avatar) !!}">
                              </object>
                          </div>
                          <div class="mail-contnet">
                                <h5> {{  $partner->name }}</h5>
                                <span class="badge">{{ $partner->unread }} {{__('new messages')}}</span>
                                <span class="time">{{ date('h:i d.m.Y',strtotime($partner->last_message)) }}</span>
                            </div>
                      </a>
                </div>
            @endforeach
              </div>
            </div>
        <div class="col-md-8">
            <h5>{{ $user->firstName }} {{ $user->secondName }}
                <a href="{{ route('admin.profiles.show',$user->id) }}">[{{ $user->name }}]</a></h5>
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
                                        <td width="30px">
                                            @if(Auth::user()->id==$message->sender || !$message->readed)
                                                <form action="{{ route('admin.messages.destroy',$message->id) }}" method="post">
                                                    @method('delete')
                                                    @csrf
                                                    <input type="hidden" name="id" value="{{ $message->id }}">
                                                    <input type="hidden" name="sender" value="{{ Auth::user()->id}}">
                                                    <input type="hidden" name="recepient" value="{{ $message->recepient }}">
                                                    <button type="submit" class="fa fa-trash"></button>
                                                </form>
                                            @endif
                                        </td>
                                    </tr>
                                </table>
                                <p>
                                    @if(!$message->readed && Auth::user()->id==$message->sender)
                                        <a href="{{ route('admin.messages.edit',$message->id) }}"> <span class="fa fa-pencil"></span></a>
                                    @endif
                                    {{ $message->message }}
                                </p>
                            </div>
                        </div>
                     @endforeach
                 @endif
             </div>
            <div class="clearfix"></div>
            @include('admin.user.message.form')
        <div class="clearfix"></div>
      </div>
    </div>
@endsection
