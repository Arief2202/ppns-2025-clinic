
@extends('layouts.main')

@section('body')
    @include('layouts.cardOpen')
        @if(isset($errorMessage))
            <div class="alert-danger mt-1 p-2">{{ $errorMessage }}</div>
        @endif

        <div class="row mt-2 mb-3">
          <div class="col-6">
            <div class="col">
              <h5 class="card-title">Pemusnahan Obat & BMHP</h5>
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
                                <th>Tanggal Pemusnahan</th>
                                <th>Alasan Pemusnahan</th>
                                <th>Berita Acara</th>
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
                                <td>{{$data->pengadaan()->nomor_pengadaan}}</td>
                                <td>{{date("d M Y", strtotime($data->tanggal_pemusnahan))}}</td>
                                <td>{{$data->alasan_pemusnahan}}</td>
                                <td>{{$data->berita_acara}}</td>
                                <td>{{$data->editor()->name}}</td>
                                @if(Auth::user()->role_id == 1)
                                <td>
                                    @if(!$data->validator()) <form method="POST" action="/manajemen-farmasi/pemusnahan/validate">@csrf @endif
                                        <input type="hidden" name="id" value="{{$data->id}}">
                                        <button class="btn btn-success" {{$data->validator() ? 'disabled' : 'type="submit"'}}>Validasi</button>
                                    @if(!$data->validator()) </form> @endif
                                </td>
                                @endif
                                <td>{{$data->validator() ? $data->validator()->name : '-'}}</td>
                                @if(Auth::user()->role_id == 6)
                                <td><button class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#editModal" onclick="changeModal({{$data->id}})">Edit</button></td>
                                @endif
                                <td><a class="btn btn-primary" href="/manajemen-farmasi/pemusnahan/detail?id={{$data->id}}">Detail</button></td>
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
                            <div class="">
                                <label for="pengadaan_id" class="form-label">Nomor Pengadaan</label>
                            </div>
                            <div class="mb-2">
                                <select class="selectpicker" data-live-search="true" id="pengadaan_id" name="pengadaan_id" required>
                                    <option value="">Pilih Nomor Pengadaan</option>
                                    @foreach($pengadaans as $pengadaan)
                                        <option value="{{$pengadaan->id}}">{{$pengadaan->nomor_pengadaan}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="tanggal_pemusnahan" class="form-label">Tanggal Pemusnahan</label>
                                <input type="date" class="form-control" id="tanggal_pemusnahan" name="tanggal_pemusnahan" required>
                            </div>
                            <div class="mb-3">
                                <label for="alasan_pemusnahan" class="form-label">Alasan Pemusnahan</label>
                                <input type="text" class="form-control" id="alasan_pemusnahan" name="alasan_pemusnahan" required>
                            </div>
                            <div class="mb-3">
                                <label for="berita_acara" class="form-label">Berita Acara</label>
                                <input type="text" class="form-control" id="berita_acara" name="berita_acara" required>
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
                    <form action="/manajemen-farmasi/pemusnahan/edit" method="POST" enctype="multipart/form-data">@csrf
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Data</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" id="idEdit" name="id">
                            <input type="hidden" name="from_link" value="/manajemen-farmasi/pemusnahan">
                            <div class="">
                                <label for="pengadaan_id" class="form-label">Nomor Pengadaan</label>
                            </div>
                            <div class="mb-2">
                                <select class="selectpicker" data-live-search="true" id="pengadaan_id" name="pengadaan_id">
                                    <option value="">Pilih Nomor Pengadaan</option>
                                    @foreach($pengadaans as $pengadaan)
                                        <option value="{{$pengadaan->id}}">{{$pengadaan->nomor_pengadaan}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="tanggal_pemusnahanEdit" class="form-label">Tanggal Pemusnahan</label>
                                <input type="date" class="form-control" id="tanggal_pemusnahanEdit" name="tanggal_pemusnahan">
                            </div>
                            <div class="mb-3">
                                <label for="alasan_pemusnahanEdit" class="form-label">Alasan Pemusnahan</label>
                                <input type="text" class="form-control" id="alasan_pemusnahanEdit" name="alasan_pemusnahan">
                            </div>
                            <div class="mb-3">
                                <label for="berita_acaraEdit" class="form-label">Berita Acara</label>
                                <input type="text" class="form-control" id="berita_acaraEdit" name="berita_acara">
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

        function changeModal(id){
            const xhttp = new XMLHttpRequest();
            xhttp.onload = function() {
                const res = JSON.parse(this.responseText);
                const datee = new Date(res.tanggal_pemusnahan);
                var day = ("0" + datee.getDate()).slice(-2);
                var month = ("0" + (datee.getMonth() + 1)).slice(-2);
                var today = datee.getFullYear()+"-"+(month)+"-"+(day);
                document.getElementById('idEdit').value=res.id;
                document.getElementById('tanggal_pemusnahanEdit').value= today;
                document.getElementById('alasan_pemusnahanEdit').value= res.alasan_pemusnahan;
                document.getElementById('berita_acaraEdit').value= res.berita_acara;

            }
            xhttp.open("GET", "/api/manajemen-farmasi/pemusnahan/get?id="+id, true);
            xhttp.send();
        }
        function del(){
            $.ajax({
                url: "/manajemen-farmasi/pemusnahan/delete",
                type:"POST",
                data:{
                    id: document.getElementById('idEdit').value,
                    _token: document.getElementsByTagName("meta")[3].content
                }
            });
            setTimeout(function() {
                window.location.href = "/manajemen-farmasi/pemusnahan";
            }, 200);
        }
    </script>
@endsection

