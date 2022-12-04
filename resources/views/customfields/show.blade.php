@extends ('layouts.app')

@section ('content')

<div id="wrapper">
	<div id="page" class="container">
        <div class="card">
            <div class="card-header">
                <div class="d-flex">
                    <div class="flex-grow-1">
                        {{ __('Egyedi mező') }}
                    </div>
                    <div>
                        <a href="{{ route('customfields.edit', $type ) }}"><button class="btn btn-primary" type="submit">Szerkesztés</button></a>
                        <a href="{{ route('customfields.index') }}"><button class="btn btn-primary" type="submit">Vissza</button></a>
                    </div>
                </div>
            </div>
            <div class="card-body">
		    <div id="content">

            <br>
			<div class="field">
                {{ $customfield->name }}
            </div>
            <br>


        </div>

    </div>
</div>
</div>
</div>
</div>

@endsection
