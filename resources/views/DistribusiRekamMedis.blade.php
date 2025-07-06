
@extends('layouts.main')

@section('body')
    @include('layouts.cardOpen')
        @if(isset($errorMessage))
            <div class="alert-danger mt-1 p-2">{{ $errorMessage }}</div>
        @endif

        <div class="row mt-2 mb-3">
          <div class="col-6">
            <div class="col">
              <h5 class="card-title">Distribusi Rekam Medis</h5>
            </div>
          </div>
          @if(Auth::user()->role_id == 7)
          <div class="col-6 d-flex justify-content-end h-50">
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createModal">Tambahkan Data</button>
          </div>
          @endif
        </div>

        <div style="max-height: 100vh; overflow-y:auto;">
            <div class="card-text me-3">
                  <div style="max-height: 68vh; overflow-y:auto;">
                    <div class="card-text me-3">

                      <table id="myTable">
                        <thead class="thead">
                            <tr>
                                <th>No</th>
                                <th>Tanggal Distribusi</th>
                                <th>Tujuan</th>
                                <th>Dokumentasi Distribusi</th>
                                <th>Editor</th>
                                @if(Auth::user()->role_id == 7)
                                <th>Edit</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody class="tbody">
                            <?php foreach($datas as $i=>$data){?>
                            <tr>
                                <td>{{$i+1}}</td>
                                <td>{{date("d M Y", strtotime($data->tanggal_distribusi))}}</td>
                                <td>{{$data->tujuan}}</td>
                                <td><button class="btn btn-primary" onclick="window.open('{{$data->dokumentasi_distribusi}}','_blank')">Lihat Dokumen</button></td>
                                <td>{{$data->editor()->name}}</td>
                                @if(Auth::user()->role_id == 7)
                                <td><button class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#editModal" onclick="changeModal({{$data->id}})">Edit</button></td>
                                @endif
                            </tr>
                            <?php } ?>
                        </tbody>
                      </table>

                    </div>
                  </div>
            </div>
        </div>

        <div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModal" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form method="POST" enctype="multipart/form-data">@csrf
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Tambahkan Data</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="tanggal_distribusi" class="form-label">Tanggal Distribusi</label>
                                <input type="date" class="form-control" id="tanggal_distribusi" name="tanggal_distribusi" required>
                            </div>
                            <div class="mb-3">
                                <label for="tujuan" class="form-label">Tujuan</label>
                                <input type="text" class="form-control" id="tujuan" name="tujuan" required>
                            </div>
                            <div class="mb-3">
                                <label for="dokumentasi_distribusi" class="form-label">Dokumentasi Distribusi</label>
                                <input type="file" class="form-control" id="dokumentasi_distribusi" name="dokumentasi_distribusi" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModal" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form action="/rekam-medis/distribusi-rekam-medis/edit" method="POST" enctype="multipart/form-data">@csrf
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Data</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" id="idEdit" name="id">
                            <div class="mb-3">
                                <label for="tanggal_distribusiEdit" class="form-label">Tanggal Distribusi</label>
                                <input type="date" class="form-control" id="tanggal_distribusiEdit" name="tanggal_distribusi">
                            </div>
                            <div class="mb-3">
                                <label for="tujuanEdit" class="form-label">Tujuan</label>
                                <input type="text" class="form-control" id="tujuanEdit" name="tujuan">
                            </div>
                            <div class="mb-3">
                                <label for="dokumentasi_distribusiEdit" class="form-label">Dokumentasi Distribusi</label>
                                <input type="file" class="form-control" id="dokumentasi_distribusiEdit" name="dokumentasi_distribusi">
                            </div>
                        </div>
                        <div class="modal-footer d-flex justify-content-between">
                            <button type="button" class="btn btn-danger" onclick="del()">Delete</button>
                            <button type="submit" class="btn btn-primary">Save changes</button>
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

            });
        });

        function changeModal(id){
            const xhttp = new XMLHttpRequest();
            xhttp.onload = function() {
                const res = JSON.parse(this.responseText);
                const datee = new Date(res.tanggal_distribusi);
                var day = ("0" + datee.getDate()).slice(-2);
                var month = ("0" + (datee.getMonth() + 1)).slice(-2);
                var today = datee.getFullYear()+"-"+(month)+"-"+(day);

                document.getElementById('idEdit').value=res.id;
                document.getElementById('tanggal_distribusiEdit').value= today;
                document.getElementById('tujuanEdit').value=res.tujuan;
                document.getElementById('dokumentasi_distribusiEdit').value=res.dokumentasi_distribusi;
                // document.getElementById('dokumen_HRAEdit').value=res.dokumen_HRA;
            }
            xhttp.open("GET", "/api/rekam-medis/distribusi-rekam-medis/get?id="+id, true);
            xhttp.send();
        }
        function del(){
            $.ajax({
                url: "/rekam-medis/distribusi-rekam-medis/delete",
                type:"POST",
                data:{
                    id: document.getElementById('idEdit').value,
                    _token: document.getElementsByTagName("meta")[3].content
                }
            });
            setTimeout(function() {
                window.location.href = "/rekam-medis/distribusi-rekam-medis";
            }, 200);
        }
    </script>
@endsection
