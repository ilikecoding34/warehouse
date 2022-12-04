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
                              <th scope="col">Egyedi név</th>
                              <th scope="col">Szériaszám</th>
                              <th scope="col">Mennyiség</th>
                              <th scope="col">Minimum</th>
                              <th scope="col">Ár</th>
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
                                <button type="button" class="btn btn-danger delete" data-bs-toggle="modal" data-bs-target="#delete_modal" data-id="{{ $item->id }}">
                                    Törlés
                                </button>
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

<!-- Modal -->
<div class="modal fade" id="delete_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
            <h1 class="modal-title fs-5" id="exampleModalLabel">Elem törlése</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            <form id="companydata" method="POST" action="" >
            </div>
            <div class="modal-body">

                    @method('DELETE')
                    @csrf
                    <input id="id" name="id" hidden value="">
                    <div class="modal-content">
                        <h5 class="text-center">Biztos törölni szeretné <span id="itemname"></span> <span id="name"></span> elemet?</h5>

                    </div>

            </div>
            <div class="modal-footer justify-content-between">
                <button id="btnClose" type="button" class="btn btn-secondary" data-bs-dismiss="modal">Mégse</button>
                <button type="submit" class="btn btn-danger">Igen, Törlés</button>
            </div>
        </form>
        </div>
    </div>
</div>
<script>
    $(document).on('click','.delete',function(){
            let id = $(this).attr('data-id');
            $('#id').val(id);

            function isVowel(word) {
                let letter = word.charAt(0);
                let vowels = ["a", "á", "e", "é", "i", "í", "o", "ó", "ö", "ő", "u", "ú", "ü", "ű", "y", "A", "Á", "E", "É", "I", "Í", "O", "Ó", "Ö", "Ő", "U", "Ú", "Ü", "Ű", "Y"];
                return vowels.includes(letter);
            }

            $.get('items/' + id + '/modal', function (data) {
                let art = isVowel(data.data.uniquename) ? 'az' : 'a';
                $('#itemname').html(art);
                $('#name').html(data.data.uniquename);
            });
       });
</script>
@endsection
