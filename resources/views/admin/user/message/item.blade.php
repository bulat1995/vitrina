
    @foreach($section as $item)
        <div class="chart-box">
        <div class="sl-item sl-primary">
              <div class="sl-content">
                  <a href="{{route('admin.profiles.show',$item['sender_id'])}}">
                      <small class="text-muted"><i class="fa fa-user position-left"></i> {{ __('sender') }}: {{ $item['sender']}}</small>
                  </a>

              <a href="{{route('admin.profiles.show',$item['recepient_id'])}}">
                  <small class="text-muted pull-right"><i class="fa fa-user position-left"></i> {{ __('recepient') }}: {{ $item['recepient']}}</small>
              </a>
              @if(Auth::user()->id==$item['sender_id'])
                  <a href="{{ route('admin.messages.show',$item['recepient_id']) }}">
              @else
                  <a href="{{ route('admin.messages.show',$item['sender_id']) }}">
              @endif
                    <p>{{ $item->message }}</p>
                </a>
            <small class="text-muted"><i class="fa fa-calendar position-left"></i>{{ $item['created_at']}}</small>
          </div>
        </div>
        </div>


    @endforeach
