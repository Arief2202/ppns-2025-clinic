
@extends('layouts.main')

@section('body')
    @include('layouts.cardOpen')
        @if(isset($errorMessage))
            <div class="alert-danger mt-1 p-2">{{ $errorMessage }}</div>
        @endif

        <div class="row mt-2 mb-3">
          <div class="col-6">
            <div class="col">
              <h5 class="card-title">Rencana Pemeriksaan Kesehatan</h5>
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
                                <th>Jenis Pemeriksaan</th>
                                <th>Tanggal Pelaksanaan</th>
                                <th>Jumlah Peserta</th>
                                <th>Editor</th>
                                @if(Auth::user()->role_id == 3)
                                <th>Validate</th>
                                @endif
                                <th>Validator</th>
                                @if(Auth::user()->role_id == 1 || Auth::user()->role_id == 3)
                                <th>Edit</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody class="tbody">
                            <?php foreach($datas as $i=>$data){?>
                            <tr>
                                <td>{{$i+1}}</td>
                                <td>{{$data->jenis_pemeriksaan}}</td>
                                <td>{{date("d M Y", strtotime($data->tanggal_pelaksanaan))}}</td>
                                <td>{{$data->jumlah_peserta}}</td>
                                <td>{{$data->editor()->name}}</td>
                                @if(Auth::user()->role_id == 3)
                                <td>
                                    @if(!$data->validator()) <form method="POST" action="/smk3/pemeriksaan-kesehatan-pekerja/rencana-pemeriksaan-kesehatan/validate">@csrf @endif
                                        <input type="hidden" name="id" value="{{$data->id}}">
                                        <button class="btn btn-success" {{$data->validator() ? 'disabled' : 'type="submit"'}}>Validasi</button>
                                    @if(!$data->validator()) </form> @endif
                                </td>
                                @endif
                                <td>{{$data->validator() ? $data->validator()->name : '-'}}</td>
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
                                <label for="jenis_pemeriksaan" class="form-label">Jenis Pemeriksaan</label>
                                <input type="text" class="form-control" id="jenis_pemeriksaan" name="jenis_pemeriksaan" required>
                            </div>
                            <div class="mb-3">
                                <label for="tanggal_pelaksanaan" class="form-label">Tanggal Pelaksanaan</label>
                                <input type="date" class="form-control" id="tanggal_pelaksanaan" name="tanggal_pelaksanaan" required>
                            </div>
                            <div class="mb-3">
                                <label for="jumlah_peserta" class="form-label">Jumlah Peserta</label>
                                <input type="number" class="form-control" id="jumlah_peserta" name="jumlah_peserta" required>
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
                    <form action="/smk3/pemeriksaan-kesehatan-pekerja/rencana-pemeriksaan-kesehatan/edit" method="POST" enctype="multipart/form-data">@csrf
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Data</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" id="idEdit" name="id">
                            <div class="mb-3">
                                <label for="jenis_pemeriksaanEdit" class="form-label">Jenis Pemeriksaan</label>
                                <input type="text" class="form-control" id="jenis_pemeriksaanEdit" name="jenis_pemeriksaan">
                            </div>
                            <div class="mb-3">
                                <label for="tanggal_pelaksanaanEdit" class="form-label">Tanggal Pelaksanaan</label>
                                <input type="date" class="form-control" id="tanggal_pelaksanaanEdit" name="tanggal_pelaksanaan">
                            </div>
                            <div class="mb-3">
                                <label for="jumlah_pesertaEdit" class="form-label">Jumlah Peserta</label>
                                <input type="number" class="form-control" id="jumlah_pesertaEdit" name="jumlah_peserta">
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
                const datee = new Date(res.tanggal_pelaksanaan);
                var day = ("0" + datee.getDate()).slice(-2);
                var month = ("0" + (datee.getMonth() + 1)).slice(-2);
                var today = datee.getFullYear()+"-"+(month)+"-"+(day);
                document.getElementById('idEdit').value=res.id;
                document.getElementById('jenis_pemeriksaanEdit').value=res.jenis_pemeriksaan;
                document.getElementById('tanggal_pelaksanaanEdit').value= today;
                document.getElementById('jumlah_pesertaEdit').value=res.jumlah_peserta;
            }
            xhttp.open("GET", "/api/smk3/pemeriksaan-kesehatan-pekerja/rencana-pemeriksaan-kesehatan/get?id="+id, true);
            xhttp.send();
        }
        function del(){
            $.ajax({
                url: "/smk3/pemeriksaan-kesehatan-pekerja/rencana-pemeriksaan-kesehatan/delete",
                type:"POST",
                data:{
                    id: document.getElementById('idEdit').value,
                    _token: document.getElementsByTagName("meta")[3].content
                }
            });
            setTimeout(function() {
                window.location.href = "/smk3/pemeriksaan-kesehatan-pekerja/rencana-pemeriksaan-kesehatan";
            }, 200);
        }
    </script>
@endsection

