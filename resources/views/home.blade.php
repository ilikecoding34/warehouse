@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Főoldal') }}</div>

                <div class="card-body">
                    @guest
                    <h5 class="card-title">Bejelentkezés szükséges</h5>
                    @else
                    <div class="card-body">
                        <div class="card" style="width: 15rem; display: inline-block">
                            <div class="card-body">
                                <p class="card-title text-center">Tételek</p>
                                <a class="stretched-link" href="{{route('items.index')}}"></a>
                            </div>    
                        </div>
                        <div class="card" style="width: 15rem; display: inline-block">
                            <div class="card-body">
                                <p class="card-title text-center">Képek</p>
                                <a class="stretched-link" href="{{route('pictures.index')}}"></a>
                            </div>    
                        </div>
                        <div class="card" style="width: 15rem; display: inline-block">
                            <div class="card-body">
                                <p class="card-title text-center">Tétel típusok</p>
                                <a class="stretched-link" href="{{route('types.index')}}"></a>
                            </div>    
                        </div>
                    </div>
                    @endguest
                </div>
                @livewire('data-tables')
            </div>
        </div>
    </div>
</div>
@endsection