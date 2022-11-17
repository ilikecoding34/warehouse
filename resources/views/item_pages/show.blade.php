@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex">
                        <div class="flex-grow-1">
                            {{ __('Bejegyzés megtekintése') }}
                        </div>
                        <div>
                            Updated at: {{$item->updated_at}}
                        </div>
                    </div>
                </div>
                    
                <div class="card-body">
                    <a href="{{route('items.edit', $item)}}"><button class="btn btn-warning">Szerkesztés</button></a>
                    <div class="form-group">
                        <label for="uniquename">Egyedi név</label>
                        <input type="text" class="form-control" id="uniquename" disabled name="uniquename" value="{{$item->uniquename}}">
                    </div>
                    <div class="form-group my-2">
                        <div class="row">
                            <div class="col-8">
                                <label for="serialnumber">Szériaszám</label>
                                <input type="text" class="form-control" id="serialnumber" disabled name="serialnumber" value="{{$item->serialnumber}}">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col">
                                            <label for="quantity">Kezdő mennyiség</label>
                                            <input type="text" class="form-control" id="quantity" disabled name="quantity" 
                                            value="@if (count($item->quantity) > 0){{$item->quantity->first()->value}}@endif">
                                        </div>
                                        <div class="col">
                                            <label for="quantity">Jelenlegi mennyiség</label>
                                            <input type="text" class="form-control" id="quantity" disabled name="quantity" 
                                            value="@if (count($item->quantity) > 0){{$item->quantity->last()->value}}@endif">
                                        </div>
                                        <div class="col">
                                            <label for="minimumlevel">Minimum mennyiség:</label>
                                            <input type="text" class="form-control" id="minimumlevel" disabled name="minimumlevel" value="{{$item->minimumlevel}}">
                                        </div>
                                      </div>
                                </div>
                            </div>
                            <div class="col-2 my-2">
                                {!! QrCode::size(150)->generate($item->serialnumber) !!}
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="price">Ár</label>
                        <input type="text" class="form-control" id="price" disabled name="price" value="{{$item->price}}">
                    </div>
                    <br>
                    @foreach ($item->types as $type)
                        <div class="form-group">
                            <label for="price">{{$type->name}}</label>
                            <input type="text" class="form-control" id="price" disabled name="price" value="{{$type->pivot->value}}">
                        </div>
                    @endforeach
                    <br>
                    <div class="col">
                        @if(isset($item->picture_id))
                            <img src="{{asset($item->picture->file_path)}}" width="128" height="128">
                        @endif
                    </div>
                    <br>
                </div>
                <div style="width: 600px; margin: auto;">
                    <canvas id="myChart"></canvas>
                </div>
            </div>
            Változások összesen: {{count($item->quantity)}}
            <br>
            @foreach ($item->quantity as $quantity)
                    {{$quantity->value}} - {{$quantity->created_at}}
                    <br>
            @endforeach
        </div>
    </div>
</div>
<script>
    const ctx = document.getElementById('myChart').getContext('2d');
    const myChart = new Chart(ctx, {
        data: {
            labels: [{!!implode(', ', $dates)!!}],
            datasets: [{
                label: ' units',
                type: 'bar',
                data: [{{implode(', ', $units)}}],
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(153, 102, 255, 0.2)',
                    'rgba(255, 159, 64, 0.2)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)'
                ],
                borderWidth: 1
            },{
                label: ' units',
                type: 'line',
                data: [{{implode(', ', $units)}}],
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(153, 102, 255, 0.2)',
                    'rgba(255, 159, 64, 0.2)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            },
            plugins: {
                autocolors: false,
                annotation: {
                annotations: {
                    line1: {
                    type: 'line',
                    yMin: {{ json_encode($item->minimumlevel) }}, 
                    yMax: {{ json_encode($item->minimumlevel) }}, 
                    borderColor: 'rgb(255, 99, 132)',
                    borderWidth: 2,
                    }
                }
                }
            }
        }
    });
    </script>
@endsection