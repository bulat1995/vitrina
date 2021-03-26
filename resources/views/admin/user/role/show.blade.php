@extends('admin.main')

@section('title')
    {{__('role')}}: {{ $role->name }}
@endsection

@section('actions')
    <a href="{{ route('admin.roles.edit',$role->id) }}">
        <button type="button" class="btn btn-success float-right mr-3">{{ __('editing') }}</button>
    </a>
@endsection

@section('content')
        @if (session('success'))
                <div class="alert alert-success">{{ session()->get('success')}}</div>
        @endif
    <div class="chart-box">
          <table class="table">
          @php $lastName=''; @endphp
          @foreach ($role->permissions as $permission)
              @php
                  if($permission->name !=$lastName && $lastName!=''){
                      echo '</tr>';
                  }
                  if($permission->name !=$lastName ){
                      $lastName=$permission->name;
                      echo '<tr><th>'.$permission->name.'</th>';
                  }
              @endphp
              <td>
                 {{ $permission->action_name }}
              </td>
          @endforeach
          </table>
      </div>

    <div class="chart-box">
          <h5 class="pl-4 mt-5">{{ __('users') }}: [{{ count($role->users) }}]</h5>
          <table class="table mt-4">
            <tbody>
                @foreach ($role->users as $user)
                    <tr>
                        <td>
                            <a href="{{ route('admin.profiles.show',$user->id) }}">{{ $user->name}}</a>
                        </td>
                    </tr>
                @endforeach
          </table>
    </div>
@endsection
