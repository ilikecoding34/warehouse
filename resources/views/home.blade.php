@extends('layouts.app')
<style>
.mainbtn {
  box-shadow: inset 0 0 0 0 #6D6E71;
  color: #6D6E71;
  transition: color .3s ease-in-out, box-shadow .3s ease-in-out;
}

.mainbtn:hover {
  box-shadow: inset 10rem 0 0 0 #98999B;
  color: #FFDD00;
}

a {
  position: relative;
  text-decoration: none;
}

a::before {
    content: '';
    position: absolute;
    width: 100%;
    height: 4px;
    border-radius: 4px;
    background-color: #18272F;
    bottom: 0;
    left: 0;
    transform-origin: right;
    transform: scaleX(0);
    transition: transform .3s ease-in-out;
}

a:hover::before {
  transform-origin: left;
  transform: scaleX(1);
}

.loadingmessage{
    display: block;
    top: 10%;
    text-align: center;
    text-justify: center;
    opacity: 0.8;
    border: solid 2px #0080FF80;
    width: 97%;
    height: 10rem;
    position: absolute;
    z-index: 1000;
    border-radius: 30px;
}

</style>
@section('content')


<div class="container">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card">
                <div class="card-header">{{ __('Főoldal') }}</div>

                <div class="card-body">
                    @guest
                    <h5 class="card-title">Bejelentkezés szükséges</h5>
                    @else
                    <div class="card-body">
                    <a class="card mainbtn btn" href="{{route('items.index')}}" style="width: 10rem; display: inline-block">
                        <div class="card-body">
                            <p class="card-title text-center">Tételek</p>
                        </div>
                    </a>
                    <a class="card mainbtn btn" style="width: 10rem; display: inline-block" href="{{route('pictures.index')}}">
                        <div class="card-body">
                            <p class="card-title text-center">Képek</p>
                        </div>
                    </a>
                    <a class="card mainbtn btn" style="width: 10rem; display: inline-block" href="{{route('types.index')}}">
                        <div class="card-body">
                            <p class="card-title text-center">Típusok</p>
                        </div>
                    </a>
                    <a class="card mainbtn btn" style="width: 10rem; display: inline-block" href="{{route('categories.index')}}">
                        <div class="card-body">
                            <p class="card-title text-center">Kategóriák</p>
                        </div>
                    </a>
                    <a class="card mainbtn btn" style="width: 10rem; display: inline-block" href="{{route('companies.index')}}">
                        <div class="card-body">
                            <p class="card-title text-center">Gyártók</p>
                        </div>
                    </a>
                    <a class="card mainbtn btn" style="width: 10rem; display: inline-block" href="{{route('customfields.index')}}">
                        <div class="card-body">
                            <p class="card-title text-center">Egyedi mezők</p>
                        </div>
                    </a>
                </div>

                </div>
                @livewire('data-tables')
            </div>
            @endguest
        </div>
    </div>
</div>
@endsection
