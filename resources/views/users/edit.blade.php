@extends('layouts.app')


@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2>Edit New User</h2>
        </div>
        <div class="pull-right">
            <a class="btn btn-primary" href="{{ route('users.index') }}"> Back</a>
        </div>
    </div>
</div>


@if (count($errors) > 0)
  <div class="alert alert-danger">
    <strong>Whoops!</strong> There were some problems with your input.<br><br>
    <ul>
       @foreach ($errors->all() as $error)
         <li>{{ $error }}</li>
       @endforeach
    </ul>
  </div>
@endif

<form method="POST" action="{{ route('users.update', $user) }}">
    @csrf
    @method('PUT')
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Name:</strong>
                <input type="text" class="form-control" id="name" name="name" placeholder="Name" value="{{$user->name}}">
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Email:</strong>
                <input type="text" class="form-control" id="email" name="email" placeholder="Email" value="{{$user->email}}">
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Password:</strong>
                <input type="password" class="form-control" id="password" name="password" placeholder="Jelszó" value="{{$user->password}}">
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Confirm Password:</strong>
                <input type="password" class="form-control" id="confirm-password" name="confirm-password" placeholder="Jelsó újra">
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Role:</strong>
                <select class="form-control" style="border: 1px solid" id="roles" name="roles[]" multiple>
                    <option value=""></option>
                    @foreach ($roles as $item)
                        <option 
                        @if (count($userRole)>0)
                            @if (in_array($item->id, $userRole))
                                selected
                            @endif
                        @endif
                        value="{{$item->id}}">
                            {{$item->name}}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
    <div class="col-xs-12 col-sm-12 col-md-12 text-center">
        <button type="submit" class="btn btn-primary">Submit</button>
    </div>
</div>
</form>


</div>
</div>
</div>
@endsection