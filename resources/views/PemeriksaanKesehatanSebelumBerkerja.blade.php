@extends('layouts.main')

@section('body')
    @include('layouts.cardOpen')
        @if(isset($errorMessage))
            <div class="alert-danger mt-1 p-2">{{ $errorMessage }}</div>
        @endif

        <div class="row mt-2 mb-3">
          <div class="col-6">
            <div class="col">
              <h5 class="card-title">Pemeriksaan Kesehatan Sebelum Berkerja</h5>
            </div>
          </div>
          @if(Auth::user()->role_id == 1 || Auth::user()->role_id == 3)
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
                                <th>ID Pekerja</th>
                                <th>Nama Pekerja</th>
                                <th>Bagian</th>
                                <th>Tanggal Pemeriksaan</th>
                                <th>Hasil</th>
                                <th>Catatan</th>
                                <th>Dokumen Hasil Pemeriksaan</th>
                                <th>Editor</th>
                                @if(Auth::user()->role_id == 1 || Auth::user()->role_id == 3)
                                <th>Edit</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody class="tbody">
                            <?php foreach($datas as $i=>$data){?>
                            <tr>
                                <td>{{$i+1}}</td>
                                <td>{{$data->id_pekerja}}</td>
                                <td>{{$data->nama_pekerja}}</td>
                                <td>{{$data->bagian}}</td>
                                <td>{{date("d M Y", strtotime($data->tanggal_pemeriksaan))}}</td>
                                <td>{{$data->hasil}}</td>
                                <td>{{$data->catatan}}</td>
                                <td><button class="btn btn-primary" onclick="window.open('{{$data->dokumen_hasil_pemeriksaan}}','_blank')">Lihat Dokumen</button></td>
                                <td>{{$data->editor()->name}}</td>
                                @if(Auth::user()->role_id == 1 || Auth::user()->role_id == 3)
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
                                <label for="id_pekerja" class="form-label">ID Pekerja</label>
                                <input type="text" class="form-control" id="id_pekerja" name="id_pekerja" required>
                            </div>
                            <div class="mb-3">
                                <label for="nama_pekerja" class="form-label">Nama Pekerja</label>
                                <input type="text" class="form-control" id="nama_pekerja" name="nama_pekerja" required>
                            </div>
                            <div class="mb-3">
                                <label for="bagian" class="form-label">Bagian</label>
                                <input type="text" class="form-control" id="bagian" name="bagian" required>
                            </div>
                            <div class="mb-3">
                                <label for="tanggal_pemeriksaan" class="form-label">Tanggal Pemeriksaan</label>
                                <input type="date" class="form-control" id="tanggal_pemeriksaan" name="tanggal_pemeriksaan" required>
                            </div>
                            <div class="mb-3">
                                <label for="hasil" class="form-label">Hasil</label>
                                <input type="text" class="form-control" id="hasil" name="hasil" required>
                            </div>
                            <div class="mb-3">
                                <label for="catatan" class="form-label">Catatan</label>
                                <input type="text" class="form-control" id="catatan" name="catatan" required>
                            </div>
                            <div class="mb-3">
                                <label for="dokumen_hasil_pemeriksaan" class="form-label">Dokumen Hasil Pemeriksaan</label>
                                <input type="file" class="form-control" id="dokumen_hasil_pemeriksaan" name="dokumen_hasil_pemeriksaan" required>
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
                    <form action="/smk3/pemeriksaan-kesehatan-pekerja/pemeriksaan-kesehatan-sebelum-bekerja/edit" method="POST" enctype="multipart/form-data">@csrf
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Data</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" id="idEdit" name="id">
                            <div class="mb-3">
                                <label for="id_pekerjaEdit" class="form-label">ID Pekerja</label>
                                <input type="text" class="form-control" id="id_pekerjaEdit" name="id_pekerja">
                            </div>
                            <div class="mb-3">
                                <label for="nama_pekerjaEdit" class="form-label">Nama Pekerja</label>
                                <input type="text" class="form-control" id="nama_pekerjaEdit" name="nama_pekerja">
                            </div>
                            <div class="mb-3">
                                <label for="bagianEdit" class="form-label">Bagian</label>
                                <input type="text" class="form-control" id="bagianEdit" name="bagian">
                            </div>
                            <div class="mb-3">
                                <label for="tanggal_pemeriksaanEdit" class="form-label">Tanggal Pemeriksaan</label>
                                <input type="date" class="form-control" id="tanggal_pemeriksaanEdit" name="tanggal_pemeriksaan">
                            </div>
                            <div class="mb-3">
                                <label for="hasilEdit" class="form-label">Hasil</label>
                                <input type="text" class="form-control" id="hasilEdit" name="hasil">
                            </div>
                            <div class="mb-3">
                                <label for="catatanEdit" class="form-label">Catatan</label>
                                <input type="text" class="form-control" id="catatanEdit" name="catatan">
                            </div>
                            <div class="mb-3">
                                <label for="dokumen_hasil_pemeriksaanEdit" class="form-label">Dokumen Hasil Pemeriksaan</label>
                                <input type="file" class="form-control" id="dokumen_hasil_pemeriksaanEdit" name="dokumen_hasil_pemeriksaan">
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
                const datee = new Date(res.tanggal_pemeriksaan);
                var day = ("0" + datee.getDate()).slice(-2);
                var month = ("0" + (datee.getMonth() + 1)).slice(-2);
                var today = datee.getFullYear()+"-"+(month)+"-"+(day);
                document.getElementById('idEdit').value=res.id;
                document.getElementById('id_pekerjaEdit').value= res.id_pekerja;
                document.getElementById('nama_pekerjaEdit').value= res.nama_pekerja;
                document.getElementById('bagianEdit').value= res.bagian;
                document.getElementById('tanggal_pemeriksaanEdit').value= today;
                document.getElementById('hasilEdit').value= res.hasil;
                document.getElementById('catatanEdit').value= res.catatan;
            }
            xhttp.open("GET", "/api/smk3/pemeriksaan-kesehatan-pekerja/pemeriksaan-kesehatan-sebelum-bekerja/get?id="+id, true);
            xhttp.send();
        }
        function del(){
            $.ajax({
                url: "/smk3/pemeriksaan-kesehatan-pekerja/pemeriksaan-kesehatan-sebelum-bekerja/delete",
                type:"POST",
                data:{
                    id: document.getElementById('idEdit').value,
                    _token: document.getElementsByTagName("meta")[3].content
                }
            });
            setTimeout(function() {
                window.location.href = "/smk3/pemeriksaan-kesehatan-pekerja/pemeriksaan-kesehatan-sebelum-bekerja";
            }, 200);
        }
    </script>
@endsection
