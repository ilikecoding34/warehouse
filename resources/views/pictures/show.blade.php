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
                        <a href="{{ route('pictures.edit', $picture ) }}"><button class="btn btn-primary" type="submit">Szerkesztés</button></a>
                        <a href="{{ route('pictures.index') }}"><button class="btn btn-primary" type="submit">Vissza</button></a>
                    </div>
                </div>
            </div>
            <div class="card-body">
		    <div id="content">
            
            <br>
			<div class="field">
                {{ $picture->name }}
            </div>
            <br>
            @if (isset($picture->name_en))
                <div class="field">
                    {{ $picture->name_en }}
                </div>
                <br>
            @endif
            <div class="field">
                <img src="{{url($picture->file_path)}}">
            </div>
            
        </div>

    </div>
</div>
</div>
</div>
</div>

@endsection
