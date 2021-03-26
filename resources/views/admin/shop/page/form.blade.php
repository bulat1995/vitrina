@extends('admin.main')

@section('title')
@empty($page->id)
    {{__('adding')}}
    @else
    {{__('editing')}} "{{ $page->title }}"
    @endempty
@endsection

@section('content')
    <div class="row">
        <div class="col-md-9">
            <div class="chart-box">
                    @if($page->exists)
                    <form method="POST" action="{{route('admin.pages.update',$page->id)}}" enctype="multipart/form-data">
                    @method('PATCH')
                    @else
                    <form method="POST" action="{{route('admin.pages.store')}}" enctype="multipart/form-data">
                    @endif
                    @csrf
                    @if ($errors->any())
                        @foreach ($errors->all() as $error)
                            <div class="alert alert-danger">{{ $error }}</div>
                        @endforeach
                    @endif
                    <div class="form-group">
                      <label for="title">{{__('pageTitle')}}</label>
                      <input type="text" class="form-control" id="title"  placeholder="" name="title" value="{{old('title',$page->title)}}">
                    </div>

                    <div class="row">
                        <div class="col-md-10">
                            <div class="form-group">
                              <label for="slug">{{__('pageSlug')}}</label>
                              <input type="text" class="form-control" id="slug"  placeholder="" name="slug" value="{{old('slug',$page->slug)}}">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                              <label for="rating">{{__('pageRating')}}</label>
                              <input type="digit" class="form-control" id="rating"  placeholder="500" name="rating" value="{{old('rating',$page->rating)}}">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                      <label for="content">{{__('pageContent')}}</label>
                      <textarea class="form-control" id="content" name="content">{{old('content',$page->content)}}</textarea>
                    </div>
                    <div class="form-group">
                      <label for="describe">{{__('pageDescribe')}}</label>
                      <textarea class="form-control" id="describe" name="describe">{{old('describe',$page->describe)}}</textarea>
                    </div>
                    <div style="padding-left:20px;">
                        <div class="col">
                          <input type="hidden" class="form-check-input" name="in_menu" value=0>
                          <input type="checkbox" class="form-check-input" id="in_menu" name="in_menu" @if(old('in_menu',$page->in_menu)) checked @endif value="1">
                          <label class="form-check-label" for="in_menu" >{{__('showInMenu')}}</label>
                      </div>
                      <div class="col">
                          <input type="hidden" class="form-check-input" name="show_user" value=0>
                          <input type="checkbox" class="form-check-input" id="show_user" name="show_user" @if(old('show_user',$page->show_user)) checked @endif value="1">
                          <label class="form-check-label" for="show_user" >{{__('showUser')}}</label>
                      </div>
                        <div class="col">
                              <input type="hidden" class="form-check-input" name="can_comment" value=0>
                              <input type="checkbox" class="form-check-input" id="can_comment" name="can_comment" @if(old('can_comment',$page->can_comment)) checked @endif value="1">
                              <label class="form-check-label" for="can_comment" >{{__('commentable')}}</label>
                         </div>
                          <div class="col">
                              <input type="hidden" class="form-check-input" name="can_index" value=0>
                              <input type="checkbox" class="form-check-input" id="can_index" name="can_index" @if(old('can_index',$page->can_index)) checked @endif value="1">
                              <label class="form-check-label" for="can_index" >{{__('BotCanIndex')}}</label>
                          </div>
                      </div>

                        @if($page->exists)
                            <input class="btn btn-success pull-right" value="{{__('edit')}}" type="submit">
                        @else
                            <input class="btn btn-primary pull-right" value="{{__('add')}}" type="submit">
                        @endif
    </form>
    @if(empty($page->deleted_at) && isset($page->id))
    <form action="{{ route('admin.pages.destroy',$page->id) }}" method="POST">
        @method('DELETE')
        @csrf
        <input type="submit" class="btn btn-danger pull-right" style="margin-right:15px;" name="delete" value="{{__('delete')}}">
    </form>
    @endif
    <div class="clearfix"></div>
</div>
</div>

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
                </div>
            </div>
            @if(!empty($page->deleted_at))
            <div class="card mt-1">
                <div class="card-body">
                    <div class="form-group">
                        <label for="name">{{__('deletedAt')}}:</label>
                        <input disabled type="text" class="form-control"  value="{{ old('deleted_at',$page->deleted_at) }}">
                    </div>
                    <form action={{ route('admin.pages.restore',$page->id) }} method="POST">
                        @method('PATCH')
                        @csrf
                        <div class="form-group  form-check ">
                            <input type="hidden" name="withDescedents" value=0>
                            <input type="checkbox" class="form-check-input"  value=1 name="withDescedents" id="restoreWithDescedents">
                            <label for="restoreWithDescedents"> {{__('restoreWithDescedents')}}</label>
                        </div>
                        <div class="form-group">
                            <input type="submit" class=" form-control btn btn-dark"  name="restore" value="{{__('restore')}}">
                        </div>
                    </form>
                </div>
            </div>
            @endif
        </div>
    @endif
</div>

@endsection

@section('bottomInsert')
    <script src="{{ URL::asset('js/ckeditor.js') }}"></script>
    <script>
    setTimeout(function(){
            CKEDITOR.config.removeButtons = 'Source,Save,NewPage,Preview,Form,Checkbox,Radio,TextField,Textarea,Select,Button,ImageButton,HiddenField,JustifyCenter';
            CKEDITOR.replace( 'content' );
    },100);
    </script>
@endsection
