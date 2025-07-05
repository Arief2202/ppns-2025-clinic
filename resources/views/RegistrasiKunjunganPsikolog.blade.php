
@extends('layouts.main')

@section('body')
    @include('layouts.cardOpen')
        @if(isset($errorMessage))
            <div class="alert-danger mt-1 p-2">{{ $errorMessage }}</div>
        @endif

        <div class="row mt-2 mb-3">
          <div class="col-6">
            <div class="col">
              <h5 class="card-title">Registrasi Kunjungan Psikolog</h5>
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
                                <th>NIP Pasien</th>
                                <th>Nama Pasien</th>
                                <th>NIP Pemeriksa</th>
                                <th>Nama Pemeriksa</th>
                                <th>Tanggal Kunjungan</th>
                                <th>Editor</th>
                                @if(Auth::user()->role_id == 5)
                                <th>Edit</th>
                                @endif
                                <th>Detail</th>
                            </tr>
                        </thead>
                        <tbody class="tbody">
                            <?php foreach($datas as $i=>$data){?>
                            <tr>
                                <td>{{$i+1}}</td>
                                <td>{{$data->pasien()->nip}}</td>
                                <td>{{$data->pasien()->nama}}</td>
                                <td>{{$data->pemeriksa()->nip}}</td>
                                <td>{{$data->pemeriksa()->name}}</td>
                                <td>{{date("d M Y", strtotime($data->tanggal_kunjungan))}}</td>
                                <td>{{$data->editor()->name}}</td>
                                @if(Auth::user()->role_id == 5)
                                <td><button class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#editModal" onclick="changeModal({{$data->id}})">Edit</button></td>
                                @endif
                                <td><a class="btn btn-primary" href="/kesehatan-mental/registrasi-kunjungan-psikolog/detail?id={{$data->id}}">Detail</button></td>
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
                    <form method="POST" enctype="multipart/form-data">@csrf
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Tambahkan Data</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="">
                                <label for="pasien_id" class="form-label">Pasien</label>
                            </div>
                            <div class="mb-2">
                                <select class="selectpicker" data-live-search="true" id="pasien_id" name="pasien_id">
                                    <option value="">Pilih Pasien</option>
                                    <option value="" id="addNewItem">Tambah Pasien Baru</option>
                                    @foreach($pasiens as $pasien)
                                        <option value="{{$pasien->id}}">[{{$pasien->nip}}] {{$pasien->nama}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div id="addNewItemDiv"></div>
                            <div class="">
                                <label for="pemeriksa_id" class="form-label">Pemeriksa</label>
                            </div>
                            <div class="mb-2">
                                <select class="selectpicker" data-live-search="true" id="pemeriksa_id" name="pemeriksa_id">
                                    <option value="">Pilih Pemeriksa</option>
                                    @foreach($pemeriksas as $pemeriksa)
                                        <option value="{{$pemeriksa->id}}">[{{$pemeriksa->nip}}] {{$pemeriksa->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="tanggal_kunjungan" class="form-label">Tanggal Kunjungan</label>
                                <input type="date" class="form-control" id="tanggal_kunjungan" name="tanggal_kunjungan" required>
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

        <div style="display: none" id="templateAddNewItem">
            <div class="mb-3">
                <label for="nip" class="form-label">NIP</label>
                <input type="number" class="form-control" id="nip" name="nip" required>
            </div>
            <div class="mb-3">
                <label for="nama" class="form-label">Nama</label>
                <input type="text" class="form-control" id="nama" name="nama" required>
            </div>
            <div class="mb-3">
                <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
                <input type="date" class="form-control" id="tanggal_lahir" name="tanggal_lahir" required>
            </div>
            <div class="mb-3">
                <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                <select class="form-select" name="jenis_kelamin" id="jenis_kelamin">
                    <option value="Laki Laki">Laki Laki</option>
                    <option value="Perempuan">Perempuan</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="bagian" class="form-label">Bagian</label>
                <input type="text" class="form-control" id="bagian" name="bagian" required>
            </div>
            <div class="mb-3">
                <label for="tanggal_registrasi" class="form-label">Tanggal Registrasi</label>
                <input type="date" class="form-control" id="tanggal_registrasi" name="tanggal_registrasi" required>
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
            $('#pasien_id').change(function(){
                if(this.options[this.selectedIndex].text == "Tambah Pasien Baru"){
                    document.getElementById('addNewItemDiv').innerHTML = document.getElementById('templateAddNewItem').innerHTML;
                }
                else{
                    document.getElementById('addNewItemDiv').innerHTML = null;
                }
            })
        });


        function changeModal(id){
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
            var status = $.ajax({
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

