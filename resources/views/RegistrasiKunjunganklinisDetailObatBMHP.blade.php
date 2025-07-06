
@extends('layouts.main')

@section('body')
    @include('layouts.cardOpen')
        @if(isset($errorMessage))
            <div class="alert-danger mt-1 p-2">{{ $errorMessage }}</div>
        @endif
        <div class="row mt-2 mb-2">
          <div class="col-6">
            <div class="col">
              <h5 class="card-title">Detail Kunjungan Klinis Penggunaan Obat BMHP</h5>
            </div>
          </div>
          @if(Auth::user()->role_id == 1 || Auth::user()->role_id == 2)
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
                            <div class="col-2">
                                <div class="mb-2">
                                    <label for="nip_pasien" class="form-label">NIP Pasien</label>
                                    <input type="text" class="form-control" id="nip_pasien" value="{{$data->registrasi()->pasien()->nip}}" disabled>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="mb-2">
                                    <label for="nama_pasien" class="form-label">Nama Pasien</label>
                                    <input type="text" class="form-control" id="nama_pasien" value="{{$data->registrasi()->pasien()->nama}}" disabled>
                                </div>
                            </div>
                            <div class="col-2">
                                <div class="mb-2">
                                    <label for="nip_pemeriksa" class="form-label">NIP Pemeriksa</label>
                                    <input type="text" class="form-control" id="nip_ppemeriksa" value="{{$data->registrasi()->pemeriksa()->nip}}" disabled>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="mb-2">
                                    <label for="nama_pemeriksa" class="form-label">Nama Pemeriksa</label>
                                    <input type="text" class="form-control" id="nama_pemeriksa" value="{{$data->registrasi()->pemeriksa()->name}}" disabled>
                                </div>
                            </div>
                            <div class="col-2">
                                <div class="mb-2">
                                    <label for="tanggal_kunjungan" class="form-label">Tanggal Kunjungan</label>
                                    <input type="text" class="form-control" id="tanggal_kunjungan" value="{{date("d M Y", strtotime($data->registrasi()->tanggal_kunjungan))}}" disabled>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <h5>Rekam Medis Klinis</h5>
                        <div class="row">
                            <div class="col-2">
                                <div class="mb-2">
                                    <label for="editor" class="form-label">Kode Icd</label>
                                    <input type="text" class="form-control" id="editor" value="{{$data->kode_icd}}" disabled>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="mb-2">
                                    <label for="editor" class="form-label">Gejala</label>
                                    <input type="text" class="form-control" id="editor" value="{{$data->gejala}}" disabled>
                                </div>
                            </div>
                            <div class="col-2">
                                <div class="mb-2">
                                    <label for="editor" class="form-label">Diagnosis</label>
                                    <input type="text" class="form-control" id="editor" value="{{$data->diagnosis}}" disabled>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="mb-2">
                                    <label for="editor" class="form-label">Tindakan Medis</label>
                                    <input type="text" class="form-control" id="editor" value="{{$data->tindakan_medis}}" disabled>
                                </div>
                            </div>
                            <div class="col-2">
                                <div class="mb-2">
                                    <label for="editor" class="form-label">Dokumentasi Resep</label>
                                    <button class="btn btn-secondary w-100" onclick="window.open('{{$data->dokumentasi_resep}}','_blank')">Lihat Dokumen</button>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-6">
                                <h5>Penggunaan Obat BMHP</h5>
                            </div>
                            <div class="col-6">
                                @if(Auth::user()->role_id == 1 || Auth::user()->role_id == 2)
                                    <div class="d-flex justify-content-end w-100 mb-2">
                                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createModal">Tambahkan Obat / BMHP</button>
                                    </div>
                                @endif
                            </div>
                        </div>
                        <table id="myTable">
                            <thead class="thead">
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>Satuan</th>
                                    <th>Tempat Penyimpanan</th>
                                    <th>Jumlah</th>
                                    @if(Auth::user()->role_id == 1 || Auth::user()->role_id == 2)
                                    <th>Delete</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody class="tbody">
                                <?php foreach($data->penggunaanObatBMHP() as $i=>$item){?>
                                <tr>
                                    <td>{{$i+1}}</td>
                                    <td>{{$item->obatBMHP()->nama}}</td>
                                    <td>{{$item->obatBMHP()->satuan}}</td>
                                    <td>{{$item->obatBMHP()->tempat_penyimpanan}}</td>
                                    <td>{{$item->jumlah}}</td>
                                    @if(Auth::user()->role_id == 1 || Auth::user()->role_id == 2)
                                    <form method="POST" action="/rekam-medis/registrasi-kunjungan-klinis/detail/obat-bmhp/delete">@csrf
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

        @if(Auth::user()->role_id == 1 || Auth::user()->role_id == 2)
        <div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModal" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form action="/rekam-medis/registrasi-kunjungan-klinis/detail/obat-bmhp/create" method="POST" enctype="multipart/form-data">@csrf
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Tambahkan Obat / BMHP</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" id="rekam_medis_klinis_id" name="rekam_medis_klinis_id" value="{{$data->id}}">
                            <div class="">
                                <label for="obat_bmhp_id" class="form-label">Obat / BMHP</label>
                            </div>
                            <div class="mb-2">
                                <select class="selectpicker" data-live-search="true" id="obat_bmhp_id" name="obat_bmhp_id" required>
                                    <option value="">Pilih Obat / BMHP</option>
                                    <option value="" id="addNewItem">Tambah Obat / BMHP Baru</option>
                                    @foreach($obatbmhps as $obatbmhp)
                                    <option value="{{$obatbmhp->id}}">[{{$obatbmhp->kategori}}] {{$obatbmhp->nama}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div id="addNewItemDiv"></div>
                            <div class="mb-2">
                                <label for="jumlah" class="form-label">Jumlah</label>
                                <input type="text" class="form-control" id="jumlah" name="jumlah" required>
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

        <div style="display: none" id="templateAddNewItem">
            <div class="mb-3">
                <label for="nama" class="form-label">Nama</label>
                <input type="text" class="form-control" id="nama" name="nama" required>
            </div>
            <div class="mb-3">
                <label for="satuan" class="form-label">Satuan</label>
                <input type="text" class="form-control" id="satuan" name="satuan" required>
            </div>
            <div class="mb-2">
                <label for="kategori" class="form-label">Kategori</label>
                <select class="form-select" name="kategori" id="kategori" required>
                    <option value="Obat">Obat</option>
                    <option value="BMHP">BMHP</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="tempat_penyimpanan" class="form-label">Tempat Penyimpanan</label>
                <input type="text" class="form-control" id="tempat_penyimpanan" name="tempat_penyimpanan" required>
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
            $('#obat_bmhp_id').change(function(){
                if(this.options[this.selectedIndex].text == "Tambah Obat / BMHP Baru"){
                    document.getElementById('addNewItemDiv').innerHTML = document.getElementById('templateAddNewItem').innerHTML;
                }
                else{
                    document.getElementById('addNewItemDiv').innerHTML = null;
                }
            })
        });
        // function changeEditModal(id){
        //     const xhttp = new XMLHttpRequest();
        //     xhttp.onload = function() {
        //         const res = JSON.parse(this.responseText);
        //         const datee = new Date(res.tanggal_kunjungan);
        //         var day = ("0" + datee.getDate()).slice(-2);
        //         var month = ("0" + (datee.getMonth() + 1)).slice(-2);
        //         var today = datee.getFullYear()+"-"+(month)+"-"+(day);


        //         document.getElementById('idEdit').value=res.id;
        //         document.getElementById('tanggal_kunjunganEdit').value=today;

        //         $('#pasien_idEdit').selectpicker('val', res.pasien_id.toString());
        //         $('#pemeriksa_idEdit').selectpicker('val', res.pemeriksa_id.toString());
        //     }
        //     xhttp.open("GET", "/api/rekam-medis/registrasi-kunjungan-klinis/get?id="+id, true);
        //     xhttp.send();
        // }
        // function del(){
        //     $.ajax({
        //         url: "/rekam-medis/registrasi-kunjungan-klinis/detail/obat-bmhp/delete",
        //         type:"POST",
        //         data:{
        //             id: document.getElementById('idEdit').value,
        //             _token: document.getElementsByTagName("meta")[3].content
        //         }
        //     });
        //     setTimeout(function() {
        //         window.location.href = "/rekam-medis/registrasi-kunjungan-klinis";
        //     }, 200);
        // }
    </script>
@endsection

