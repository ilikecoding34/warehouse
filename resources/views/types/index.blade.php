@extends ('layouts.app')

@section ('content')

<div id="wrapper">
	<div id="page" class="container">
        <div class="card">
            <div class="card-header">{{ __('Tipusok') }}</div>
                <div class="card-body">
		<div id="content">
            <table class="table">
                <thead class="thead-light">
                  <tr>
                    <th>Név</th>
                    <th class="text-center">Művelet</th>
                </thead>
                <tbody>
                @foreach ($types as $item)
                <tr>
                    <td>{{$item->name}}</td>
                    <td class="text-center">
                        <a href="{{ route('types.show', $item) }}"><button class="btn btn-primary" type="submit">Megtekint</button></a>
                        <a href="{{ route('types.edit', $item) }}"><button class="btn btn-warning" type="submit">Szerkesztés</button></a>
                        <button class="btn btn-danger" id="softDelete" data-toggle="modal" data-target='#delete_modal_{{$item->id}}' data-id="{{ $item->id }}">Törlés</button>
                    </td>
                </tr>
                @endforeach
                </tbody>
            </table>
            <a class="btn btn-success" href="{{ route('types.create') }}"> Új tipus létrehozása</a>

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
                                    <a class="btn" href="{{ route('types.restore', $item->id ) }}"><button class="btn btn-primary" type="submit">Visszaállítás</button></a>
                                    <form method="POST" class="btn" action="{{route('types.destroy', $item) }}" >
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
@if (isset($types))
    @foreach ($types as $item)
        <div class="modal" id="delete_modal_{{$item->id}}">
            <div class="modal-dialog">
                <form id="companydata" method="POST" action="{{route('types.destroy', $item) }}" >
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

        $.get('types/' + id + '/modal', function (data) {
             let mod = isVowel(data.data.name) ? 'az' : 'a';
             $('#symbolname').html(mod);
             $('#name').html(data.data.name);
         });

    });

    });
</script>


@endsection
