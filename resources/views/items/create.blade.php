@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    Bejegyzés létrehozása
                    <form method="POST" action="{{ route('items.store') }}">
                        @csrf
                        <div class="form-group">
                            <label for="uniquename">Megnevezés</label>
                            <input type="text" class="form-control" id="uniquename" name="uniquename">
                        </div>
                        <div class="form-group">
                            <label for="serialnumber">Sorozatszám</label>
                            <input type="text" class="form-control" id="serialnumber" name="serialnumber">
                        </div>
                        <div class="form-group">
                            <label for="quantity">Mennyiség</label>
                            <input type="text" class="form-control" id="quantity" name="quantity">
                        </div>
                        <div class="form-group">
                            <label for="minimumlevel">Minumum mennyiség:</label>
                            <input type="text" class="form-control" id="minimumlevel" name="minimumlevel">
                        </div>
                        <div class="form-group">
                            <label for="price">Ár</label>
                            <input type="text" class="form-control" id="price" name="price">
                        </div>
                        <div class="form-group">
                            <label for="company">Gyártó</label>
                            <select class="select text-wrap form-control" style="border: 1px solid" id="company_select" name="company_select" class="form-control">
                                <option value=""></option>
                                @foreach ($companies as $company)
                                    <option value="{{$company->id}}">
                                        {{$company->name}}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        @livewire('auto-complete')
                        <div class="form-group">
                            <label for="picture_select">Kép kiválasztás:</label>
                            <select class="form-control" style="border: 1px solid" id="picture_select" name="picture_select">
                                <option value=""></option>
                                @foreach ($pictures as $item)
                                    <option value="{{$item->id}}">
                                        {{$item->name}}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <br><br><br><br><br><br><br><br><br><br><br><br>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Mentés</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
