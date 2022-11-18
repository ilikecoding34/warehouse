@extends('layouts.app')


@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="row">
                <div class="col-lg-12 margin-tb">
                    <div class="d-flex">
                        <div class="flex-grow-1">
                            <h2>{{ __('Jogosultságok kezelése') }}</h2>
                        </div>
                        @can('role-create')
                            <div>
                                <a class="btn btn-success" href="{{ route('roles.create') }}"> Új jogosultság létrehozása</a>
                            </div>
                        @endcan
                        </div>
                    </div>
                </div>


            @if ($message = Session::get('success'))
                <div class="alert alert-success">
                    <p>{{ $message }}</p>
                </div>
            @endif


            <table class="table table-bordered">
            <tr>
                <th>No</th>
                <th>Megnevezés</th>
                <th width="280px">Művelet</th>
            </tr>
                @foreach ($roles as $key => $role)
                <tr>
                    <td>{{ ++$i }}</td>
                    <td>{{ $role->name }}</td>
                    <td>
                        <div class="btn-group">
                        <a class="btn btn-info" href="{{ route('roles.show',$role) }}">Megtekint</a>
                        @can('role-edit')
                            <a class="btn btn-primary" href="{{ route('roles.edit',$role) }}">Szerkeszt</a>
                        @endcan
                        @can('role-delete')
                            <form action="{{route('roles.destroy',$role->id)}}" method="POST">
                                @method('DELETE')
                                @csrf
                                <button class="btn btn-danger" type="submit">Töröl</button>               
                            </form>
                        @endcan
                        </div>
                    </td>
                </tr>
                @endforeach
            </table>


            {!! $roles->render() !!}


        </div>
    </div>
</div>
@endsection