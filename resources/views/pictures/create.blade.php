@extends ('layouts.app')

@section ('content')

<div id="wrapper">
	<div id="page" class="container">
        <div class="card">
            <div class="card-header">
                <div class="d-flex">
                    <div class="flex-grow-1">
                        {{ __('Piktogrammok') }}
                    </div>
                    <div>
                        <a href="{{ route('pictures.index') }}"><button class="btn btn-primary" type="submit">Vissza</button></a>
                    </div>
                </div>    
            </div>
                <div class="card-body">
		<div id="content">
        <form method="POST" action="{{ route('pictures.store') }}" enctype="multipart/form-data">
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
                Név (angolul)
                <div class="control">
                    <input class="input @error ('name_en') in-danger @enderror form-control"
                    type="text"
                    name="name_en"
                    id="name_en"
                    value="{{ old('name_en') }}">

                    @error('name_en')
                        <p class="help is-danger">{{ $errors->first('name_en')}}</p>
                    @enderror
                </div>
            </div>
            <br>
            @if (count($errors) > 0)
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <div class="custom-file">
                <input type="file" name="file" class="custom-file-input" id="chooseFile">
                <label class="custom-file-label" for="chooseFile">Fájl kiválasztása</label>
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
