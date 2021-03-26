<table class="table mt-4 table-striped">
      <tbody>
          @foreach($section as $item)
          <tr>
              <th scope="row" width="60">

              <object data="/images/no_image_available.png" type="image/png" height="40" >
                  @if(!empty ($item->logoPath))
                      <img height="40" align="center" src="{!! asset(Config::get('my.category.filePathWeb').$item->logoPath) !!}">
                  @endif
              </object>
              </th>
              <td>
                  <h5 class="card-title"><a href="{{ route('admin.shop.categories.show',$item->id) }}">{{ $item->name}}</a></h5>
              </td>
              <td align="right">
                  <a href="{{ route('admin.shop.categories.edit',$item->id) }}" class="btn btn-success">
                      {{__('edit')}}
                  </a>
              </td>
          </tr>
      @endforeach
  </tbody>
</table>
