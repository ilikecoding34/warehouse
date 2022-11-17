@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    Bejelentkezés szükséges
                    <div>
                        <a href="{{route('items.index')}}">Tételek</a>    
                    </div>
                    <div>
                        <a href="{{route('pictures.index')}}">Képek</a>
                    </div>
                    <div>
                        <a href="{{route('types.index')}}">Tétel típusok</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection