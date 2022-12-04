@extends ('layouts.app')

@section ('content')

<div id="wrapper">
	<div id="page" class="container">
        <div class="card">
            <div class="card-header">
                <div class="d-flex">
                    <div class="flex-grow-1">
                        {{ __('Tipusok') }}
                    </div>
                    <div>
                        <a href="{{ route('pictures.index') }}"><button class="btn btn-primary" type="submit">Vissza</button></a>
                    </div>
                </div>
            </div>
                <div class="card-body">
		<div id="content">
        <form method="POST" action="{{ route('types.store') }}">
            @csrf
            <div class="field">
                Név
                <div class="control">
                    <input class="input @error ('name') in-danger @enderror form-control"
                    type="text"
                    name="name"
                    id="name"
                    value="{{ old('name') }}">

                    @error('name')
                        <p class="help is-danger">{{ $errors->first('name')}}</p>
                    @enderror
                </div>
            </div>
            <br>

            <div class="field">
                <div class="control">
                    <button type="submit" class="btn btn-primary">Mentés</button>
                </div>
            </div>
        </form>
    </div>
</div>
</div>
</div>
</div>
</div>

@endsection
