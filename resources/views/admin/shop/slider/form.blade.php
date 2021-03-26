@extends('admin.main')

@section('title')
@empty($slider->id)
    {{__('adding')}}
    @else
    {{__('editing')}} "{{ $slider->name }}"
    @endempty
@endsection

@section('actions')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.shop.sliders.index') }}">{{__('shopSliders')}}</a></li>
    </ol>
@endsection

@section('content')
    @if (session('success'))
            <div class="alert alert-success">{{ session()->get('success')}}</div>
    @endif

    @if($slider->exists)
    <form method="POST" action="{{route('admin.shop.sliders.update',$slider->id)}}" enctype="multipart/form-data">
    @method('PATCH')
    @else
    <form method="POST" action="{{route('admin.shop.sliders.store')}}" enctype="multipart/form-data">
    @endif
    @csrf
    <div class="row">
        <div class="col-md-9">
            <div class="chart-box">
                <div class="card-body">
                    @if ($errors->any())
                        @foreach ($errors->all() as $error)
                        <div class="alert alert-danger">{{ $error }}</div>
                        @endforeach
                    @endif

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                              <label for="name">{{__('category')}}:</label>
                              <input type="text" class="form-control" id="category"  placeholder="{{ __('category') }}" name="category" value="{{old('category',$slider->category)}}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="show_until">{{__('showUntil')}}:</label>
                                <input type="date" class="form-control" id="show_until" name="show_until" value="{{old('show_until',((!empty($slider->show_until))?date("Y-m-d",strtotime($slider->show_until)):null))}}">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                      <label for="title">{{__('title')}}:</label>
                      <input type="text" class="form-control" id="title"  placeholder="{{__('title')}}" name="title" value="{{old('title',$slider->title)}}">
                    </div>


                    <div class="form-group">
                      <label for="rating">{{__('rating')}}:</label>
                      <input type="text" class="form-control" id="rating"  placeholder="{{__('rating')}}" name="rating" value="{{old('rating',$slider->rating)}}">
                    </div>




                    <div class="form-group">
                      <label for="describe">{{__('describe')}}:</label>
                      <textarea class="form-control" id="describe"  placeholder="{{__('describe')}}" name="describe">{{old('describe',$slider->describe)}}</textarea>
                    </div>

                    <div class="form-group">
                      <label for="image">{{__('image')}}:</label>
                      <input type="file" class="" id="image"  placeholder="{{__('image')}}" name="image" >
                      @if(!empty($slider->image))
                          <p></p>
                          <p>{{ __('currentLogo') }}:</p>
                          <img src="{!! asset(Config::get('my.slider.filePathWeb').$slider->image) !!}" width="200px">
                      @endif
                    </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                          <label for="buttonText">{{__('buttonText')}}:</label>
                          <input type="text" class="form-control" id="buttonText"  placeholder="{{__('buttonText')}}" name="buttonText" value="{{old('buttonText',$slider->buttonText)}}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="href">{{__('href')}}:</label>
                            <input type="text" class="form-control" id="href"  placeholder="{{__('href')}}" name="href" value="{{old('href',$slider->href)}}">
                        </div>
                    </div>
                </div>


                <div class="form-group form-check">
                     <input type="hidden" id="blank"  name="blank"  value=0 checked="true" >
                     <input type="checkbox" id="blank"  name="blank"  value=1 @if($slider->blank==1) checked="true" @endif >
                     <label for="blank">{{ __('blank') }}</label>
                 </div>



                 <div class="form-group form-check">
                     <input type="hidden" id="blank"  name="show"  value=0 checked="true" >
                      <input type="checkbox" id="show"  name="show"   value=1 @if($slider->show==1) checked="true" @endif >
                      <label for="show">{{ __('show') }}</label>
                  </div>
                    <div class="form-group mt-2">
                        @if($slider->exists)
                            <input class="btn btn-success pull-right" value="{{__('edit')}}" type="submit">
                        @else
                            <input class="btn btn-primary pull-right" value="{{__('add')}}" type="submit">
                        @endif
                    </div>
            </form>
            @if($slider->exists)
                @if(empty($slider->deleted_at))
                <form action="{{ route('admin.shop.sliders.destroy',$slider->id) }}" method="POST">
                    @method('DELETE')
                    @csrf
                    <div class="card mt-1">
                        <div class="form-group">
                            <input type="submit" class="btn btn-danger pull-right"  style="margin-right:20px" name="delete" value="{{__('delete')}}">
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </form>
                @endif
            @endif
    <div class="clearfix"></div>
</div>
</div>
</div>



@endsection
