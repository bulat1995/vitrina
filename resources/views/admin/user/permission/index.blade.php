@extends('admin.main')

@section('title')
{{__('permissions')}}
@endsection
@section('actions')
    <a href="{{ route('admin.permissions.create') }}">
        <button type="button" class="btn btn-primary pull-right mr-3">{{__('add')}}</button>
    </a>
@endsection
@section('content')
        @if (session('success'))
                <div class="alert alert-success">{{ session()->get('success')}}</div>
        @endif
    <div class="chart-box">
            @if(count($items)==0)
                <div class="alert alert-warning mt-4" role="alert">
                    {{ __('unit is empty') }}
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
                        @if($permission->changeable)
                              <a href="{{ route('admin.permissions.edit',$permission->id) }}">
                                  {{ $permission->action_name }}
                              </a>
                          @else
                              {{ $permission->action_name }}
                          @endif
                    </td>
                @endforeach
                </table>


            @endempty
        </div>
    </div>
@endsection
