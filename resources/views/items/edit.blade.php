@extends('layouts.app')

@section('content')
<script src="https://cdnjs.cloudflare.com/ajax/libs/webcamjs/1.0.25/webcam.min.js"></script>
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
                        <label for="uniquename">Megnevezés</label>
                        <input type="text" class="form-control" id="uniquename" name="uniquename" value="{{$item->uniquename}}">
                    </div>
                    <div class="form-group">
                        <label for="serialnumber">Sorozatszám</label>
                        <input type="text" class="form-control" id="serialnumber" name="serialnumber" value="{{$item->serialnumber}}">
                    </div>
                    <div class="form-group">
                        <label for="quantity">Mennyiség</label>
                        <input type="text" class="form-control" id="quantity" name="quantity" value="{{$item->quantity_value}}">
                    </div>
                    <div class="form-group">
                        <label for="minimumlevel">Minumum mennyiség:</label>
                        <input type="text" class="form-control" id="minimumlevel" name="minimumlevel" value="{{$item->minimumlevel}}">
                    </div>
                    <div class="form-group">
                        <label for="price">Ár</label>
                        <input type="text" class="form-control" id="price" name="price" value="{{$item->price}}">
                    </div>
                    <div class="form-group">
                        <label for="description">Leírás</label>
                        <input type="text" class="form-control" id="description" name="description" value="{{$item->description}}">
                    </div>
                    <div class="form-group">
                        <label for="location">Hely</label>
                        <input type="text" class="form-control" id="location" name="location" value="{{$item->location}}">
                    </div>
                    <div class="form-group">
                        <label for="company">Gyártó</label>
                        <input type="text" class="form-control" id="company" name="company" value="{{$item->company}}">
                    </div>
                    <div class="form-group">
                        @livewire('auto-complete')
                    </div>
                    @foreach ($item->customfields as $customfield)
                        <div class="form-group
                        @if (in_array($customfield->id, Session::get('success') ?? []))
                            alert alert-success
                        @endif
                        ">
                            <label for="type_{{$customfield->id}}">{{$customfield->name}}</label>
                            <input type="text" class="form-control" id="customfield{{$customfield->id}}" name="customfieldsdatas[]" value="{{$customfield->pivot->value}}">
                        </div>
                    @endforeach
                    <div class="form-group">
                        <label for="type_select">Típus:</label>
                        <select class="select text-wrap form-control" style="border: 1px solid" id="type_select" name="type_select" class="form-control">
                            <option value=""></option>
                            @foreach ($types as $type)
                                <option value="{{$type->id}}"
                                    @if ($type->id == $item->type_id)
                                        selected
                                    @endif
                                    >
                                    {{$type->name}}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <br>
                        <div class="form-group">
                            <button type="submit" class="btn btn-success">Frissítés</button>
                        </div>
                    </form>
                    <hr>
                    <h3>Egyedi mezők</h3>
                    <form method="POST" action="{{ route('items.addtype', $item->id) }}">
                        @csrf
                        @method('POST')
                        @foreach ($item->customfields as $customfield)
                            <div class="form-group">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="{{$customfield->id}}" id="defaultCheck1" checked name="customfields[]">
                                    <label class="form-check-label" for="defaultCheck1">
                                    {{$customfield->name}}
                                    </label>
                                </div>
                            </div>
                        @endforeach
                        @foreach ($unckeckedtypes as $unckeckedtype)
                            <div class="form-group">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="{{$unckeckedtype->id}}" id="defaultCheck1" name="customfields[]">
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
                        <hr>
                    <div class="form-group">
                        <label for="picture_select">Kép:</label>
                        <div class="row">
                        @foreach ($item->pictures as $pic)
                        <div class="col">
                            <img src="{{asset($pic->file_path)}}" width="128" >
                            <form method="POST" class="btn" action="{{route('pictures.deletefromitem') }}" >
                                @csrf
                                <input id="id" name="item_id" hidden value="{{$item->id}}">
                                <input id="id" name="pic_id" hidden value="{{$pic->id}}">
                                <button class="btn btn-warning" type="submit">Törlés</button>
                            </form>
                        </div>
                        @endforeach
                        </div>
                    </div>
                    <div class="container">
                        <h3>Webkamera kép</h3>
                        <form method="POST" action="{{ route('webcam.capture') }}">
                            @csrf
                                <div class="col-md-10">
                                    <div id="my_camera"></div>
                                    <br/>
                                    <input type=button value="Kép készítés" onClick="take_snapshot()">
                                    <input type="hidden" name="image" class="image-tag">
                                    <input type="hidden" name="item_id" value="{{$item->id}}">
                                </div>
                                <div class="col-md-10">
                                    <div id="results">Webcam képe itt fog megjelenni</div>
                                </div>
                                <button class="btn btn-success">Feltöltés</button>
                        </form>
                    </div>
                    <hr>
                    <h3>Meghajtóról kép</h3>
                    <form method="POST" action="{{ route('pictures.storetoitem', $item->id) }}" enctype="multipart/form-data">
                        @csrf
                        <div class="custom-file">
                            <input type="file" name="files[]" class="custom-file-input" id="chooseFile" multiple>
                            <label class="custom-file-label" for="chooseFile">Fájl kiválasztása</label>
                        </div>
                        <br>
                        <div class="field">
                            <div class="control">
                                <button type="submit" class="btn btn-success">Feltöltés</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script language="JavaScript">
    Webcam.set({
        width: 490,
        height: 350,
        image_format: 'jpeg',
        jpeg_quality: 90
    });

    Webcam.attach( '#my_camera' );

    function take_snapshot() {
        Webcam.snap( function(data_uri) {
            $(".image-tag").val(data_uri);
            document.getElementById('results').innerHTML = '<img src="'+data_uri+'"/>';
        } );
    }
</script>

@endsection
