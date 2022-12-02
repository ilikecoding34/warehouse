<div>
  <div class="card m-2">
      <div class="card-body">
        <table class="table">
          <thead>
            <tr>
              <th scope="col">#</th>
              <th scope="col">
                <span role="button" wire:click="sortBy('serialnumber')">serialnumber</span><input type="text" wire:model="serialnumber">
              </th>
              <th scope="col" role="button" ><span wire:click="sortBy('uniquename')">uniquename</span><input type="text" wire:model="uname"></th>
              <th scope="col" role="button" ><span wire:click="sortBy('price')">price</span><input type="text"></th>
            </tr>
          </thead>
          <tbody>
            @foreach ($items as $item)
              <tr wire:loading.class="text-muted">
                <th scope="row">{{$item->id}}</th>
                <td>{{ $item->serialnumber }}</td>
                <td>{{ $item->uniquename }}</td>
                <td>{{ $item->price }}</td>
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

