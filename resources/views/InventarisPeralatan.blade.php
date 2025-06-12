@extends('layouts.main')

@section('body')
    @include('layouts.cardOpen')
        @if(isset($errorMessage))
            <div class="alert-danger mt-1 p-2">{{ $errorMessage }}</div>
        @endif

        <div class="row mt-2 mb-3">
          <div class="col-6">
            <div class="col">
              <h5 class="card-title">Inventaris Peralatan</h5>
            </div>
          </div>
          @if(Auth::user()->role_id == 1 || Auth::user()->role_id == 2)
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
                                <th>Nama</th>
                                <th>Kategori Peralatan</th>
                                <th>Jumlah</th>
                                <th>Kondisi</th>
                                <th>Tanggal Inspeksi</th>
                                <th>Dokumen Inspeksi</th>
                                <th>Tanggal Kalibrasi</th>
                                <th>Dokumen Kalibrasi</th>
                                <th>Editor</th>
                                @if(Auth::user()->role_id == 1)
                                <th>Validate</th>
                                @endif
                                <th>Validator</th>
                                @if(Auth::user()->role_id == 1 || Auth::user()->role_id == 2)
                                <th>Edit</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody class="tbody">
                            <?php foreach($datas as $i=>$data){?>
                            <tr>
                                <td>{{$i+1}}</td>
                                <td>{{$data->nama}}</td>
                                <td>{{$data->kategori_peralatan}}</td>
                                <td>{{$data->jumlah}}</td>
                                <td>{{$data->kondisi}}</td>
                                <td>{{date("d M Y", strtotime($data->tanggal_inspeksi))}}</td>
                                <td><button class="btn btn-primary" onclick="window.open('{{$data->dokumen_inspeksi}}','_blank')">Lihat Dokumen</button></td>
                                <td>{{date("d M Y", strtotime($data->tanggal_kalibrasi))}}</td>
                                <td><button class="btn btn-primary" onclick="window.open('{{$data->dokumen_kalibrasi}}','_blank')">Lihat Dokumen</button></td>
                                <td>{{$data->editor()->name}}</td>
                                @if(Auth::user()->role_id == 1)
                                <td>
                                    @if(!$data->validator()) <form method="POST" action="/sarana-prasarana/inventaris-peralatan/validate">@csrf @endif
                                        <input type="hidden" name="id" value="{{$data->id}}">
                                        <button class="btn btn-success" {{$data->validator() ? 'disabled' : 'type="submit"'}}>Validasi</button>
                                    @if(!$data->validator()) </form> @endif
                                </td>
                                @endif
                                <td>{{$data->validator() ? $data->validator()->name : '-'}}</td>
                                @if(Auth::user()->role_id == 1 || Auth::user()->role_id == 2)
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
                                <label for="nama" class="form-label">Nama</label>
                                <input type="text" class="form-control" id="nama" name="nama" required>
                            </div>
                            <div class="mb-3">
                                <label for="kategori_peralatan" class="form-label">Kategori Peralatan</label>
                                <select class="form-select" name="kategori_peralatan" id="kategori_peralatan" required>
                                    <option value="Medis">Medis</option>
                                    <option value="Non Medis">Non Medis</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="jumlah" class="form-label">Jumlah</label>
                                <input type="number" class="form-control" id="jumlah" name="jumlah" required>
                            </div>
                            <div class="mb-3">
                                <label for="kondisi" class="form-label">Kondisi</label>
                                <input type="text" class="form-control" id="kondisi" name="kondisi" required>
                            </div>
                            <div class="mb-3">
                                <label for="tanggal_inspeksi" class="form-label">Tanggal Inspeksi</label>
                                <input type="date" class="form-control" id="tanggal_inspeksi" name="tanggal_inspeksi" required>
                            </div>
                            <div class="mb-3">
                                <label for="dokumen_inspeksi" class="form-label">Dokumen Inspeksi</label>
                                <input type="file" class="form-control" id="dokumen_inspeksi" name="dokumen_inspeksi" required>
                            </div>
                            <div class="mb-3">
                                <label for="tanggal_kalibrasi" class="form-label">Tanggal Kalibrasi</label>
                                <input type="date" class="form-control" id="tanggal_kalibrasi" name="tanggal_kalibrasi" required>
                            </div>
                            <div class="mb-3">
                                <label for="dokumen_kalibrasi" class="form-label">Dokumen Kalibrasi</label>
                                <input type="file" class="form-control" id="dokumen_kalibrasi" name="dokumen_kalibrasi" required>
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
                    <form action="/sarana-prasarana/inventaris-peralatan/edit" method="POST" enctype="multipart/form-data">@csrf
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Edit User</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" id="idEdit" name="id">
                            <div class="mb-3">
                                <label for="namaEdit" class="form-label">nama</label>
                                <input type="text" class="form-control" id="namaEdit" name="nama">
                            </div>
                            <div class="mb-3">
                                <label for="kategori_peralatanEdit" class="form-label">Kategori Peralatan</label>
                                <select class="form-select" name="kategori_peralatan" id="kategori_peralatanEdit">
                                    <option value="Medis">Medis</option>
                                    <option value="Non Medis">Non Medis</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="jumlahEdit" class="form-label">jumlah</label>
                                <input type="number" class="form-control" id="jumlahEdit" name="jumlah">
                            </div>
                            <div class="mb-3">
                                <label for="kondisiEdit" class="form-label">kondisi</label>
                                <input type="text" class="form-control" id="kondisiEdit" name="kondisi">
                            </div>
                            <div class="mb-3">
                                <label for="tanggal_inspeksiEdit" class="form-label">Tanggal Inspeksi</label>
                                <input type="date" class="form-control" id="tanggal_inspeksiEdit" name="tanggal_inspeksi">
                            </div>
                            <div class="mb-3">
                                <label for="dokumen_inspeksiEdit" class="form-label">Dokumen Inspeksi</label>
                                <input type="file" class="form-control" id="dokumen_inspeksiEdit" name="dokumen_inspeksi">
                            </div>
                            <div class="mb-3">
                                <label for="tanggal_kalibrasiEdit" class="form-label">Tanggal Kalibrasi</label>
                                <input type="date" class="form-control" id="tanggal_kalibrasiEdit" name="tanggal_kalibrasi">
                            </div>
                            <div class="mb-3">
                                <label for="dokumen_kalibrasiEdit" class="form-label">Dokumen Kalibrasi</label>
                                <input type="file" class="form-control" id="dokumen_kalibrasiEdit" name="dokumen_kalibrasi">
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
                const datee = new Date(res.tanggal_inspeksi);
                var day = ("0" + datee.getDate()).slice(-2);
                var month = ("0" + (datee.getMonth() + 1)).slice(-2);
                var today = datee.getFullYear()+"-"+(month)+"-"+(day);
                const datee2 = new Date(res.tanggal_kalibrasi);
                var day2 = ("0" + datee.getDate()).slice(-2);
                var month2 = ("0" + (datee.getMonth() + 1)).slice(-2);
                var today2 = datee.getFullYear()+"-"+(month)+"-"+(day);
                document.getElementById('idEdit').value=res.id;
                document.getElementById('namaEdit').value=res.nama;

                if(res.kategori_peralatan == "Medis") document.getElementById('kategori_peralatanEdit').options[0].setAttribute('selected', true);
                else document.getElementById('kategori_peralatanEdit').options[1].setAttribute('selected', true);

                document.getElementById('jumlahEdit').value=res.jumlah;
                document.getElementById('kondisiEdit').value=res.kondisi;
                document.getElementById('tanggal_inspeksiEdit').value= today;
                document.getElementById('tanggal_kalibrasiEdit').value= today2;
            }
            xhttp.open("GET", "/api/sarana-prasarana/inventaris-peralatan?id="+id, true);
            xhttp.send();
        }
        function del(){
            $.ajax({
                url: "/sarana-prasarana/inventaris-peralatan/delete",
                type:"POST",
                data:{
                    id: document.getElementById('idEdit').value,
                    _token: document.getElementsByTagName("meta")[3].content
                }
            });
            setTimeout(function() {
                window.location.href = "/sarana-prasarana/inventaris-peralatan";
            }, 200);
        }
    </script>
@endsection
