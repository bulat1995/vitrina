<table width="100%">
    @foreach($section as $item)
        <tr>
    <th scope="row" width="60">
        <object data="/images/no_image_available.png" type="image/png" height="40" >
            @foreach($item->photos as $photo)
                @if($loop->first)
                    <img  src="{{ asset(Config::get('my.product.photo.filePathWeb').$photo->path) }}" >
                @endif
            @endforeach
        </object>
    </th>
    <td>
        <h5 class="card-title"><a href="{{ route('admin.shop.products.show',$item['id']) }}">{{ $item['name']}}</a></h5>
    </td>
</tr>
@endforeach
</table>
