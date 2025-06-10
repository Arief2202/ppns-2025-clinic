@extends('layouts.main')

@section('body')
    @include('layouts.cardOpen')
        @if(isset($errorMessage))
            <div class="alert-danger mt-1 p-2">{{ $errorMessage }}</div>
        @endif
        
        <div class="row mt-2">
          <div class="col-6"> 
            <div class="col">              
              <h5 class="card-title">Merk</h5>
            </div>
            <div class="col">
              <p>Total Merk : {{$brands->count()}}</p>
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
                                <th>Nama Merk</th>
                                <th class="w-25">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="tbody">
                            <?php foreach($brands as $item){?>
                            <tr>
                                <td>{{$item->name}}</td>
                                <td class="d-flex justify-content-end">
                                  <button type="submit" class="btn btn-warning me-2" onclick="updateModal({{$item->id}})">Update</button>
                                  <form action="/gudang/merk/delete" method="post" style="display: inline"> @csrf
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
              <form method="POST" action="/gudang/merk/create">@csrf
                <div class="modal-header">
                  <h1 class="modal-title fs-5" id="exampleModalLabel">Create Merk Baru</h1>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  <div class="mb-3">
                    <label class="form-label">Nama Jenis</label>
                    <input type="text" class="form-control" name="name">
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
      function updateModal(id){
          const xhttp = new XMLHttpRequest();
          xhttp.onload = function() {
            var response = JSON.parse(this.responseText);
            document.getElementById("name").value = response.name;
            document.getElementById("id").value = id;
            $("#exampleModalUpdate").modal("show");
            
          }
          xhttp.open("GET", "/get-brand?id="+id, true);
          xhttp.send();
        }

        $(document).ready( function () {
            $('#myTable').DataTable({
                fixedHeader: true
            });
        }); 
    </script>
@endsection