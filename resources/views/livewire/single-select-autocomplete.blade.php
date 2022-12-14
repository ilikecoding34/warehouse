<div>
    <div class="row">
        <div class="col form-group text-muted">
            <label for="price">Kiválasztott {{$title}}(1)</label>
            <span>{{$singleSelectedvalue}}</span>
            <input class="form-control" type="hidden" readonly value="{{$singleSelectedvalue}}" name="{{$inputname}}">
        </div>
        <div class="col form-group">
            <label for="price">Egyszeres {{$title}} kiválasztás</label>
            <input class="form-control" type="text" wire:model="singleSearchInput" wire:keyup="searchInTable(true)">
        
            @if($listvisible)
                <div class="ml-2 bg-light" style="z-index: 1; position:absolute;">
                    <div class="m-1 card p-1">
                    <span  role="button" wire:click="showhidelist">X</span>
                </div>
                @foreach ($modeldata as $item)
                    <div class="m-1 card p-1">
                        <span role="button" wire:click="singleSelect('{{$item->name}}')">{{$item->name}}</span>
                    </div>
                @endforeach
                </div>
            @endif
        </div>
    </div>
</div>
