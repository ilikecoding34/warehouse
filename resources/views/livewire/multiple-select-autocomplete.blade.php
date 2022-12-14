<div>
    <div class="row">
        <div class="col form-group text-muted">
            <label for="price">Kiválasztott {{$title}}(több)</label>
            @if (isset($multipleSelected))
                @foreach ($multipleSelected as $item)
                    <span>{{$item}}<span role='button' class="bg-warning ml-1 mr-2" wire:click="removeFromList('{{$loop->index}}')">x</span></span>
                @endforeach
            @endif
            <input class="form-control" type="hidden" readonly wire:model="multipleSelectedids" name="{{$inputname}}">
        </div>
        <div class="col form-group">
            <label for="price">{{$title}} megadás</label>
            <input class="form-control" type="text" wire:model="multipleSearchInput" wire:keyup="searchInTable(false)"><span role="button" wire:click="clearAllSelected()">Clear all</span>
            @if($multiplelistvisible)
            <div class="ml-2 bg-light" style="z-index: 1; position:absolute;">
                <div class="ml-2 bg-light" style="z-index: 1; position:absolute;">
                    <div class="m-1 card p-1">
                    <span  role="button" wire:click="showhidelist">X</span>
                </div>
            @foreach ($modeldata as $item)
                <div class="m-1 card p-1">
                    <span role="button" wire:click="multipleSelect('{{$item->id}}', '{{$item->name}}')">{{$item->name}}</span>
                </div>
            @endforeach
            </div>
            @endif
        </div>
    </div>
</div>
