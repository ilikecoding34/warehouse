<div>
  <div class="card m-2">
      <div class="card-body">
        Result: {{count($items)}}
        <table class="table">
          <thead>
            <tr>
              <th scope="col">
                <span role="button" wire:click="sortBy('id')">#</span>
              </th>
              <th scope="col">
                <span role="button" wire:click="sortBy('serialnumber')">serialnumber</span>
              </th>
              <th scope="col" role="button">
                <span wire:click="sortBy('uniquename')">uniquename</span>
                </th>
              <th scope="col" role="button">
                <span wire:click="sortBy('price')">price</span>
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
                    <input class="form-control" type="text">
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
                <td>{{ $item->price }}</td>
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

