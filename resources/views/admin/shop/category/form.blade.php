@extends('admin.main')

@section('title')
    @empty($item->id)
    {{__('adding')}}
    @else
    {{__('editing')}} "{{ $item->name }}"
    @endempty
@endsection

@section('content')




    <div class="row">
        <div class="col-md-9">

                <div class="chart-box">
                    <ol class="breadcrumb">
                    @empty($item->id)
                        <li class="breadcrumb-item active" aria-current="page">{{__('rootCategory')}}</li>
                    @else
                        <li class="breadcrumb-item"><a href="{{ route('admin.shop.categories.show') }}">{{__('rootCategory')}}</a></li>
                        @foreach($breadcrumb as $crumb)
                            @if($loop->last)
                                <li class="breadcrumb-item active">{{ $crumb->name }}</li>
                            @else
                                <li class="breadcrumb-item "><a href="{{ route('admin.shop.categories.show',$crumb->id) }}">{{ $crumb->name }}</a></li>
                            @endif
                        @endforeach
                    @endempty
                </ol>
            @if($item->exists)
                <form method="POST" action="{{route('admin.shop.categories.update',$item->id)}}" enctype="multipart/form-data">
                    @method('PATCH')
                @else
                    <form method="POST" action="{{route('admin.shop.categories.store')}}" enctype="multipart/form-data">
                    @endif
                    @csrf
            <div class="card">
                <div class="card-body">
                    @if(isset($errors))
                    @if ($errors->any())
                        @foreach ($errors->all() as $error)
                            <div class="alert alert-danger">{{ $error }}</div>
                        @endforeach
                    @endif
                    @endif
                    <div class="form-group">
                      <label for="name">{{__('categoryName')}}</label>
                      <input type="text" class="form-control" id="name"  name="name" value="{{old('name',$item->name)}}">
                    </div>
                    <div class="form-group">
                      <label for="parent">{{__('parentCategory')}}</label>
                      <select class="form-control" id="parent" name="parent_id">
                          <option value="0">{{ __('Root Category') }}</option>
                          @foreach ($categories as $category)
                              <option @if($category->id==$item->parent_id || $category->id ==$parent_id) selected @endif value="{{ $category->id }}">@php echo str_repeat('&nbsp;', $category->_lvl*8) @endphp {{ $category->name }}</option>
                          @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                      <label for="logo">{{__('logo')}}</label>
                      <input type="file" class="form-control-file" id="logo"  name="logo" value="{{old('name',$item->name)}}">
                    <span style="color:#555">{{__('fileFormat')}}: <i>gif, jpeg, jpg, bmp</i></span>
                    </div>
                    @if(!empty ($item->logoPath))
                        <div class="form-group">
                          <label for="logo">{{__('current logo')}}</label>
                          <br>
                              <img height="200" align="center" src="{!! asset(Config::get('my.category.filePathWeb').$item->logoPath) !!}">
                        </div>
                    @endif

                    <div class="form-group">
                      <label for="parent">{{__('productParameters')}}</label>
                        @foreach ($params as $param)
                         <div class="form-group form-check">
                              <input type="checkbox" id="parameters[]{{ $param->id }}"  name="parameters[]"  value="{{ $param->id }}" @if($param->has==1) checked="true" @endif >
                              <label for="parameters[]{{ $param->id }}">{{ $param->name }}</label>
                          </div>
                        @endforeach
                    </div>


                    <div class="form-group form-check pt-3">
                          <input type="hidden" class="form-check-input" name="is_public" value=0>
                          <input type="checkbox" class="form-check-input" id="is_public" name="is_public" @if(old('is_public',$item['is_public'])) checked @endif value="1">
                          <label class="form-check-label" for="is_public" >{{__('publish')}}</label>
                    </div>
                    <div class="form-group mt-2">
                        @if($item->exists)
                                <input class="btn btn-success pull-right" value="{{__('edit')}}" type="submit">
                            @else
                                <input class="btn btn-primary pull-right" value="{{ __('create') }}" type="submit">
                            @endif
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
        </form>
        </div>
        </div>
    @if($item->exists)
        <div class="col-md-3">

                <div class="chart-box">
            <div class="card">
                <div class="card-body">
                    <div class="form-group">
                        <label for="name">{{__('created')}}:</label>
                        <input disabled type="text" class="form-control" value="{{ old('created_at',$item->created_at) }}">
                    </div>
                    <div class="form-group">
                        <label for="name">{{__('edited')}}:</label>
                        <input disabled type="text" class="form-control"  value="{{ old('updated_at',$item->updated_at) }}">
                    </div>
                </div>
            </div>
            @if(!empty($item->deleted_at))
            <div class="card mt-1">
                <div class="card-body">
                    <div class="form-group">
                        <label for="name">{{__('deleted')}}:</label>
                        <input disabled type="text" class="form-control"  value="{{ old('deleted_at',$item->deleted_at) }}">
                    </div>
                    <form action={{ route('admin.shop.categories.restore',$item->id) }} method="POST">
                        @method('PATCH')
                        @csrf
                        <div class="form-group  form-check ">
                            <input type="hidden" name="withDescedents" value=0>
                            <input type="checkbox" class="form-check-input"  value=1 name="withDescedents" id="restoreWithDescedents">
                            <label for="restoreWithDescedents"> {{__('restore')}} {{__('withDescedents')}}</label>
                        </div>
                        <div class="form-group">
                            <input type="submit" class=" form-control btn btn-dark"  name="restore" value="{{__('restore')}}">
                        </div>
                    </form>
                </div>
            </div>
            @endif
        @if(empty($item->deleted_at))
        <form action="{{ route('admin.shop.categories.destroy',$item->id) }}" method="POST">
            @method('DELETE')
            @csrf
            <div class="card mt-1">
                <div class="card-body">
                        <div class="form-group">
                            <font size=3>{{__('Deleting')}}:</font>
                        </div>
                        <div class="form-group  form-check ">
                            <input type="hidden" name="soft" value=0>
                            <input type="checkbox" class="form-check-input"  name="soft" value=1 id="softDelete">
                            <label for="softDelete">{{__('softDelete')}}</label>
                        </div>
                        <div class="form-group  form-check ">
                            <input type="hidden" name="withDescedents" value=0>
                            <input type="checkbox" class="form-check-input"  value=1 name="withDescedents" id="deleteWithDescedents">
                            <label for="deleteWithDescedents"> {{__('withDescedents')}}</label>
                        </div>
                        <div class="form-group">
                            <input type="submit" class="btn btn-danger  " name="delete" value="{{__('delete')}}">
                        </div>
                </div>
            </div>
        </form>
        @endif
        </div>
    @endif
</div>
</div>
@endsection
