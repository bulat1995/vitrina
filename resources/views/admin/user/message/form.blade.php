@if($editMessage->exists)
    <form action="{{ route('admin.messages.update',$editMessage->id) }}" method="POST">
    @method("PATCH")
@else
    <form action="{{ route('admin.messages.store') }}" method="POST">
@endif
        @csrf
        <input type="hidden" name="user" value="{{ $user->id }}">
        <div class="form-group">
            <textarea class="form-control" name="message"  placeholder="{{ __('message') }}">{{ old('message',$editMessage->message) }}</textarea>
        </div>
    @if($editMessage->exists)
        <button class="btn btn-success pull-right" type="submit">{{__('edit')}}</button>
    @else
        <button class="btn btn-success pull-right" type="submit">{{ __('send') }}</button>
    @endif
    </form>
