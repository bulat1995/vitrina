@extends('admin.main')

@section('title')
    @empty($item->id)
    Добавление категории
    @else
    Редактирование категории "{{ $item->name }}"
    @endempty
@endsection

@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
        @empty($item->id)
            <li class="breadcrumb-item active" aria-current="page">Корневая категория</li>
        @else
            <li class="breadcrumb-item"><a href="{{ route('admin.shop.categories.index') }}">Корневая категория</a></li>
            @foreach($breadcrumb as $crumb)
                @if($loop->last)
                    <li class="breadcrumb-item active">{{ $crumb->name }}</li>
                @else
                    <li class="breadcrumb-item "><a href="{{ route('admin.shop.categories.show',$crumb->id) }}">{{ $crumb->name }}</a></li>
                @endif
            @endforeach
        @endempty
        </ol>
    </nav>
    @if($item->exists)
    <form method="POST" action="{{route('admin.shop.categories.update',$item->id)}}" enctype="multipart/form-data">
    @method('PATCH')
    @else
    <form method="POST" action="{{route('admin.shop.categories.store')}}" enctype="multipart/form-data">
    @endif
    @csrf
    <div class="row">
        <div class="col-md-9">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-8">
                            <font size=3>
                                @yield('title')
                            </font>
                        </div>
                    </div>
                  </div>
                <div class="card-body">
                    @if ($errors->any())
                        @foreach ($errors->all() as $error)
                            <div class="alert alert-danger">{{ $error }}</div>
                        @endforeach
                    @endif
                    <div class="form-group">
                      <label for="name">Наименование категории</label>
                      <input type="text" class="form-control" id="name"  placeholder="Компьютеры" name="name" value="{{old('name',$item->name)}}">
                    </div>
                    <div class="form-group">
                      <label for="parent">Родительская категория</label>
                      <select class="form-control" id="parent" name="parent_id">
                          <option value="0">Корневая категория</option>
                          @foreach ($categories as $category)
                              <option @if($category->id==$item->parent_id || $category->id ==$parent_id) selected @endif value="{{ $category->id }}">@php echo str_repeat('&nbsp;', $category->_lvl*8) @endphp {{ $category->name }}</option>
                          @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                      <label for="logo">Логотип</label>
                      <input type="file" class="form-control-file" id="logo"  name="logo" value="{{old('name',$item->name)}}">
                    <span style="color:#555">Формат файла: <i>gif, jpeg, jpg, bmp</i></span>
                    </div>
                    @if(!empty ($item->logoPath))
                        <div class="form-group">
                          <label for="logo">Текущий логотип</label>
                          <br>
                              <img height="200"   align="center" src="{!! asset('storage/'.$item->logoPath) !!}">
                        </div>
                    @endif
                    <div class="form-group form-check pt-3">
                          <input type="hidden" class="form-check-input" name="is_public" value=0>
                          <input type="checkbox" class="form-check-input" id="is_public" name="is_public" @if(old('is_public',$item['is_public'])) checked @endif value="1">
                          <label class="form-check-label" for="is_public" >Опубликовать</label>
                    </div>
                    <div class="form-group mt-2">
                        @if($item->exists)
                                <input class="btn btn-outline-success float-right" value="Редактировать" type="submit">
                            @else
                                <input class="btn btn-outline-primary float-right" value="Создать" type="submit">
                            @endif
                    </div>
                </div>
            </div>
        </div>
    </form>
    @if($item->exists)
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <div class="form-group">
                        <label for="name">Создано:</label>
                        <input disabled type="text" class="form-control" value="{{ old('created_at',$item->created_at) }}">
                    </div>
                    <div class="form-group">
                        <label for="name">Отредактировано:</label>
                        <input disabled type="text" class="form-control"  value="{{ old('updated_at',$item->updated_at) }}">
                    </div>
                </div>
            </div>
            @if(!empty($item->deleted_at))
            <div class="card mt-1">
                <div class="card-body">
                    <div class="form-group">
                        <label for="name">Удалено:</label>
                        <input disabled type="text" class="form-control"  value="{{ old('deleted_at',$item->deleted_at) }}">
                    </div>
                    <form action={{ route('admin.shop.categories.restore',$item->id) }} method="POST">
                        @method('PATCH')
                        @csrf
                        <div class="form-group  form-check ">
                            <input type="hidden" name="withDescedents" value=0>
                            <input type="checkbox" class="form-check-input"  value=1 name="withDescedents" id="restoreWithDescedents">
                            <label for="restoreWithDescedents"> Восстановить с потомками</label>
                        </div>
                        <div class="form-group">
                            <input type="submit" class=" form-control btn btn-outline-dark"  name="restore" value="Восстановить">
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
                            <font size=3>Удаление:</font>
                        </div>
                        <div class="form-group  form-check ">
                            <input type="hidden" name="soft" value=0>
                            <input type="checkbox" class="form-check-input"  name="soft" value=1 id="softDelete">
                            <label for="softDelete">мягкое удаление</label>
                        </div>
                        <div class="form-group  form-check ">
                            <input type="hidden" name="withDescedents" value=0>
                            <input type="checkbox" class="form-check-input"  value=1 name="withDescedents" id="deleteWithDescedents">
                            <label for="deleteWithDescedents"> вместе с потомками</label>
                        </div>
                        <div class="form-group">
                            <input type="submit" class="btn btn-outline-danger float-right" name="delete" value="Удалить">
                        </div>
                </div>
            </div>
        </form>
        @endif
        </div>
    @endif
</div>

@endsection
