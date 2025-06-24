@extends('layouts.main')

@section('body')
    @include('layouts.cardOpen')
        @if(isset($errorMessage))
            <div class="alert-danger mt-1 p-2">{{ $errorMessage }}</div>
        @endif

        <div class="row mt-2 mb-3">
          <div class="col-6">
            <div class="col">
              <h5 class="card-title">Pasien</h5>
            </div>
          </div>
          <div class="col-6 d-flex justify-content-end h-50">
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createModal">Tambahkan Data</button>
          </div>
        </div>

        <div style="max-height: 100vh; overflow-y:auto;">
            <div class="card-text me-3">
                  <div style="max-height: 68vh; overflow-y:auto;">
                    <div class="card-text me-3">

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
                                <th>Tanggal Registrasi</th>
                                <th>Edit</th>
                            </tr>
                        </thead>
                        <tbody class="tbody">
                            <?php foreach($pasiens as $i=>$pasien){?>
                            <tr>
                                <td>{{$i+1}}</td>
                                <td>{{$pasien->nip}}</td>
                                <td>{{$pasien->nama}}</td>
                                <td>{{date("d M Y", strtotime($pasien->tanggal_lahir))}}</td>
                                <td>{{$pasien->umur()}}</td>
                                <td>{{$pasien->jenis_kelamin}}</td>
                                <td>{{$pasien->bagian}}</td>
                                <td>{{date("d M Y", strtotime($pasien->tanggal_registrasi))}}</td>
                                <td><button class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#editModal" onclick="changeModal({{$pasien->id}})">Edit</button></td>
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
                    <form method="POST">@csrf
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Tambahkan User</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
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
                    <form action="/pasien/edit" method="POST">@csrf
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Pasien</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" id="idEdit" name="id">
                            <div class="mb-3">
                                <label for="nipEdit" class="form-label">NIP</label>
                                <input type="number" class="form-control" id="nipEdit" name="nip">
                            </div>
                            <div class="mb-3">
                                <label for="namaEdit" class="form-label">Nama</label>
                                <input type="text" class="form-control" id="namaEdit" name="nama">
                            </div>
                            <div class="mb-3">
                                <label for="tanggal_lahirEdit" class="form-label">Tanggal Lahir</label>
                                <input type="date" class="form-control" id="tanggal_lahirEdit" name="tanggal_lahir">
                            </div>
                            <div class="mb-3">
                                <label for="jenis_kelaminEdit" class="form-label">Jenis Kelamin</label>
                                <select class="form-select" name="jenis_kelamin" id="jenis_kelaminEdit">
                                    <option value="Laki Laki">Laki Laki</option>
                                    <option value="Perempuan">Perempuan</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="bagianEdit" class="form-label">Bagian</label>
                                <input type="text" class="form-control" id="bagianEdit" name="bagian">
                            </div>
                            <div class="mb-3">
                                <label for="tanggal_registrasiEdit" class="form-label">Tanggal Registrasi</label>
                                <input type="date" class="form-control" id="tanggal_registrasiEdit" name="tanggal_registrasi">
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

                const datee = new Date(res.tanggal_lahir);
                var day = ("0" + datee.getDate()).slice(-2);
                var month = ("0" + (datee.getMonth() + 1)).slice(-2);
                var tanggal_lahir = datee.getFullYear()+"-"+(month)+"-"+(day);

                const datee2 = new Date(res.tanggal_registrasi);
                var day2 = ("0" + datee2.getDate()).slice(-2);
                var month2 = ("0" + (datee2.getMonth() + 1)).slice(-2);
                var tanggal_registrasi = datee2.getFullYear()+"-"+(month2)+"-"+(day2);

                document.getElementById('idEdit').value=res.id;
                document.getElementById('nipEdit').value=res.nip;
                document.getElementById('namaEdit').value=res.nama;
                document.getElementById('tanggal_lahirEdit').value=tanggal_lahir;
                if(res.jenis_kelamin == "Laki Laki") document.getElementById('jenis_kelaminEdit').options[0].setAttribute('selected', true);
                else document.getElementById('jenis_kelaminEdit').options[1].setAttribute('selected', true);
                document.getElementById('bagianEdit').value=res.bagian;
                document.getElementById('tanggal_registrasiEdit').value=tanggal_registrasi;
            }
            xhttp.open("GET", "/api/pasien/get?id="+id, true);
            xhttp.send();
        }
        function del(){
            $.ajax({
                url: "/pasien/delete",
                type:"POST",
                data:{
                    id: document.getElementById('idEdit').value,
                    _token: document.getElementsByTagName("meta")[3].content
                }
            });
            setTimeout(function() {
                window.location.href = "/pasien";
            }, 200);
        }
    </script>
@endsection
