@extends ('layouts.app')

@section ('content')

<div id="wrapper">
	<div id="page" class="container">
        <div class="card">
            <div class="card-header">{{ __('Piktogrammok') }}</div>
                <div class="card-body">
		<div id="content">
            <table class="table">
                <thead class="thead-light">
                  <tr>
                    <th>Név</th>
                    <th>Name</th>
                    <th>Kép</th>
                    <th class="text-center">Művelet</th>
                </thead>
                <tbody>
                @foreach ($pictures as $item)
                <tr>
                    <td>{{$item->name}}</td>
                    <td>{{$item->name_en}}</td>
                    <td><img src="{{url($item->file_path)}}" width="128" height="128"></td>
                    <td class="text-center">
                        <a href="{{ route('pictures.show', $item) }}"><button class="btn btn-primary" type="submit">Megtekint</button></a>
                        <a href="{{ route('pictures.edit', $item) }}"><button class="btn btn-warning" type="submit">Szerkesztés</button></a>
                        <button class="btn btn-danger" id="softDelete" data-toggle="modal" data-target='#delete_modal_{{$item->id}}' data-id="{{ $item->id }}">Törlés</button>
                    </td>
                </tr>
                @endforeach
                </tbody>
            </table>
            <a class="btn btn-success" href="{{ route('pictures.create') }}"> Új piktogramm létrehozása</a>

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
                            <td>{{$item->name}}</td>
                            <td class="text-center">
                                <div class="btn-group">
                                    <a class="btn" href="{{ route('pictures.restore', $item->id ) }}"><button class="btn btn-primary" type="submit">Visszaállítás</button></a>
                                    <form method="POST" class="btn" action="{{route('pictures.destroy', $item) }}" >
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
</div>
</div>
@if (isset($pictures))
    @foreach ($pictures as $item)
        <div class="modal" id="delete_modal_{{$item->id}}">
            <div class="modal-dialog">
                <form id="companydata" method="POST" action="{{route('pictures.destroy', $item) }}" >
                    @method('DELETE')
                    @csrf
                    <div class="modal-content">
                        <h5 class="text-center">Biztos törölni szeretné <span id="symbolname"></span> <span id="name"></span> elemet?</h5>
                        <div class="modal-footer justify-content-between">
                            <button id="btnClose" type="button" class="btn btn-secondary" data-dismiss="modal">Mégse</button>
                            <button type="submit" class="btn btn-danger">Igen, Törlés</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    @endforeach
@endif

<script>

    $(document).ready(function () {
    
    $('body').on('click', '#softDelete', function (event) {
        
        event.preventDefault();
        var id = $(this).data('id');
        function isVowel(word) {
            let letter = word.charAt(0);
            let vowels = ["a", "á", "e", "é", "i", "í", "o", "ó", "ö", "ő", "u", "ú", "ü", "ű", "y", "A", "Á", "E", "É", "I", "Í", "O", "Ó", "Ö", "Ő", "U", "Ú", "Ü", "Ű", "Y"];
            return vowels.includes(letter);
        }
        
        $.get('pictures/' + id + '/modal', function (data) {
             let mod = isVowel(data.data.name) ? 'az' : 'a';
             $('#symbolname').html(mod);
             $('#name').html(data.data.name);
         });

    });
    
    }); 
</script>


@endsection
