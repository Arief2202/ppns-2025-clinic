
@extends('layouts.main')

@section('body')
    @include('layouts.cardOpen')
        @if(isset($errorMessage))
            <div class="alert-danger mt-1 p-2">{{ $errorMessage }}</div>
        @endif

        <div class="row mt-2 mb-3">
          <div class="col-6">
            <div class="col">
              <h5 class="card-title">Pengadaan Obat & BMHP</h5>
            </div>
          </div>
          @if(Auth::user()->role_id == 6)
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
                                <th>Nomor Pengadaan</th>
                                <th>Tanggal Pengadaan</th>
                                <th>Dokumen Pengadaan</th>
                                <th>Jumlah Item Pengadaan</th>
                                <th>Catatan</th>
                                <th>Status</th>
                                <th>Editor</th>
                                @if(Auth::user()->role_id == 1)
                                <th>Validate</th>
                                @endif
                                <th>Validator</th>
                                @if(Auth::user()->role_id == 6)
                                <th>Edit</th>
                                @endif
                                <th>Detail</th>
                            </tr>
                        </thead>
                        <tbody class="tbody">
                            <?php foreach($datas as $i=>$data){?>
                            <tr>
                                <td>{{$i+1}}</td>
                                <td>{{$data->nomor_pengadaan}}</td>
                                <td>{{date("d M Y", strtotime($data->tanggal_pengadaan))}}</td>
                                <td><button class="btn btn-primary" onclick="window.open('{{$data->dokumen_pengadaan}}','_blank')">Lihat Dokumen</button></td>
                                <td>{{$data->items()->count()}}</td>
                                <td>{{$data->catatan}}</td>
                                <td>{{$data->status}}</td>
                                <td>{{$data->editorPengadaan()->name}}</td>
                                @if(Auth::user()->role_id == 1)
                                <td>
                                    @if(!$data->validatorPengadaan()) <form method="POST" action="/manajemen-farmasi/pengadaan/validate">@csrf @endif
                                        <input type="hidden" name="id" value="{{$data->id}}">
                                        <button class="btn btn-success" {{$data->validatorPengadaan() ? 'disabled' : 'type="submit"'}}>Validasi</button>
                                    @if(!$data->validatorPengadaan()) </form> @endif
                                </td>
                                @endif
                                <td>{{$data->validatorPengadaan() ? $data->validatorPengadaan()->name : '-'}}</td>
                                @if(Auth::user()->role_id == 6)
                                <td><button class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#editModal" onclick="changeModal({{$data->id}})">Edit</button></td>
                                @endif
                                <td><a class="btn btn-primary" href="/manajemen-farmasi/pengadaan/detail?id={{$data->id}}">Detail</button></td>
                            </tr>
                            <?php } ?>
                        </tbody>
                      </table>

                    </div>
                  </div>
            </div>
        </div>

        @if(Auth::user()->role_id == 6)
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
                                <label for="nomor_pengadaan" class="form-label">Nomor Pengadaan</label>
                                <input type="text" class="form-control" id="nomor_pengadaan" name="nomor_pengadaan" required>
                            </div>
                            <div class="mb-3">
                                <label for="tanggal_pengadaan" class="form-label">Tanggal Pengadaan</label>
                                <input type="date" class="form-control" id="tanggal_pengadaan" name="tanggal_pengadaan" required>
                            </div>
                            <div class="mb-3">
                                <label for="dokumen_pengadaan" class="form-label">Dokumen Pengadaan</label>
                                <input type="file" class="form-control" id="dokumen_pengadaan" name="dokumen_pengadaan" required>
                            </div>
                            <div class="mb-3">
                                <label for="catatan" class="form-label">Catatan</label>
                                <input type="text" class="form-control" id="catatan" name="catatan" required>
                            </div>
                            <div class="mb-3">
                                <label for="status" class="form-label">Status</label>
                                <input type="text" class="form-control" id="status" name="status" required>
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
                    <form action="/manajemen-farmasi/pengadaan/edit" method="POST" enctype="multipart/form-data">@csrf
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Data</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" id="idEdit" name="id">
                            <input type="hidden" name="from_link" value="/manajemen-farmasi/pengadaan">
                            <div class="mb-3">
                                <label for="nomor_pengadaanEdit" class="form-label">Nomor Pengadaan</label>
                                <input type="text" class="form-control" id="nomor_pengadaanEdit" name="nomor_pengadaan" required>
                            </div>
                            <div class="mb-3">
                                <label for="tanggal_pengadaanEdit" class="form-label">Tanggal Pengadaan</label>
                                <input type="date" class="form-control" id="tanggal_pengadaanEdit" name="tanggal_pengadaan">
                            </div>
                            <div class="mb-3">
                                <label for="dokumen_pengadaanEdit" class="form-label">Dokumen Pengadaan</label>
                                <input type="file" class="form-control" id="dokumen_pengadaanEdit" name="dokumen_pengadaan">
                            </div>
                            <div class="mb-3">
                                <label for="catatanEdit" class="form-label">Catatan</label>
                                <input type="text" class="form-control" id="catatanEdit" name="catatan">
                            </div>
                            <div class="mb-3">
                                <label for="statusEdit" class="form-label">Status</label>
                                <input type="text" class="form-control" id="statusEdit" name="status">
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

        @endif
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
                const datee = new Date(res.tanggal_pengadaan);
                var day = ("0" + datee.getDate()).slice(-2);
                var month = ("0" + (datee.getMonth() + 1)).slice(-2);
                var today = datee.getFullYear()+"-"+(month)+"-"+(day);
                document.getElementById('idEdit').value=res.id;
                document.getElementById('nomor_pengadaanEdit').value=res.nomor_pengadaan;
                document.getElementById('tanggal_pengadaanEdit').value= today;
                document.getElementById('catatanEdit').value= res.catatan;
                document.getElementById('statusEdit').value= res.status;

            }
            xhttp.open("GET", "/api/manajemen-farmasi/pengadaan/get?id="+id, true);
            xhttp.send();
        }
        function del(){
            $.ajax({
                url: "/manajemen-farmasi/pengadaan/delete",
                type:"POST",
                data:{
                    id: document.getElementById('idEdit').value,
                    _token: document.getElementsByTagName("meta")[3].content
                }
            });
            setTimeout(function() {
                window.location.href = "/manajemen-farmasi/pengadaan";
            }, 200);
        }
    </script>
@endsection

