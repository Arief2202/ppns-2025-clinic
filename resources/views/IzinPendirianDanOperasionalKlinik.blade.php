@extends('layouts.main')

@section('body')
    @include('layouts.cardOpen')
        @if(isset($errorMessage))
            <div class="alert-danger mt-1 p-2">{{ $errorMessage }}</div>
        @endif

        <div class="row mt-2 mb-3">
          <div class="col-6">
            <div class="col">
              <h5 class="card-title">Izin Pendirian Dan Operasional Klinik</h5>
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
                                <th>Kondisi</th>
                                <th>Tanggal Inspeksi</th>
                                <th>Dokumen Inspeksi</th>
                                <th>Editor</th>
                                @if(Auth::user()->role_id == 4)
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
                                <td>{{$data->judul_surat}}</td>
                                <td>{{date("d M Y", strtotime($data->tanggal_terbit))}}</td>
                                <td>{{date("d M Y", strtotime($data->berlaku_hingga))}}</td>
                                <td><button class="btn btn-primary" onclick="window.open('{{$data->dokumen_surat}}','_blank')">Lihat Dokumen</button></td>
                                <td>{{$data->editor()->name}}</td>
                                @if(Auth::user()->role_id == 4)
                                <td>
                                    @if(!$data->validator()) <form method="POST" action="/sarana-prasarana/izin-pendirian-dan-operasional-klinik/validate">@csrf @endif
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
                                <label for="judul_surat" class="form-label">Judul Surat</label>
                                <input type="text" class="form-control" id="judul_surat" name="judul_surat" required>
                            </div>
                            <div class="mb-3">
                                <label for="tanggal_terbit" class="form-label">Tanggal Terbit</label>
                                <input type="date" class="form-control" id="tanggal_terbit" name="tanggal_terbit" required>
                            </div>
                            <div class="mb-3">
                                <label for="berlaku_hingga" class="form-label">Berlaku Hingga</label>
                                <input type="date" class="form-control" id="berlaku_hingga" name="berlaku_hingga" required>
                            </div>
                            <div class="mb-3">
                                <label for="dokumen_surat" class="form-label">Dokumen Surat</label>
                                <input type="file" class="form-control" id="dokumen_surat" name="dokumen_surat" required>
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
                    <form action="/sarana-prasarana/izin-pendirian-dan-operasional-klinik/edit" method="POST" enctype="multipart/form-data">@csrf
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Data</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" id="idEdit" name="id">
                            <div class="mb-3">
                                <label for="judul_suratEdit" class="form-label">Judul Surat</label>
                                <input type="text" class="form-control" id="judul_suratEdit" name="judul_surat">
                            </div>
                            <div class="mb-3">
                                <label for="tanggal_terbitEdit" class="form-label">Tanggal Terbit</label>
                                <input type="date" class="form-control" id="tanggal_terbitEdit" name="tanggal_terbit">
                            </div>
                            <div class="mb-3">
                                <label for="berlaku_hinggaEdit" class="form-label">Berlaku Hingga</label>
                                <input type="date" class="form-control" id="berlaku_hinggaEdit" name="berlaku_hingga">
                            </div>
                            <div class="mb-3">
                                <label for="dokumen_suratEdit" class="form-label">Dokumen Surat</label>
                                <input type="file" class="form-control" id="dokumen_suratEdit" name="dokumen_surat">
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
                const datee = new Date(res.tanggal_terbit);
                var day = ("0" + datee.getDate()).slice(-2);
                var month = ("0" + (datee.getMonth() + 1)).slice(-2);
                var today = datee.getFullYear()+"-"+(month)+"-"+(day);
                const datee2 = new Date(res.berlaku_hingga);
                var day2 = ("0" + datee2.getDate()).slice(-2);
                var month2 = ("0" + (datee2.getMonth() + 1)).slice(-2);
                var today2 = datee2.getFullYear()+"-"+(month2)+"-"+(day2);
                document.getElementById('idEdit').value=res.id;
                document.getElementById('judul_suratEdit').value=res.judul_surat;
                document.getElementById('tanggal_terbitEdit').value=today;
                document.getElementById('berlaku_hinggaEdit').value=today2;
            }
            xhttp.open("GET", "/api/sarana-prasarana/izin-pendirian-dan-operasional-klinik?id="+id, true);
            xhttp.send();
        }
        function del(){
            $.ajax({
                url: "/sarana-prasarana/izin-pendirian-dan-operasional-klinik/delete",
                type:"POST",
                data:{
                    id: document.getElementById('idEdit').value,
                    _token: document.getElementsByTagName("meta")[3].content
                }
            });
            setTimeout(function() {
                window.location.href = "/sarana-prasarana/izin-pendirian-dan-operasional-klinik";
            }, 200);
        }
    </script>
@endsection
