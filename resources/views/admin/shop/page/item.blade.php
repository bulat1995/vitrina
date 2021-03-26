<table class="table mt-4 table-striped">
  <tbody>
      @foreach ($section as $page)
          <tr>
              <td>
                  <div class="card-title"><a href="{{ route('admin.pages.show',$page->id) }}">{{ $page->title}}</a></div>
              </td>
              <td>
                  @if(empty($page->datePublished))
                      {{ __('not published') }}
                  @else
                        {{ __('published') }}
                  @endif
              </td>
              <td align="right">
                  <a href="{{ route('admin.pages.edit',$page->id) }}" class="btn btn-success">
                      {{__('edit')}}
                  </a>
              </td>
          </tr>
      @endforeach
  </tbody>
</table>
