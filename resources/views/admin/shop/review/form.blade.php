@extends('admin.main')

@section('title')

{{__('editingReviewBy')}}: {{$review->product_name}}

@endsection

@section('content')
    @if (session('success'))
<div class="alert alert-success">
    {{ session()->get('success')}}
</div>
@endif
<div class="row">
    <div class="col-md-9">
        <div class="chart-box">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('admin.shop.categories.show') }}">
                            {{__('reviews')}}
                        </a>
                    </li>
                    <li aria-current="page" class="breadcrumb-item active">
                        @yield('title')
                    </li>
                </ol>
            </nav>
            <div class="card">
                <div class="card-body">
                    <form action="{{route('admin.shop.reviews.update',$review->id)}}" enctype="multipart/form-data" method="POST">
                        @method('PATCH')
                        @csrf
                    @if ($errors->any())
                        @foreach ($errors->all() as $error)
                        <div class="alert alert-danger">
                            {{ $error }}
                        </div>
                        @endforeach
                    @endif
                        <input type="hidden" name="estimate" value={{$review->estimate}}>
                        <div class="form-group">
                            <label for="name">
                                {{__('review')}}:
                            </label>
                            <textarea class="form-control" id="name" name="review" rows=7>{{old('review',$review->review)}}</textarea>
                        </div>
                        <div class="form-group mt-2">
                            <input class="btn btn-success pull-right" type="submit" value="{{__('edit')}}">
                            </input>
                        </div>
                    </form>
                    <form action="{{route('admin.shop.reviews.destroy',$review->id)}}" method="POST">
                        @method('DELETE')
                        @csrf
                            <input class="btn btn-danger pull-right " style="margin-right:20px;" type="submit" value="{{__('delete')}}">
                    </form>
                        <div class="clearfix">
                        </div>
                </div>
            </div>
        </div>
    </div>

<div class="col-md-3">
    <div class="chart-box">
        <div class="card">
            <div class="card-body">

                <div class="form-group" align="center">
                    <a href="{{route('admin.profiles.show',$review->user_id)}}">
                        @if(!empty($review->avatar))
                            <img  src="{{ asset(Config::get('my.user.filePathWeb').$review->avatar) }}"  width="200" align="center">
                        @endif
                        <h6>{{__('user')}}:{{$review->username}}</h6>
                    </a>
                </div>

                <div class="form-group" align="center">
                    <a target="_blank" href="{{route('admin.shop.products.show',$review->product_id)}}">
                        <h6>{{__('product')}}:{{$review->product_name}}</h6>
                        @if(!empty($review->photo))
                            <img  src="{{ asset(Config::get('my.product.photo.filePathWeb').$review->photo) }}"  width="200" align="center">
                        @endif
                    </a>
                </div>


                <div class="form-group">
                    <label for="name">
                        {{__('created')}}:
                    </label>
                    <input class="form-control" disabled="" type="text" value="{{ old('created_at',$review->created_at) }}">
                    </input>
                </div>
                <div class="form-group">
                    <label for="name">
                        {{__('edited')}}:
                    </label>
                    <input class="form-control" disabled="" type="text" value="{{ old('updated_at',$review->updated_at) }}">
                    </input>
                </div>


            </div>
        </div>
    </div>
</div>
@endsection
