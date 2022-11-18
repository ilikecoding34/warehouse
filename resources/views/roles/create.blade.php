@extends('layouts.app')


@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="row">
                <div class="col-lg-12 margin-tb">
                    <div class="pull-left">
                        <h2>Jogosultság létrehozás</h2>
                    </div>
                    <div class="pull-right">
                        <a class="btn btn-primary" href="{{ route('roles.index') }}"> Vissza</a>
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


            <form method="POST" action="{{ route('roles.store') }}">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Megnevezés:</strong>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Name" value="">
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Engedélyek:</strong>
                        <br/>
                        @foreach($permission as $value)
                            <input class="form-check-input" type="checkbox" value="{{$value->id}}" id="{{$value->name}}" name="permission[]">
                            <label class="form-check-label" for="{{$value->name}}">
                                {{$value->name}}
                            </label>
                        <br/>
                        @endforeach
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                    <button type="submit" class="btn btn-primary">Küldés</button>
                </div>
            </div>
        </form>
        </div>
    </div>
</div>

@endsection