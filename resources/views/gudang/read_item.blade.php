@extends('layouts.main')

@section('body')
    @include('layouts.cardOpen')
        @if(isset($errorMessage))
            <div class="alert-danger mt-1 p-2">{{ $errorMessage }}</div>
        @endif
        
        <div class="row mt-2">
          <div class="col-6"> 
            <div class="col">              
              <h5 class="card-title">Items</h5>
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
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="tbody">
                            <?php foreach($items as $item){?>
                            <tr>
                                <td>{{$item->type()->name}}</td>
                                <td>{{$item->brand()->name}}</td>
                                <td>{{$item->varian}}</td>
                                <td>{{$item->product_code}}</td>
                                <td>
                                  <button type="submit" class="btn btn-warning me-2" onclick="updateModal({{$item->id}})">Update</button>
                                  <form action="/gudang/item/delete" method="post" style="display: inline"> @csrf
                                    <input type="hidden" name="id" value="{{$item->id}}">
                                    <button type="submit" class="btn btn-danger">Delete</button>
                                  </form>
                                </td>
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
              <form method="POST" action="/gudang/item/create">@csrf
                <div class="modal-header">
                  <h1 class="modal-title fs-5" id="exampleModalLabel">Create New Item</h1>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  
                  <div class="mb-3">
                    <label class="form-label">Jenis</label>
                    <select class="form-select" name="item_type_id">
                      @foreach($types as $type)
                        <option value="{{$type->id}}">{{$type->name}}</option>
                      @endforeach
                    </select>
                  </div>
                  <div class="mb-3">
                    <label class="form-label">Merk</label>
                    <select class="form-select" name="item_brand_id">
                      @foreach($brands as $brand)
                        <option value="{{$brand->id}}">{{$brand->name}}</option>
                      @endforeach
                    </select>
                  </div>

                  <div class="mb-3">
                    <label class="form-label">Varian</label>
                    <input type="text" class="form-control" name="varian">
                  </div>
                  <div class="mb-3">
                    <label class="form-label">Kode Produk</label>
                    <input type="text" class="form-control" name="product_code">
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
              <form method="POST" action="/gudang/item/update">@csrf
                <input type="hidden" name="id" id="id">
                <div class="modal-header">
                  <h1 class="modal-title fs-5" id="exampleModalLabel">Update Item</h1>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  
                  <div class="mb-3">
                    <label class="form-label">Jenis</label>
                    <select class="form-select" name="item_type_id" id="item_type_id">
                      @foreach($types as $type)
                        <option value="{{$type->id}}">{{$type->name}}</option>
                      @endforeach
                    </select>
                  </div>
                  <div class="mb-3">
                    <label class="form-label">Merk</label>
                    <select class="form-select" name="item_brand_id" id="item_brand_id">
                      @foreach($brands as $brand)
                        <option value="{{$brand->id}}">{{$brand->name}}</option>
                      @endforeach
                    </select>
                  </div>

                  <div class="mb-3">
                    <label class="form-label">Varian</label>
                    <input type="text" class="form-control" name="varian" id="varian">
                  </div>
                  <div class="mb-3">
                    <label class="form-label">Kode Produk</label>
                    <input type="text" class="form-control" name="product_code" id="product_code">
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
        function updateModal(id){
          const xhttp = new XMLHttpRequest();
          xhttp.onload = function() {
            var response = JSON.parse(this.responseText);
            //========================== ITEM TYPE FILL ======================================            
            var item_type_id = document.getElementById("item_type_id").options;          
            var text = "";
            for(var a = 0; a<item_type_id.length; a++){
              var selected = "";
              if(item_type_id[a].value == response.item_type_id) selected = "selected";
              text += "<option value=\"" + item_type_id[a].value +"\" "+selected+">"+item_type_id[a].text+"</option>";
            }
            document.getElementById("item_type_id").innerHTML = text;
            
            //========================== ITEM BRAND FILL ====================================== 
            var item_brand_id = document.getElementById("item_brand_id").options;          
            var text = "";
            for(var a = 0; a<item_brand_id.length; a++){
              var selected = "";
              if(item_brand_id[a].value == response.item_brand_id) selected = "selected";
              text += "<option value=\"" + item_brand_id[a].value +"\" "+selected+">"+item_brand_id[a].text+"</option>";
            }
            document.getElementById("item_brand_id").innerHTML = text;

            document.getElementById("varian").value = response.varian;
            document.getElementById("product_code").value = response.product_code;
            document.getElementById("id").value = id;
            $("#exampleModalUpdate").modal("show");
            
          }
          xhttp.open("GET", "/get-item?id="+id, true);
          xhttp.send();
        }

        $(document).ready( function () {
            $('#myTable').DataTable({
                fixedHeader: true
            });
        }); 
    </script>
@endsection