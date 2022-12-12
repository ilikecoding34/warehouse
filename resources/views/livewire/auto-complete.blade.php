<div>
    <div class="form-group text-muted">
        <label for="price">Kiválasztott kategória(1)</label>
        <input class="form-control" type="text" readonly wire:model="categorysingleselected" name="categorysingleselected">
    </div>
    <div class="form-group">
        <label for="price">Egyszeres kategória kiválasztás</label>
        <input class="form-control" type="text" wire:model="categoryname" name="category" wire:keyup="searchInTable(true)">
    </div>
    @if($listvisible)
    <div class="ml-2 bg-light" style="z-index: 1; position:absolute;">
        <div class="m-1 card p-1">
        <span  role="button" wire:click="showhidelist">X</span>
    </div>
    @foreach ($categories as $category)
        <div class="m-1 card p-1">
            <span role="button" wire:click="categoryselected('{{$category->name}}')">{{$category->name}}</span>
        </div>
    @endforeach
    </div>
    @endif
    <div class="form-group text-muted">
        <label for="price">Kiválasztott kategóriák(több)</label>
        <input class="form-control" type="text" readonly wire:model="categorymultiplename" name="categorymultiplename">
    </div>
    <div class="form-group">
        <label for="price">Kategória megadás</label>
        <input class="form-control" type="text" wire:model="categorysearchname" id="categorysearchname" wire:keyup="searchInTable(false)">
    </div>
    @if($multiplelistvisible)
    <div class="ml-2 bg-light" style="z-index: 1; position:absolute;">
        <div class="ml-2 bg-light" style="z-index: 1; position:absolute;">
            <div class="m-1 card p-1">
            <span  role="button" wire:click="showhidelist">X</span>
        </div>
    @foreach ($categories as $category)
        <div class="m-1 card p-1">
            <span role="button" wire:click="categoryMultiSelect('{{$category->name}}')">{{$category->name}}</span>
        </div>
    @endforeach
    </div>
    @endif
</div>
