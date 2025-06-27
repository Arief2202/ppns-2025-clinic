
@extends('layouts.main')

@section('body')
    @include('layouts.cardOpen')
        @if(isset($errorMessage))
            <div class="alert-danger mt-1 p-2">{{ $errorMessage }}</div>
        @endif
        <div class="row mt-2 mb-2">
          <div class="col-6">
            <div class="col">
              <h5 class="card-title">Detail Laporan Kecelakaan Kerja</h5>
            </div>
          </div>
          @if(Auth::user()->role_id == 1 || Auth::user()->role_id == 2 || Auth::user()->role_id == 3)
          <div class="col-6 d-flex justify-content-end h-50">
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editModal">Edit Data</button>
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
                                    <label for="tanggal_kejadian" class="form-label">Tanggal & Waktu Kejadian</label>
                                    <input type="datetime-local" class="form-control" id="tanggal_kejadian" value="{{$data->tanggal_kejadian}}" disabled>
                                </div>
                                <div class="mb-2">
                                    <label for="lokasi_kejadian" class="form-label">Lokasi Kejadian</label>
                                    <input type="text" class="form-control" id="lokasi_kejadian" value="{{$data->lokasi_kejadian}}" disabled>
                                </div>
                                <div class="mb-2">
                                    <label for="jenis_kecelakaan" class="form-label">Jenis Kecelakaan</label>
                                    <input type="text" class="form-control" id="jenis_kecelakaan" value="{{$data->jenis_kecelakaan}}" disabled>
                                </div>

                            </div>
                            <div class="col-6">
                                <div class="mb-2">
                                    <label for="uraian_kejadian" class="form-label">Uraian Kejadian</label>
                                    <input type="text" class="form-control" id="uraian_kejadian" value="{{$data->uraian_kejadian}}" disabled>
                                </div>
                                <div class="mb-2">
                                    <label for="berita_acara" class="form-label">Berita Acara</label>
                                    <input type="text" class="form-control" id="berita_acara" value="{{$data->berita_acara}}" disabled>
                                </div>
                                <div class="mb-2">
                                    <label for="editor" class="form-label">Editor</label>
                                    <input type="text" class="form-control" id="editor" value="{{$data->editor()->name}}" disabled>
                                </div>
                            </div>
                        </div>
                        <hr>
                        @if(Auth::user()->role_id == 1 || Auth::user()->role_id == 2 || Auth::user()->role_id == 3)
                            <div class="d-flex justify-content-end w-100 mb-2">
                                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createModal">Tambahkan Korban</button>
                            </div>
                        @endif

                      <table id="myTable">
                        <thead class="thead">
                            <tr>
                                <th>No</th>
                                <th>NIP</th>
                                <th>Nama</th>
                                <th>Tanggal Lahir</th>
                                <th>Umur</th>
                                <th>Jenis Kelamin</th>
                                <th>Bagian</th>
                                <th>Dampak Kejadian</th>
                                <th>Tindakan Pertolongan</th>
                                @if(Auth::user()->role_id == 1 || Auth::user()->role_id == 2 || Auth::user()->role_id == 3)
                                <th>Delete</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody class="tbody">
                            <?php foreach($data->korbans() as $i=>$korban){?>
                            <tr>
                                <td>{{$i+1}}</td>
                                <td>{{$korban->pasien()->nip}}</td>
                                <td>{{$korban->pasien()->nama}}</td>
                                <td>{{date("d M Y", strtotime($korban->pasien()->tanggal_lahir))}}</td>
                                <td>{{$korban->pasien()->umur()}}</td>
                                <td>{{$korban->pasien()->jenis_kelamin}}</td>
                                <td>{{$korban->pasien()->bagian}}</td>
                                <td>{{$korban->dampak_kejadian}}</td>
                                <td>{{$korban->tindakan_pertolongan}}</td>
                                @if(Auth::user()->role_id == 1 || Auth::user()->role_id == 2 || Auth::user()->role_id == 3)
                                <td>
                                    <form method="POST" action="/pelaporan-kecelakaan/laporan-kecelakaan-kerja/korban/delete">@csrf
                                        <input type="hidden" name="id" value="{{$korban->id}}">
                                        <button class="btn btn-danger" type="submit">Delete</button>
                                    </form>
                                </td>
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
                    <form action="/pelaporan-kecelakaan/laporan-kecelakaan-kerja/korban/add" method="POST" enctype="multipart/form-data">@csrf
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Tambahkan Korban</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" id="laporan_id" name="laporan_id" value="{{$data->id}}">
                            <div class="">
                                <label for="pasien_id" class="form-label">Korban</label>
                            </div>
                            <div class="mb-2">
                                <select class="selectpicker" data-live-search="true" id="pasien_id" name="pasien_id" required>
                                    <option value="">Pilih Pasien</option>
                                    <option value="" id="addNewPasien">Tambah Pasien Baru</option>
                                    @foreach($pasiens as $pasien)
                                    <option value="{{$pasien->id}}">[{{$pasien->nip}}] {{$pasien->nama}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div id="addNewPasienDiv"></div>
                            <div class="mb-2">
                                <label for="dampak_kejadian" class="form-label">Dampak Kejadian</label>
                                <input type="text" class="form-control" id="dampak_kejadian" name="dampak_kejadian" required>
                            </div>
                            <div class="mb-2">
                                <label for="tindakan_pertolongan" class="form-label">Tindakan Pertolongan</label>
                                <input type="text" class="form-control" id="tindakan_pertolongan" name="tindakan_pertolongan" required>
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
                    <form action="/pelaporan-kecelakaan/laporan-kecelakaan-kerja/edit" method="POST" enctype="multipart/form-data">@csrf
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Data</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" id="idEdit" name="id" value="{{$data->id}}">
                            <div class="mb-2">
                                <label for="tanggal_kejadianEdit" class="form-label">Tanggal & Waktu Kejadian</label>
                                <input type="datetime-local" class="form-control" id="tanggal_kejadianEdit" name="tanggal_kejadian" value="{{$data->tanggal_kejadian}}">
                            </div>
                            <div class="mb-2">
                                <label for="lokasi_kejadianEdit" class="form-label">Lokasi Kejadian</label>
                                <input type="text" class="form-control" id="lokasi_kejadianEdit" name="lokasi_kejadian" value="{{$data->lokasi_kejadian}}">
                            </div>
                            <div class="mb-2">
                                <label for="jenis_kecelakaanEdit" class="form-label">Jenis Kecelakaan</label>
                                <select class="form-select" id="jenis_kecelakaanEdit" name="jenis_kecelakaan">
                                    <option value="Ringan" @if($data->jenis_kecelakaan == "Ringan") selected @endif>Ringan</option>
                                    <option value="Sedang" @if($data->jenis_kecelakaan == "Sedang") selected @endif>Sedang</option>
                                    <option value="Berat" @if($data->jenis_kecelakaan == "Berat") selected @endif>Berat</option>
                                    <option value="Fatality" @if($data->jenis_kecelakaan == "Fatality") selected @endif>Fatality</option>
                                </select>
                            </div>
                            <div class="mb-2">
                                <label for="uraian_kejadianEdit" class="form-label">Uraian Kejadian</label>
                                <input type="text" class="form-control" id="uraian_kejadianEdit" name="uraian_kejadian" value="{{$data->uraian_kejadian}}">
                            </div>
                            <div class="mb-2">
                                <label for="berita_acaraEdit" class="form-label">Berita Acara</label>
                                <input type="text" class="form-control" id="berita_acaraEdit" name="berita_acara" value="{{$data->berita_acara}}">
                            </div>
                        </div>
                        <div class="modal-footer d-flex justify-content-between">
                            <button type="button" class="btn btn-danger" onclick="del()">Delete Data</button>
                            <button type="submit" class="btn btn-primary">Save changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div style="display: none" id="templateAddNewUser">
            <div class="mb-2">
                <label for="nip" class="form-label">NIP</label>
                <input type="number" class="form-control" id="nip" name="nip" required>
            </div>
            <div class="mb-2">
                <label for="nama" class="form-label">Nama</label>
                <input type="text" class="form-control" id="nama" name="nama" required>
            </div>
            <div class="mb-2">
                <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
                <input type="date" class="form-control" id="tanggal_lahir" name="tanggal_lahir" required>
            </div>
            <div class="mb-2">
                <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                <select class="form-select" name="jenis_kelamin" id="jenis_kelamin">
                    <option value="Laki Laki">Laki Laki</option>
                    <option value="Perempuan">Perempuan</option>
                </select>
            </div>
            <div class="mb-2">
                <label for="bagian" class="form-label">Bagian</label>
                <input type="text" class="form-control" id="bagian" name="bagian" required>
            </div>
            <div class="mb-2">
                <label for="tanggal_registrasi" class="form-label">Tanggal Registrasi</label>
                <input type="date" class="form-control" id="tanggal_registrasi" name="tanggal_registrasi" required>
            </div>
        </div>

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
            // $('select').selectpicker();
            $('#pasien_id').change(function(){
                if(this.options[this.selectedIndex].text == "Tambah Pasien Baru"){
                    document.getElementById('addNewPasienDiv').innerHTML = document.getElementById('templateAddNewUser').innerHTML;
                }
                else{
                    document.getElementById('addNewPasienDiv').innerHTML = null;
                }
            })
        });
        function del(){
            $.ajax({
                url: "/pelaporan-kecelakaan/laporan-kecelakaan-kerja/delete",
                type:"POST",
                data:{
                    id: document.getElementById('idEdit').value,
                    _token: document.getElementsByTagName("meta")[3].content
                }
            });
            setTimeout(function() {
                window.location.href = "/pelaporan-kecelakaan/laporan-kecelakaan-kerja";
            }, 200);
        }
    </script>
@endsection

