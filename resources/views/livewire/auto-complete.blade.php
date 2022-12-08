<div>
    <div class="form-group">
        <label for="price">Egyszeres kiválasztás</label>
        <input class="form-control" type="text" wire:model="typename" name="type" wire:change="searchSingle">
    </div>
    @if($listvisible)
    <div class="ml-2 bg-light" style="z-index: 1; position:absolute;">
        <div class="m-1 card p-1">
        <span  role="button" wire:click="showhidelist">X</span>
    </div>
    @foreach ($types as $type)
        <div class="m-1 card p-1">
            <span role="button" wire:click="typeSingleSelect('{{$type->name}}')">{{$type->name}}</span>
        </div>
    @endforeach
    </div>
    @endif
    <div class="form-group">
        <label for="price">Kiválasztott típusok</label>
        <input class="form-control" type="text" readonly wire:model="typemultiplename" name="typemultiplename">
    </div>
    <div class="form-group">
        <label for="price">Típus megadás</label>
        <input class="form-control" type="text" wire:model="typesearchname" id="typesearchname">
    </div>
    @if($multiplelistvisible)
    <div class="ml-2 bg-light" style="z-index: 1; position:absolute;">
        <div class="ml-2 bg-light" style="z-index: 1; position:absolute;">
            <div class="m-1 card p-1">
            <span  role="button" wire:click="showhidelist">X</span>
        </div>
    @foreach ($types as $type)
        <div class="m-1 card p-1">
            <span role="button" wire:click="typeMultiSelect('{{$type->name}}')">{{$type->name}}</span>
        </div>
    @endforeach
    </div>
    @endif
</div>
