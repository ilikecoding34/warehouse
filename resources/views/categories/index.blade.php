@extends ('layouts.app')

@section ('content')

<div id="wrapper">
	<div id="page" class="container">
        <div class="card">
            <div class="card-header">{{ __('Kategória') }}</div>
                <div class="card-body">
		<div id="content">
            <table class="table">
                <thead class="thead-light">
                  <tr>
                    <th>Név</th>
                    <th class="text-center">Művelet</th>
                </thead>
                <tbody>
                @foreach ($categories as $item)
                <tr>
                    <td>{{$item->name}}</td>
                    <td class="text-center">
                        <a href="{{ route('categories.show', $item) }}"><button class="btn btn-primary" type="submit">Megtekint</button></a>
                        <a href="{{ route('categories.edit', $item) }}"><button class="btn btn-warning" type="submit">Szerkesztés</button></a>
                        <a class="btn btn-danger waves-effect waves-light remove-record" data-bs-toggle="modal" data-url="{{route('categories.destroy', $item)}}" data-id="{{$item->id}}" data-bs-target="#custom-width-modal">Törlés</a>   
                    </td>
                </tr>
                @endforeach
                </tbody>
            </table>
            <a class="btn btn-success" href="{{ route('categories.create') }}"> Új kategória létrehozása</a>

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
                                    <a class="btn" href="{{ route('categories.restore', $item->id ) }}"><button class="btn btn-primary" type="submit">Visszaállítás</button></a>
                                    <form method="POST" class="btn" action="{{route('categories.destroy', $item) }}" >
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

@include('modals.deletemodal', ['routeurl' => 'categories', 'name' => 'name'])


@endsection
