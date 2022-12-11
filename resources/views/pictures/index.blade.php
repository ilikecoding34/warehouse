@extends ('layouts.app')

@section ('content')

<div id="wrapper">
	<div id="page" class="container">
        <div class="card">
            <div class="card-header">{{ __('Képek') }}</div>
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
                        <a class="btn btn-danger waves-effect waves-light remove-record" data-bs-toggle="modal" data-url="{{route('pictures.destroy', $item->id)}}" data-id="{{$item->id}}" data-bs-target="#custom-width-modal">Törlés</a>
                    </td>
                </tr>
                @endforeach
                </tbody>
            </table>
            <a class="btn btn-success" href="{{ route('pictures.create') }}"> Új kép feltöltése</a>

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
                                    <form method="POST" class="btn" action="{{route('pictures.destroy', $item->id) }}" >
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

@include('modals.deletemodal', ['routeurl' => 'pictures', 'name' => 'name'])

@endsection
