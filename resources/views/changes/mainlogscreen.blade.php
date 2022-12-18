@extends('layouts.app')

@section('content')



<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card my-2">
                <div class="card-header">{{ __('Vuejs tábla') }}</div>
                <div class="card-body">
                <example-component :items={{$logs}}></example-component>
                </div>
            </div>
            <div class="card">
                <div class="card-header">{{ __('Válatozások') }}</div>
                <div class="card-body">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Tétel serialnumber</th>
                        </tr>
                    </thead>
                    @foreach ($logs as $log)
                        <tr>
                            <td>
                                <a href="{{route('changeslist', $log->item_id)}}">
                                {{$log->item->serialnumber}}
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
