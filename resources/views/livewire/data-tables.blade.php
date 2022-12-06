<div>
  <div class="card m-2">
      <div class="card-body">
        Result: {{count($items)}}, Total quantity: {{$totalquantity}}, Total value: {{$totalvalue}} €
        <table class="table">
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
                    <span wire:click="sortBy('value')">Darabszám</span>
                </th>
              <th scope="col" role="button">
                <span wire:click="sortBy('price')">Ár(€)</span>
            </th>
            <th scope="col" role="button">
              <span wire:click="sortBy('type')">Hely</span>
          </th>
          <th scope="col" role="button">
            <span wire:click="sortBy('company')">Gyártó</span>

        <th scope="col" role="button">
          <span wire:click="sortBy('description')">Leírás</span>
      </th>
              <th scope="col">Művelet</th>
            </tr>
            <tr>
                <th></th>
                <th>
                  <div class="col-xs-3">
                  <input class="form-control" type="text" wire:model="serialnumber">
                  </div>
                </th>
                <th>
                  <div class="col-xs-3">
                  <input class="form-control" type="text" wire:model="uname">
                  </div>
                  </th>
                  <th>
                    <div class="col-xs-2">
                      <input class="form-control" type="text" wire:model="value">
                    </div>
                </th>
                <th>
                  <div class="col-xs-2">
                    <input class="form-control" type="text" wire:model="price">
                  </div>
              </th>
              <th>
                <div class="col-xs-2">
                  <input class="form-control" type="text" wire:model="location">
                </div>
            </th>
            <th>
              <div class="col-xs-2">
                <input class="form-control" type="text" wire:model="company">
              </div>
          </th>
          <th>
            <div class="col-xs-2">
              <input class="form-control" type="text" wire:model="description">
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
                <td>{{ $item->getLatestQuantity->first()->value }}</td>
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

