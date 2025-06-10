@extends('layouts.main')

@section('body')
    @include('layouts.cardOpen')
        @if(isset($errorMessage))
            <div class="alert-danger mt-1 p-2">{{ $errorMessage }}</div>
        @endif
        
        <div class="row mt-2">
          <div class="col-6"> 
            <div class="col">              
              <h5 class="card-title">Stock</h5>
            </div>
            <div class="col">
              <p>Total Item : {{$items->count()}}</p>
            </div>
          </div>
          {{-- <div class="col-6 d-flex justify-content-end h-50">
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">Tambahkan Data</button>
          </div> --}}
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
                                <td>{{$item->stock}}</td>
                            </tr>
                            <?php } ?>
                        </tbody>
                      </table>
                      
                    </div>
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