<div>
  <div class="card m-2">
      <div class="card-body">
        <div wire:loading>
          <div wire:loading.class="loadingmessage text-center d-flex justify-content-center align-items-center bg-light">
            <div style="backdrop-filter: blur(10px);"><h1>Betöltés</h1></div>
          </div>
        </div>
        <table class="table table-hover">
          Result: {{$items->total()}}, Total quantity: {{$totalquantity}}, Total value: {{$totalvalue}} €
          <thead>
            <tr>
              <th scope="col">
                <span role="button" wire:click="sortBy('id')" :direction="$sortedfield == 'id' ? $fieldDirection : null"># 
                  @if($sortedfield == 'id')
                  @if ($fieldDirection == 'asc')
                  <i class="fa-solid fa-arrow-down-short-wide"></i>
                  @else
                  <i class="fa-solid fa-arrow-down-wide-short"></i>
                  @endif
                  @else
                    <i class="fa-solid fa-sort"></i>
                  @endif
                </span>
              </th>
              <th scope="col">
                <span role="button" wire:click="sortBy('serialnumber')" :direction="$sortedfield == 'serialnumber' ? $fieldDirection : null">Sorozatszám 
                  @if($sortedfield == 'serialnumber')
                    @if ($fieldDirection == 'asc')
                    <i class="fa-solid fa-arrow-down-a-z"></i>
                    @else
                    <i class="fa-solid fa-arrow-down-z-a"></i>  
                    @endif
                  @else
                    <i class="fa-solid fa-sort"></i>
                  @endif
                </span>
              </th>
              <th scope="col" role="button">
                <span wire:click="sortBy('uniquename')" :direction="$sortedfield == 'uniquename' ? $fieldDirection : null">Megnevezés 
                  @if($sortedfield == 'uniquename')
                    @if ($fieldDirection == 'asc')
                    <i class="fa-solid fa-arrow-down-a-z"></i>
                    @else
                    <i class="fa-solid fa-arrow-down-z-a"></i>  
                    @endif
                  @else
                    <i class="fa-solid fa-sort"></i>
                  @endif
                </span>
              </th>
              <th scope="col" role="button">
                <span wire:click="sortBy('quantity')">Darabszám <i class="fa-solid fa-sort"></i></span>
                <select name="relation" id="relation" wire:model="relation" wire:change="filterChanged">
                    <option value="0">*</option>
                    <option value="1">></option>
                    <option value="2"><</option>
                    <option value="3">=</option>
                </select>
              </th>
              <th scope="col" role="button">
                <span wire:click="sortBy('price')">Ár(€) <i class="fa-solid fa-sort"></i></span>
              </th>
              <th scope="col" role="button">
                <span wire:click="sortBy('type')">Hely <i class="fa-solid fa-sort"></i></span>
              </th>
              <th scope="col" role="button">
                <span wire:click="sortBy('company')">Gyártó <i class="fa-solid fa-sort"></i></span>
              </th>
              <th scope="col" role="button">
                <span wire:click="sortBy('description')">Leírás <i class="fa-solid fa-sort"></i></span>
              </th>
              <th scope="col">Művelet</th>
              </tr>
            <tr>
                <th></th>
                <th>
                  <div class="col-xs-3">
                  <input class="form-control" wire:keyup="filterChanged" type="text" wire:model="serialnumber">
                  </div>
                </th>
                <th>
                  <div class="col-xs-3">
                  <input class="form-control" wire:keyup="filterChanged" type="text" wire:model="uname">
                  </div>
                  </th>
                  <th>
                    <div class="col-xs-2">
                      <input class="form-control" wire:keyup="filterChanged" type="text" wire:model="quantity">
                    </div>
                </th>
                <th>
                  <div class="col-xs-2">
                    <input class="form-control" wire:keyup="filterChanged" type="text" wire:model="price">
                  </div>
              </th>
              <th>
                <div class="col-xs-2">
                  <input class="form-control" wire:keyup="filterChanged" type="text" wire:model="location">
                </div>
            </th>
            <th>
              <div class="col-xs-2">
                <input class="form-control" wire:keyup="filterChanged" type="text" wire:model="company">
              </div>
          </th>
          <th>
            <div class="col-xs-2">
              <input class="form-control" wire:keyup="filterChanged" type="text" wire:model="description">
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
                <td>{{ $item->quantity }}</td>
                <td>{{ $item->price }}</td>
                <td>{{ $item->location }}</td>
                <td>{{ $item->company }}</td>
                <td>{{ $item->description }}</td>
                <td><a class="btn" href="{{route('items.show', $item->id)}}">Megnyitás</a></td>
              </tr>
            @endforeach
          </tbody>
          
          {{ $items->links() }}
        </table>
        
      </div>
  </div>
  
</div>

