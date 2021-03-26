@extends('admin.main')

@section('title')
    {{$page->title}}
@endsection

@section('actions')
    <a href="{{ route('admin.pages.edit',$page->id) }}" class="btn btn-success">
        {{__('edit')}}
    </a>
@endsection
@section('content')
    <div class="row">
        <div class="col-md-9">
            <div class="chart-box">

                <div class="card-body">
                    @if ($errors->any())
                        @foreach ($errors->all() as $error)
                            <div class="alert alert-danger">{{ $error }}</div>
                        @endforeach
                    @endif
                    <div>
                        {!!$page->content!!}
                    </div>
                    <div class="clearfix"></div>
                    <hr>
                        <label for="describe">{{__('Page describe')}}</label>
                    <div>
                        {{$page->describe}}
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
    </form>
    @if($page->exists)
        <div class="col-md-3">
            <div class="chart-box">
                <div class="card-body">
                    <div class="form-group">
                        <label for="name">{{__('created')}}:</label>
                        <input disabled type="text" class="form-control" value="{{ old('created_at',$page->created_at) }}">
                    </div>
                    <div class="form-group">
                        <label for="name">{{__('edited')}}:</label>
                        <input disabled type="text" class="form-control"  value="{{ old('updated_at',$page->updated_at) }}">
                    </div>

                    <div class="form-group">
                            <div class="form-check">
                              <input type="checkbox" disabled class="form-check-input" id="in_menu" name="in_menu" @if(old('in_menu',$page->in_menu)) checked @endif value="1">
                              <label class="form-check-label" for="in_menu" >{{__('Show in menu')}}</label>
                          </div>
                          <div class="form-check">
                              <input type="checkbox" disabled class="form-check-input" id="show_user" name="show_user" @if(old('show_user',$page->show_user)) checked @endif value="1">
                              <label class="form-check-label" for="show_user" >{{__('Show user')}}</label>
                          </div>
                          <div class="form-check">
                              <input type="checkbox" disabled class="form-check-input" id="can_comment" name="can_comment" @if(old('can_comment',$page->can_comment)) checked @endif value="1">
                              <label class="form-check-label" for="can_comment" >{{__('Commentable')}}</label>
                          </div>
                          <div class="form-check">
                              <input type="checkbox" disabled class="form-check-input" id="can_index" name="can_index" @if(old('can_index',$page->can_index)) checked @endif value="1">
                              <label class="form-check-label" for="can_index" >{{__('Bot can index this page')}}</label>
                          </div>
                    </div>
                </div>
            </div>


        </div>
    @endif
</div>

@endsection
