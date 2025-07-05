
@extends('layouts.main')

@section('body')
    @include('layouts.cardOpen')
        @if(isset($errorMessage))
            <div class="alert-danger mt-1 p-2">{{ $errorMessage }}</div>
        @endif
        <div class="row mt-2 mb-2">
          <div class="col-6">
            <div class="col">
              <h5 class="card-title">Detail Pemusnahan Obat & BMHP</h5>
            </div>
          </div>
          @if(Auth::user()->role_id == 5)
          <div class="col-6 d-flex justify-content-end h-50">
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editModal" onclick="changeEditModal({{$data->id}})">Edit Data</button>
          </div>
          @endif
        </div>

        <div style="max-height: 100vh; overflow-y:auto;">
            <div class="card-text me-3">
                  <div style="max-height: 68vh; overflow-y:auto;">
                    <div class="card-text me-3">
                        <div class="row">
                            <div class="col-6">
                                <div class="mb-2">
                                    <label for="nip_pasien" class="form-label">NIP Pasien</label>
                                    <input type="text" class="form-control" id="nip_pasien" value="{{$data->pasien()->nip}}" disabled>
                                </div>
                                <div class="mb-2">
                                    <label for="nama_pasien" class="form-label">Nama Pasien</label>
                                    <input type="text" class="form-control" id="nama_pasien" value="{{$data->pasien()->nama}}" disabled>
                                </div>
                                <div class="mb-2">
                                    <label for="tanggal_kunjungan" class="form-label">Tanggal Kunjungan</label>
                                    <input type="text" class="form-control" id="tanggal_kunjungan" value="{{date("d M Y", strtotime($data->tanggal_kunjungan))}}" disabled>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="mb-2">
                                    <label for="nip_pemeriksa" class="form-label">NIP Pemeriksa</label>
                                    <input type="text" class="form-control" id="nip_ppemeriksa" value="{{$data->pemeriksa()->nip}}" disabled>
                                </div>
                                <div class="mb-2">
                                    <label for="nama_pemeriksa" class="form-label">Nama Pemeriksa</label>
                                    <input type="text" class="form-control" id="nama_pemeriksa" value="{{$data->pemeriksa()->name}}" disabled>
                                </div>
                                <div class="mb-2">
                                    <label for="editor" class="form-label">Editor</label>
                                    <input type="text" class="form-control" id="editor" value="{{$data->editor()->name}}" disabled>
                                </div>
                            </div>
                        </div>
                        <hr>
                        @if(Auth::user()->role_id == 5)
                            <div class="d-flex justify-content-end w-100 mb-2">
                                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createModal">Tambahkan Rekam Medis Psikolog</button>
                            </div>
                        @endif
                        <table id="myTable">
                            <thead class="thead">
                                <tr>
                                    <th>No</th>
                                    <th>Catatan Kondisi</th>
                                    <th>Intervensi</th>
                                    <th>Status Intervensi Lanjutan</th>
                                    <th>Tanggal Rujukan</th>
                                    <th>Dokumen Rujukan</th>
                                    @if(Auth::user()->role_id == 5)
                                    <th>Delete</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody class="tbody">
                                <?php foreach($data->items() as $i=>$item){?>
                                <tr>
                                    <td>{{$i+1}}</td>
                                    <td>{{$item->catatan_kondisi}}</td>
                                    <td>{{$item->intervensi}}</td>
                                    <td>{{$item->status_intervensi_lanjutan}}</td>
                                    <td>{{date("d M Y", strtotime($item->tanggal_rujukan))}}</td>
                                    <td><button class="btn btn-primary" onclick="window.open('{{$item->dokumen_rujukan}}','_blank')">Lihat Dokumen</button></td>

                                    @if(Auth::user()->role_id == 5)
                                    <form method="POST" action="/kesehatan-mental/rekam-medis-psikolog/delete">@csrf
                                        <input type="hidden" name="id" value="{{$item->id}}">
                                        <td>
                                            <button class="btn btn-danger" type="submit">Delete Data</button>
                                        </td>
                                    </form>
                                    @endif
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>

                    </div>
                  </div>
            </div>
        </div>

        @if(Auth::user()->role_id == 5)
        <div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModal" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form action="/kesehatan-mental/registrasi-kunjungan-psikolog/detail/create" method="POST" enctype="multipart/form-data">@csrf
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Tambahkan Rekam Medis Psikolog</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" id="registrasi_id" name="registrasi_id" value="{{$data->id}}">
                            <div class="mb-2">
                                <label for="catatan_kondisi" class="form-label">Catatan Kondisi</label>
                                <input type="text" class="form-control" id="catatan_kondisi" name="catatan_kondisi" required>
                            </div>
                            <div class="mb-2">
                                <label for="intervensi" class="form-label">Intervensi</label>
                                <input type="text" class="form-control" id="intervensi" name="intervensi" required>
                            </div>
                            <div class="">
                                <label for="status_intervensi_lanjutan" class="form-label">Status Intervensi Lanjutan</label>
                            </div>
                            <div class="mb-2">
                                <select class="selectpicker" data-live-search="true" id="status_intervensi_lanjutan" name="status_intervensi_lanjutan">
                                    <option value="Dicukupkan">Dicukupkan</option>
                                    <option value="Rujukan">Rujukan</option>
                                    <option value="Konseling Lanjutan">Konseling Lanjutan</option>
                                </select>
                            </div>

                            <div class="mb-2">
                                <label for="tanggal_rujukan" class="form-label">Tanggal Rujukan</label>
                                <input type="date" class="form-control" id="tanggal_rujukan" name="tanggal_rujukan" required>
                            </div>
                            <div class="mb-2">
                                <label for="dokumen_rujukan" class="form-label">Dokumen Rujukan</label>
                                <input type="file" class="form-control" id="dokumen_rujukan" name="dokumen_rujukan" required>
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
                    <form action="/kesehatan-mental/registrasi-kunjungan-psikolog/edit" method="POST" enctype="multipart/form-data">@csrf
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Data</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" id="idEdit" name="id">
                            <div class="">
                                <label for="pasien_idEdit" class="form-label">Pasien</label>
                            </div>
                            <div class="mb-2">
                                <select class="selectpicker" data-live-search="true" id="pasien_idEdit" name="pasien_id">
                                    <option value="">Pilih Pasien</option>
                                    @foreach($pasiens as $pasien)
                                        <option value="{{$pasien->id}}">[{{$pasien->nip}}] {{$pasien->nama}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div id="addNewItemDiv"></div>
                            <div class="">
                                <label for="pemeriksa_idEdit" class="form-label">Pemeriksa</label>
                            </div>
                            <div class="mb-2">
                                <select class="selectpicker" data-live-search="true" id="pemeriksa_idEdit" name="pemeriksa_id">
                                    <option value="">Pilih Pemeriksa</option>
                                    @foreach($pemeriksas as $pemeriksa)
                                        <option value="{{$pemeriksa->id}}">[{{$pemeriksa->nip}}] {{$pemeriksa->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="tanggal_kunjunganEdit" class="form-label">Tanggal Kunjungan</label>
                                <input type="date" class="form-control" id="tanggal_kunjunganEdit" name="tanggal_kunjungan" required>
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


@section('style2')
    <link rel="stylesheet" href="/vendor/bootstrap-select-1.14.0-beta3/css/bootstrap-select.min.css">
@endsection

@section('script')
        <script src="/vendor/bootstrap-select-1.14.0-beta3/js/bootstrap-select.min.js"></script>
        <script>
        $(document).ready( function () {
            $('#myTable').DataTable({
            });
        });
        function changeEditModal(id){
            const xhttp = new XMLHttpRequest();
            xhttp.onload = function() {
                const res = JSON.parse(this.responseText);
                const datee = new Date(res.tanggal_kunjungan);
                var day = ("0" + datee.getDate()).slice(-2);
                var month = ("0" + (datee.getMonth() + 1)).slice(-2);
                var today = datee.getFullYear()+"-"+(month)+"-"+(day);


                document.getElementById('idEdit').value=res.id;
                document.getElementById('tanggal_kunjunganEdit').value=today;

                $('#pasien_idEdit').selectpicker('val', res.pasien_id.toString());
                $('#pemeriksa_idEdit').selectpicker('val', res.pemeriksa_id.toString());
            }
            xhttp.open("GET", "/api/kesehatan-mental/registrasi-kunjungan-psikolog/get?id="+id, true);
            xhttp.send();
        }
        function del(){
            $.ajax({
                url: "/kesehatan-mental/registrasi-kunjungan-psikolog/delete",
                type:"POST",
                data:{
                    id: document.getElementById('idEdit').value,
                    _token: document.getElementsByTagName("meta")[3].content
                }
            });
            setTimeout(function() {
                window.location.href = "/kesehatan-mental/registrasi-kunjungan-psikolog";
            }, 200);
        }
    </script>
@endsection

