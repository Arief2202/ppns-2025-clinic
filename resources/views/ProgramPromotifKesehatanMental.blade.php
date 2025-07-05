
@extends('layouts.main')

@section('body')
    @include('layouts.cardOpen')
        @if(isset($errorMessage))
            <div class="alert-danger mt-1 p-2">{{ $errorMessage }}</div>
        @endif

        <div class="row mt-2 mb-3">
          <div class="col-6">
            <div class="col">
              <h5 class="card-title">Program Promotif Kesehatan Mental</h5>
            </div>
          </div>
          @if(Auth::user()->role_id == 5)
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
                                <th>Nama Program</th>
                                <th>Tujuan Program</th>
                                <th>Deskripsi Program</th>
                                <th>Tanggal Pelaksanaan</th>
                                <th>Dokumentasi</th>
                                <th>Editor</th>
                                @if(Auth::user()->role_id == 5)
                                <th>Edit</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody class="tbody">
                            <?php foreach($datas as $i=>$data){?>
                            <tr>
                                <td>{{$i+1}}</td>
                                <td>{{$data->nama_program}}</td>
                                <td>{{$data->tujuan_program}}</td>
                                <td>{{$data->deskripsi_program}}</td>
                                <td>{{date("d M Y", strtotime($data->tanggal_pelaksanaan))}}</td>
                                <td><button class="btn btn-primary" onclick="window.open('{{$data->dokumentasi}}','_blank')">Lihat Dokumentasi</button></td>
                                <td>{{$data->editor()->name}}</td>
                                @if(Auth::user()->role_id == 5)
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
                                <label for="nama_program" class="form-label">Nama Program</label>
                                <input type="text" class="form-control" id="nama_program" name="nama_program" required>
                            </div>
                            <div class="mb-3">
                                <label for="tujuan_program" class="form-label">Tujuan Program</label>
                                <input type="text" class="form-control" id="tujuan_program" name="tujuan_program" required>
                            </div>
                            <div class="mb-3">
                                <label for="deskripsi_program" class="form-label">Deskripsi Program</label>
                                <input type="text" class="form-control" id="deskripsi_program" name="deskripsi_program" required>
                            </div>
                            <div class="mb-3">
                                <label for="tanggal_pelaksanaan" class="form-label">Tanggal Pelaksanaan</label>
                                <input type="date" class="form-control" id="tanggal_pelaksanaan" name="tanggal_pelaksanaan" required>
                            </div>
                            <div class="mb-3">
                                <label for="dokumentasi" class="form-label">Dokumentasi</label>
                                <input type="file" class="form-control" id="dokumentasi" name="dokumentasi" required>
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
                    <form action="/kesehatan-mental/program-promotif-kesehatan-mental/edit" method="POST" enctype="multipart/form-data">@csrf
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Data</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" id="idEdit" name="id">
                            <div class="mb-3">
                                <label for="nama_programEdit" class="form-label">Nama Program</label>
                                <input type="text" class="form-control" id="nama_programEdit" name="nama_program">
                            </div>
                            <div class="mb-3">
                                <label for="tujuan_programEdit" class="form-label">Tujuan Program</label>
                                <input type="text" class="form-control" id="tujuan_programEdit" name="tujuan_program">
                            </div>
                            <div class="mb-3">
                                <label for="deskripsi_programEdit" class="form-label">Deskripsi Program</label>
                                <input type="text" class="form-control" id="deskripsi_programEdit" name="deskripsi_program">
                            </div>
                            <div class="mb-3">
                                <label for="tanggal_pelaksanaanEdit" class="form-label">Tanggal Pelaksanaan</label>
                                <input type="date" class="form-control" id="tanggal_pelaksanaanEdit" name="tanggal_pelaksanaan">
                            </div>
                            <div class="mb-3">
                                <label for="dokumentasiEdit" class="form-label">Dokumentasi</label>
                                <input type="file" class="form-control" id="dokumentasiEdit" name="dokumentasi">
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
                const datee = new Date(res.tanggal_pelaksanaan);
                var day = ("0" + datee.getDate()).slice(-2);
                var month = ("0" + (datee.getMonth() + 1)).slice(-2);
                var today = datee.getFullYear()+"-"+(month)+"-"+(day);
                document.getElementById('idEdit').value=res.id;
                document.getElementById('nama_programEdit').value=res.nama_program;
                document.getElementById('tujuan_programEdit').value=res.tujuan_program;
                document.getElementById('deskripsi_programEdit').value=res.deskripsi_program;
                document.getElementById('tanggal_pelaksanaanEdit').value= today;
            }
            xhttp.open("GET", "/api/kesehatan-mental/program-promotif-kesehatan-mental/get?id="+id, true);
            xhttp.send();
        }
        function del(){
            $.ajax({
                url: "/kesehatan-mental/program-promotif-kesehatan-mental/delete",
                type:"POST",
                data:{
                    id: document.getElementById('idEdit').value,
                    _token: document.getElementsByTagName("meta")[3].content
                }
            });
            setTimeout(function() {
                window.location.href = "/kesehatan-mental/program-promotif-kesehatan-mental";
            }, 200);
        }
    </script>
@endsection
