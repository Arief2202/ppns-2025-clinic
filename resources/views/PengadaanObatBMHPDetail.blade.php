
@extends('layouts.main')

@section('body')
    @include('layouts.cardOpen')
        @if(isset($errorMessage))
            <div class="alert-danger mt-1 p-2">{{ $errorMessage }}</div>
        @endif
        <div class="row mt-2 mb-2">
          <div class="col-6">
            <div class="col">
              <h5 class="card-title">Detail Pengadaan Obat & BMHP</h5>
            </div>
          </div>
          @if(Auth::user()->role_id == 6)
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
                                    <label for="nomor_pengadaan" class="form-label">Nomor Pengadaan</label>
                                    <input type="text" class="form-control" id="nomor_pengadaan" value="{{$data->nomor_pengadaan}}" disabled>
                                </div>
                                <div class="mb-2">
                                    <label for="tanggal_pengadaan" class="form-label">Tanggal Pengadaan</label>
                                    <input type="text" class="form-control" id="tanggal_pengadaan" value="{{date("d M Y", strtotime($data->tanggal_pengadaan))}}" disabled>
                                </div>
                                <div class="mb-2">
                                    <label for="catatan" class="form-label">Catatan</label>
                                    <input type="text" class="form-control" id="catatan" value="{{$data->catatan}}" disabled>
                                </div>
                                <div class="mb-2">
                                    <label for="status" class="form-label">Status</label>
                                    <input type="text" class="form-control" id="status" value="{{$data->status}}" disabled>
                                </div>

                            </div>
                            <div class="col-6">
                                <div class="mb-2">
                                    <label for="dokumen_pengadaan" class="form-label">Dokumen Pengadaan</label><br>
                                    <button class="btn btn-secondary w-100" id="dokumen_pengadaan" onclick="window.open('{{$data->dokumen_pengadaan}}','_blank')">Lihat Dokumen</button>
                                </div>
                                <div class="mb-2">
                                    <label for="editor" class="form-label">Editor</label>
                                    <input type="text" class="form-control" id="editor" value="{{$data->editorPengadaan()->name}}" disabled>
                                </div>
                                <div class="mb-2">
                                        @if(Auth::user()->role_id == 1)
                                        <div class="row">
                                            <div class="col-3">
                                                <label for="validator" class="form-label">Validate</label>
                                                @if(!$data->validatorPengadaan()) <form method="POST" action="/manajemen-farmasi/pengadaan/validate">@csrf @endif
                                                    <input type="hidden" name="id" value="{{$data->id}}">
                                                    <button class="btn btn-success w-100" {{$data->validatorPengadaan() ? 'disabled' : 'type="submit"'}}>Validasi</button>
                                                @if(!$data->validatorPengadaan()) </form> @endif
                                            </div>
                                            <div class="col-9">
                                        @endif
                                                <label for="validator" class="form-label">Validator</label>
                                                <input type="text" class="form-control" id="validator" value="{{$data->validatorPengadaan() ? $data->validatorPengadaan()->name : '-'}}" disabled>

                                        @if(Auth::user()->role_id == 1)
                                            </div>
                                        </div>
                                        @endif

                                </div>
                            </div>
                        </div>
                        <hr>
                        @if(Auth::user()->role_id == 6)
                            <div class="d-flex justify-content-end w-100 mb-2">
                                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createModal">Tambahkan Obat / BMHP</button>
                            </div>
                        @endif

                      <table id="myTable">
                        <thead class="thead">
                            <tr>
                                <th>No</th>
                                <th>Kategori</th>
                                <th>Nama</th>
                                <th>Jumlah</th>
                                <th>Satuan</th>
                                <th>Tempat Penyimpanan</th>
                                <th>Tanggal Kadaluarsa</th>
                                <th>Status</th>
                                @if(Auth::user()->role_id == 6)
                                <th>Delete</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody class="tbody">
                            <?php foreach($data->items() as $i=>$item){?>
                            <tr>
                                <td>{{$i+1}}</td>
                                <td>{{$item->obatBMHP()->kategori}}</td>
                                <td>{{$item->obatBMHP()->nama}}</td>
                                <td>{{$item->jumlah}}</td>
                                <td>{{$item->obatBMHP()->satuan}}</td>
                                <td>{{$item->obatBMHP()->tempat_penyimpanan}}</td>
                                <td>{{date("d M Y", strtotime($item->tanggal_kadaluarsa))}}</td>
                                <td>{{$item->status}}</td>
                                @if(Auth::user()->role_id == 6)
                                <td>
                                    <form method="POST" action="/manajemen-farmasi/pengadaan/detail/delete">@csrf
                                        <input type="hidden" name="id" value="{{$item->id}}">
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
                    <form action="/manajemen-farmasi/pengadaan/detail/add" method="POST" enctype="multipart/form-data">@csrf
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Tambahkan Obat / BMHP</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" id="pengadaan_id" name="pengadaan_id" value="{{$data->id}}">
                            <div class="">
                                <label for="obat_bmhp_id" class="form-label">Obat / BMHP</label>
                            </div>
                            <div class="mb-2">
                                <select class="selectpicker" data-live-search="true" id="obat_bmhp_id" name="obat_bmhp_id" required>
                                    <option value="">Pilih Obat / BMHP</option>
                                    <option value="" id="addNewItem">Tambah Obat / BMHP Baru</option>
                                    @foreach($items as $item)
                                    <option value="{{$item->id}}">[{{$item->kategori}}] {{$item->nama}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div id="addNewItemDiv"></div>
                            <div class="mb-2">
                                <label for="jumlah" class="form-label">Jumlah</label>
                                <input type="text" class="form-control" id="jumlah" name="jumlah" required>
                            </div>
                            <div class="mb-2">
                                <label for="tanggal_kadaluarsa" class="form-label">Tanggal Kadaluarsa</label>
                                <input type="date" class="form-control" id="tanggal_kadaluarsa" name="tanggal_kadaluarsa" required>
                            </div>
                            <div class="mb-2">
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
                            <input type="hidden" id="idEdit" name="id" value="{{$data->id}}">
                            <input type="hidden" name="from_link" value="/manajemen-farmasi/pengadaan/detail?id={{$data->id}}">
                            <div class="mb-3">
                                <label for="tanggal_pengadaanEdit" class="form-label">Tanggal Pengadaan</label>
                                <input type="date" class="form-control" id="tanggal_pengadaanEdit" name="tanggal_pengadaan" value="{{date("Y-m-d", strtotime($data->tanggal_pengadaan))}}">
                            </div>
                            <div class="mb-3">
                                <label for="dokumen_pengadaanEdit" class="form-label">Dokumen Pengadaan</label>
                                <input type="file" class="form-control" id="dokumen_pengadaanEdit" name="dokumen_pengadaan">
                            </div>
                            <div class="mb-3">
                                <label for="catatanEdit" class="form-label">Catatan</label>
                                <input type="text" class="form-control" id="catatanEdit" name="catatan" value="{{$data->catatan}}">
                            </div>
                            <div class="mb-3">
                                <label for="statusEdit" class="form-label">Status</label>
                                <input type="text" class="form-control" id="statusEdit" name="status" value="{{$data->status}}">
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
            $('#obat_bmhp_id').change(function(){
                if(this.options[this.selectedIndex].text == "Tambah Obat / BMHP Baru"){
                    document.getElementById('addNewItemDiv').innerHTML = document.getElementById('templateAddNewItem').innerHTML;
                }
                else{
                    document.getElementById('addNewItemDiv').innerHTML = null;
                }
            })
        });
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

