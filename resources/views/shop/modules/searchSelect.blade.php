<div class="col">
    <span>{{__('sortBy')}}:</span>
</div>
<script>
    function searchFormSend(val)
    {
        document.getElementById('sortValue').value=val;
        console.log(val);
        document.getElementById('searchBlock').submit();
        return false;
    }
</script>
<div class="col">
    <select class="form-control" onchange="searchFormSend(this.value)">
        <option value="0" @if(request()->input('sort')===0) selected @endif>{{__('priceMin')}}</option>
        <option value="1" @if(request()->input('sort')==1) selected @endif>{{__('priceMax')}}</option>
        <option value="2"@if(request()->input('sort')==2) selected @endif>{{__('nameMin')}}</option>
        <option value="3"@if(request()->input('sort')==3) selected @endif>{{__('nameMax')}}</option>
    </select>
</div>
