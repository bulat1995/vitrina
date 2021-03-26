<!-- Shop Sidebar -->
<div class="shop_sidebar">
    <div class="sidebar_section">
        <div class="sidebar_title">{{__('productParameters')}}</div>
    </div>
    <form action="" method="get" name="filter" id="searchBlock">
        <input type="hidden" name="search"  value="{{ old('search',request()->input('search')) }}">
        <input type="hidden" name="sort"   id="sortValue" value="{{ old('sort',request()->input('sort')) }}">
        <div class="sidebar_section">
            <div class="sidebar_subtitle brands_subtitle">{{__('price')}}:</div>
                <div class="row">
                    <div class="col">{{__('from')}}:<input type="text" name="price-min" value="{{old('price-min',request()->input('price-min'))}}" class="form-control"></div>
                    <div class="col">{{__('to')}}:
                        <input type="text" name="price-max" value="{{old('price-max',request()->input('price-max'))}}" class="form-control"></div>
                </div>
        </div>
        @foreach($parameters as $param)
            @if($param->inputType == 'text') @continue @endif
                <div class="sidebar_section">
                    <div class="sidebar_subtitle brands_subtitle">{{ $param->name }}</div>
                    @switch($param->inputType)
                        @case('option')
                            @foreach(explode('|',$param->regular) as $elem=>$value)
                            <div class="filter-check-box">
                                <input type="radio" name="val-{{ $param->id }}" value="{{ $elem }}" id="{{ $param->id }}{{ $elem }}"   @if(null!==(request()->input('val-'.$param->id)) && ($elem==request()->input('val-'.$param->id)))  checked @endif >
                                <label for="{{ $param->id }}{{ $elem }}">{{ $value }} </label>
                            </div>
                            @endforeach
                        @break
                        @case('groups')
                            @foreach(explode('|',$param->regular) as $elem=>$value)
                            <div class="filter-check-box">
                                <input type="checkbox" name="val-{{ $param->id }}[]" value="{{ $elem }}" id="{{ $param->id }}{{ $elem }}"  @if(is_array(request()->input('val-'.$param->id))) @if(in_array($elem,request()->input('val-'.$param->id))) checked @endif @endif>
                                <label for="{{ $param->id }}{{ $elem }}">{{ $value }} <span></span></label>
                            </div>
                            @endforeach
                        @break
                        @case('digit')
                            @foreach(explode('|',$param->regular) as $elem)
                            <div class="filter-input-box">
                                <div class="row">
                                    <div class="col">От:<input type="text" name="min-{{ $param->id }}" value="{{old('min-'.$param->id,request()->input('min-'.$param->id))}}" class="form-control"></div>
                                    <div class="col">До:
                                        <input type="text" name="max-{{ $param->id }}" value="{{old('max-'.$param->id,request()->input('max-'.$param->id))}}" class="form-control"></div>
                                </div>
                            </div>
                            @endforeach
                        @break
                    @endswitch
                </div>
        @endforeach
        <div class="clearfix"></div>
        <div class="mt-4">
            <div class="row">
                <div class="col">
                    <input type="reset"   class="btn   btn-danger" value="{{__('reset')}}">
                </div>
                <div class="col">
                    <input type="submit" class="btn   btn-success" value="{{__('accept')}}">
                </div>
            </div>


        </div>
        @csrf
    </form>
</div>
