@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Bejegyzés módosítása') }}</div>

                <div class="card-body">
                    
                    <form method="POST" action="{{ route('items.update', $item) }}">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="uniquename">Egyedi név</label>
                        <input type="text" class="form-control" id="uniquename" name="uniquename" value="{{$item->uniquename}}">
                    </div>
                    <div class="form-group">
                        <label for="serialnumber">Szériaszám</label>
                        <input type="text" class="form-control" id="serialnumber" name="serialnumber" value="{{$item->serialnumber}}">
                    </div>
                    <div class="form-group">
                        <label for="quantity">Mennyiség</label>
                        <input type="text" class="form-control" id="quantity" name="quantity" value="@if (count($item->quantity) > 0){{$item->getLatestQuantity->first()->value}}@endif">
                    </div>
                    <div class="form-group">
                        <label for="minimumlevel">Minumum mennyiség:</label>
                        <input type="text" class="form-control" id="minimumlevel" name="minimumlevel" value="{{$item->minimumlevel}}">
                    </div>
                    <div class="form-group">
                        <label for="price">Ár</label>
                        <input type="text" class="form-control" id="price" name="price" value="{{$item->price}}">
                    </div>
                    @foreach ($item->types as $type)
                        <div class="form-group
                        @if (in_array($type->id, Session::get('success') ?? []))
                            alert alert-success
                        @endif
                        ">
                            <label for="type_{{$type->id}}">{{$type->name}}</label>
                            <input type="text" class="form-control" id="type_{{$type->id}}" name="typedatas[]" value="{{$type->pivot->value}}">
                        </div>
                    @endforeach
                    <div class="form-group">
                        <label for="picture_select">Kép:</label>
                        <select class="select text-wrap form-control" style="border: 1px solid" id="picture_select" name="picture_select" class="form-control">
                            <option value=""></option>
                            @foreach ($pictures as $pic)
                                <option value="{{$pic->id}}"
                                    @if ($pic->id == $item->picture_id)
                                        selected
                                    @endif
                                    >
                                    {{$pic->name}}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <br>
                        <div class="form-group">
                            <button type="submit" class="btn btn-success">Frissítés</button>
                        </div>
                    </form>
                
                <form method="POST" action="{{ route('items.addtype', $item->id) }}">
                    @csrf
                    @method('POST')
                    @foreach ($item->types as $type)
                        <div class="form-group">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="{{$type->id}}" id="defaultCheck1" checked name="types[]">
                                <label class="form-check-label" for="defaultCheck1">
                                {{$type->name}}
                                </label>
                            </div>
                        </div>
                    @endforeach
                    @foreach ($unckeckedtypes as $unckeckedtype)
                        <div class="form-group">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="{{$unckeckedtype->id}}" id="defaultCheck1" name="types[]">
                                <label class="form-check-label" for="defaultCheck1">
                                {{$unckeckedtype->name}}
                                </label>
                            </div>
                        </div>
                    @endforeach
                    <br>
                        <div class="form-group">
                            <button type="submit" class="btn btn-success">Hozzáad</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection