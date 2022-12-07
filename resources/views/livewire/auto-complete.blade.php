<div>
    <div class="form-group">
        <label for="price">Típus</label>
        <input class="form-control" type="text" wire:model="typename" name="type">
    </div>
    @if($listvisible)
    <div class="ml-2 bg-light" style="z-index: 1; position:absolute;">
    @foreach ($types as $type)
        <div class="m-1 card p-1">
            <span role="button" wire:click="typeSelected('{{$type->name}}')">{{$type->name}}</span>
        </div>
    @endforeach
    </div>
    @endif
</div>
