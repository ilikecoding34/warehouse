@extends('layouts.app')


@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
        <div class="row">
            <div class="col-lg-12 margin-tb">
                <div class="pull-left">
                    <h2>Users Management</h2>
                </div>
                <div class="pull-right">
                    <a class="btn btn-success" href="{{ route('users.create') }}"> Create New User</a>
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
          <th>Name</th>
          <th>Email</th>
          <th>Roles</th>
          <th width="280px">Action</th>
        </tr>
        @foreach ($data as $key => $user)
          <tr>
            <td>{{ ++$i }}</td>
            <td>{{ $user->name }}</td>
            <td>{{ $user->email }}</td>
            <td>
              @if(!empty($user->roles))
                  @foreach($user->roles as $v)
                      {{ $v->name }}
                  @endforeach
              @endif
            </td>
            <td>
              <div class="btn-group">
              <a class="btn btn-info" href="{{ route('users.show',$user) }}">Show</a>
              <a class="btn btn-primary" href="{{ route('users.edit',$user) }}">Edit</a>
              @can('user-delete')
                <form action="{{route('users.destroy',$user->id)}}" method="POST">
                    @method('DELETE')
                    @csrf
                    <button class="btn btn-danger" type="submit">Delete</button>               
                </form>
              @endcan
              </div>
            </td>
          </tr>
        @endforeach
        </table>


        {!! $data->render() !!}
        
    </div>
  </div>
</div>
@endsection