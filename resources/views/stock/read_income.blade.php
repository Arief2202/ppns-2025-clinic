@extends('layouts.main')

@section('body')
    @include('layouts.cardOpen')
        @if(isset($errorMessage))
            <div class="alert-danger mt-1 p-2">{{ $errorMessage }}</div>
        @endif
        
        <div class="row mt-2">
          <div class="col-6"> 
            <div class="col">              
              <h5 class="card-title">Income</h5>
            </div>
            <div class="col">
              <p>Total Item : {{$items->count()}}</p>
            </div>
          </div>
          <div class="col-6 d-flex justify-content-end h-50">
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">Tambahkan Data</button>
          </div>
        </div>

        <div style="max-height: 100vh; overflow-y:auto;">
            <div class="card-text me-3">    
                  <div style="max-height: 68vh; overflow-y:auto;">
                    <div class="card-text me-3">
                      
                      <table id="myTable">
                        <thead class="thead">
                            <tr>
                                <th>Jenis</th>
                                <th>Merk</th>
                                <th>Varian</th>
                                <th>Kode Produk</th>
                                <th>Stock</th>
                            </tr>
                        </thead>
                        <tbody class="tbody">
                            <?php foreach($items as $item){?>
                            <tr>
                                <td>{{$item->type()->name}}</td>
                                <td>{{$item->brand()->name}}</td>
                                <td>{{$item->varian}}</td>
                                <td>{{$item->product_code}}</td>
                                <td>0</td>
                            </tr>
                            <?php } ?>
                        </tbody>
                      </table>
                      
                    </div>
                  </div>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <form method="POST" action="/gudang/merk/create">@csrf
                <div class="modal-header">
                  <h1 class="modal-title fs-5" id="exampleModalLabel">Add Stock</h1>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  <div class="mb-3">
                    <label class="form-label">Item</label>
                    <select class="form-select" name="item_id" id="item_id">
                      @foreach($items as $item)
                        <option value="{{$item->id}}">{{$item->type()->name}}, {{$item->brand()->name}}, {{$item->varian}}, {{$item->product_code}}</option>
                      @endforeach
                    </select>
                  </div>

                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                  <button type="submit" class="btn btn-success">Submit</button>
                </div>
              </form>
            </div>
          </div>
        </div>
        {{-- Modal Update --}}
        <div class="modal fade" id="exampleModalUpdate" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <form method="POST" action="/gudang/merk/update">@csrf
                <input type="hidden" name="id" id="id">
                <div class="modal-header">
                  <h1 class="modal-title fs-5" id="exampleModalLabel">Update Merk</h1>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  <div class="mb-3">
                    <label class="form-label">Nama Jenis</label>
                    <input type="text" class="form-control" name="name" id="name">
                  </div>

                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                  <button type="submit" class="btn btn-success">Update</button>
                </div>
              </form>
            </div>
          </div>
        </div>

    @include('layouts.cardClose')
@endsection

@section('script')
    <script>
        $(document).ready( function () {
            $('#myTable').DataTable({
                fixedHeader: true
            });
        }); 
    </script>
@endsection