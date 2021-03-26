<table width="100%" class="table-striped">
    @foreach($section as $item)
        <tr>
        <th scope="row" width="60">
            @if(empty($item['avatar']))
            <img height="40" align="center" src="/images/user.svg" width="100%">
            @else
            <img height="40" align="center" src="{{ asset(config('my.user.filePathWeb').$item['avatar']) }}" width="100%">
            @endif
        </th>
        <td>
            <h5 class="card-title"><a href="{{ route('admin.profiles.show',$item['id']) }}">
                {{ $item['firstName']}} {{ $item['secondName']}}
                [{{ $item['name']}}]
            </a></h5>
        </td>
    </tr>
    @endforeach
</table>
