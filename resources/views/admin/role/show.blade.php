@extends('admin.main')

@section('title')
    Роль: {{ $role->name }}
@endsection

@section('content')
        @if (session('success'))
                <div class="alert alert-success">{{ session()->get('success')}}</div>
        @endif
    <div class="card">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active" aria-current="page">@yield('title')</li>
            </ol>
        </nav>
            <div class="row">
                <div class="col-md-10">
                    <font size=4 class="pl-4">
                        @yield('title')
                    </font>
                </div>
                <div class="col-md-2">
                <a href="{{ route('admin.roles.edit',$role->id) }}">
                    <button type="button" class="btn btn-outline-success float-right mr-3">Редактирование</button>
                </a>
                </div>
          </div>

          <p>
  <a class="btn btn-primary" data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
    Ключи доступа: [{{ count($role->permissions) }}]
  </a>
</p>
<div class="collapse" id="collapseExample">
  <div class="card card-body">
      <table class="table mt-4">
        <tbody>
            @foreach ($role->permissions as $permission)
                <tr>
                    <td>
                        <a href="{{ route('admin.permissions.edit',$permission->id) }}">{{ $permission->name}}</a>
                    </td>
                </tr>
            @endforeach
      </table>
   </div>
</div>

          <h5 class="pl-4 mt-5">Пользователи с данной ролью: [{{ count($role->users) }}]</h5>
          <table class="table mt-4">
            <tbody>
                @foreach ($role->users as $user)
                    <tr>
                        <td>
                            <a href="{{$user->id }}">{{ $user->name}}</a>
                        </td>
                    </tr>
                @endforeach
          </table>

        </div>
    </div>
@endsection
