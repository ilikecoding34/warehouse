@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">{{ __('Sok sok bejegyzés listázva') }}</div>

                <div class="card-body">

                    <a href="{{route('items.create')}}"><button class="btn btn-primary">Új létrehozás</button></a>
                    <hr>
                    <div>
                        Items: {{count($items)}},
                        Total quantity: {{$totalquantity}},
                        Total value: {{$totalvalue}}
                    </div>
                    <hr>
                    <table class="table">
                        <thead>
                            <tr>
                              <th scope="col">Megnevezés</th>
                              <th scope="col">Sorozatszám</th>
                              <th scope="col">Darabszám</th>
                              <th scope="col">Minimum</th>
                              <th scope="col">Ár(€)</th>
                              <th scope="col">Kép</th>
                              <th scope="col">Művelet</th>
                            </tr>
                          </thead>
                    @foreach ($items as $item)
                    <tr>
                        <td>
                            <div>{{$item->uniquename}}</div>
                        </td>
                        <td>
                            <div>{{$item->serialnumber}}</div>
                        </td>
                        <td>
                            <div>
                                @if (count($item->quantity) > 0)
                                {{$item->getLatestQuantity->first()->value}}
                                @endif
                            </div>
                        </td>
                        <td>
                            <div>{{$item->minimumlevel}}</div>
                        </td>
                        <td>
                            <div>{{$item->price}}</div>
                        </td>
                        <td>
                            @if(isset($item->picture_id))
                                <img src="{{asset($item->picture->file_path)}}" width="128" height="128">
                            @endif
                        </td>
                        <td>
                            <div>
                                <a href="{{route('items.show', $item)}}"><button class="btn btn-primary">Megtekintés</button></a>
                                <a href="{{route('items.edit', $item)}}"><button class="btn btn-warning">Szerkesztés</button></a>
                                <a class="btn btn-danger waves-effect waves-light remove-record" data-bs-toggle="modal" data-url="{{route('items.destroy', $item)}}" data-id="{{$item->id}}" data-bs-target="#custom-width-modal">Törlés</a>
                            </div>
                        </td>
                    </tr>
                    @endforeach

                </div>
                @if ($trashed->count() > 0)
                <br>
                <table class="table">
                    <thead class="thead-light">
                        <tr>
                        <th>Név</th>
                        <th class="text-center">Művelet</th>
                    </thead>
                    <tbody>
                        @foreach ($trashed as $item)
                            <tr>
                                <td>{{$item->uniquename}}</td>
                                <td class="text-center">
                                    <div class="btn-group">
                                        <a class="btn" href="{{ route('items.restore', $item->id ) }}"><button class="btn btn-primary" type="submit">Visszaállítás</button></a>
                                        <form method="POST" class="btn" action="{{route('items.destroy', $item) }}" >
                                            <input id="id" name="id" hidden value="{{$item->id}}">
                                            @method('DELETE')
                                            @csrf
                                            <button class="btn btn-danger" type="submit">Törlés</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                @endif
            </div>
        </div>
    </div>
</div>

@include('modals.deletemodal', ['routeurl' => 'items', 'name' => 'uniquename'])

@endsection
