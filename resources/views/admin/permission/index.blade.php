@extends('admin.main')

@section('title')
{{__('permissions')}}
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
                <a href="{{ route('admin.permissions.create') }}">
                    <button type="button" class="btn btn-outline-primary float-right mr-3">{{__('add')}}</button>
                </a>
                </div>
          </div>
            @if(count($items)==0)
                <div class="alert alert-warning mt-4" role="alert">
                    Данный раздел пока не заполнен
                </div>
            @else
                <table class="table">
                @php $lastName=''; @endphp
                @foreach ($items as $permission)
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
                      <a href="{{ route('admin.permissions.edit',$permission->id) }}"> {{ $permission->action_name }}</a>
                    </td>
                @endforeach
                </table>


            @endempty
        </div>
    </div>
@endsection
