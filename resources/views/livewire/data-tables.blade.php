<div>
  <div class="card m-2">
      <div class="card-body">
        {!! $items->links() !!}
        <table class="table">
          Result: {{$resultcount}}, Total quantity: {{$totalquantity}}, Total value: {{$totalvalue}} €
          <thead>
            <tr>
              <th scope="col">
                <span role="button" wire:click="sortBy('id')">#</span>
              </th>
              <th scope="col">
                <span role="button" wire:click="sortBy('serialnumber')">Sorozatszám</span>
              </th>
              <th scope="col" role="button">
                <span wire:click="sortBy('uniquename')">Megnevezés</span>
              </th>
              <th scope="col" role="button">
                <span wire:click="orderBy('quantity_value')">Darabszám</span>
                <select name="relation" id="relation" wire:model="relation" wire:change="searchInTable">
                    <option value="0">*</option>
                    <option value="1">></option>
                    <option value="2"><</option>
                    <option value="3">=</option>
                </select>
              </th>
              <th scope="col" role="button">
                <span wire:click="sortBy('price')">Ár(€)</span>
              </th>
              <th scope="col" role="button">
                <span wire:click="sortBy('type')">Hely</span>
              </th>
              <th scope="col" role="button">
                <span wire:click="sortBy('company')">Gyártó</span>
              </th>
              <th scope="col" role="button">
                <span wire:click="sortBy('description')">Leírás</span>
              </th>
              <th scope="col">Művelet</th>
              </tr>
            <tr>
                <th></th>
                <th>
                  <div class="col-xs-3">
                  <input class="form-control" wire:keyup="searchInTable" type="text" wire:model="serialnumber">
                  </div>
                </th>
                <th>
                  <div class="col-xs-3">
                  <input class="form-control" wire:keyup="searchInTable" type="text" wire:model="uname">
                  </div>
                  </th>
                  <th>
                    <div class="col-xs-2">
                      <input class="form-control" wire:keyup="searchInTable" type="text" wire:model="quantity_value">
                    </div>
                </th>
                <th>
                  <div class="col-xs-2">
                    <input class="form-control" wire:keyup="searchInTable" type="text" wire:model="price">
                  </div>
              </th>
              <th>
                <div class="col-xs-2">
                  <input class="form-control" wire:keyup="searchInTable" type="text" wire:model="location">
                </div>
            </th>
            <th>
              <div class="col-xs-2">
                <input class="form-control" wire:keyup="searchInTable" type="text" wire:model="company">
              </div>
          </th>
          <th>
            <div class="col-xs-2">
              <input class="form-control" wire:keyup="searchInTable" type="text" wire:model="description">
            </div>
        </th>
                <th></th>
              </tr>
          </thead>
          <tbody>
            @foreach ($items as $item)
              <tr wire:loading.class="text-muted">
                <th scope="row">{{$item->id}}</th>
                <td>{{ $item->serialnumber }}</td>
                <td>{{ $item->uniquename }}</td>
                <td>{{ $item->quantity_value }}</td>
                <td>{{ $item->price }}</td>
                <td>{{ $item->location }}</td>
                <td>{{ $item->company }}</td>
                <td>{{ $item->description }}</td>
                <td><a class="btn" href="{{route('items.show', $item->id)}}">Megnyitás</a></td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
  </div>
  <div class="d-flex justify-content-center" wire:loading.class="alert alert-warning">
    <div wire:loading>
        <strong>Betöltés</strong>
    </div>
  </div>
</div>

