
@extends('layouts.main')

@section('body')
    @include('layouts.cardOpen')
        @if(isset($errorMessage))
            <div class="alert-danger mt-1 p-2">{{ $errorMessage }}</div>
        @endif

        <div class="row mt-2 mb-3">
          <div class="col-6">
            <div class="col">
              <h5 class="card-title">Penjaminan Mutu</h5>
            </div>
          </div>
          @if(Auth::user()->role_id == 7)
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
                                <th>Tanggal audit</th>
                                <th>Dokumen audit</th>
                                <th>Editor</th>
                                @if(Auth::user()->role_id == 1)
                                <th>Validate</th>
                                @endif
                                <th>Validator</th>
                                @if(Auth::user()->role_id == 7)
                                <th>Edit</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody class="tbody">
                            <?php foreach($datas as $i=>$data){?>
                            <tr>
                                <td>{{$i+1}}</td>
                                <td>{{date("d M Y", strtotime($data->tanggal_audit))}}</td>
                                <td><button class="btn btn-primary" onclick="window.open('{{$data->dokumen_audit}}','_blank')">Lihat Dokumen</button></td>
                                <td>{{$data->editor()->name}}</td>
                                @if(Auth::user()->role_id == 1)
                                <td>
                                    @if(!$data->validator()) <form method="POST" action="/rekam-medis/penjaminan-mutu/validate">@csrf @endif
                                        <input type="hidden" name="id" value="{{$data->id}}">
                                        <button class="btn btn-success" {{$data->validator() ? 'disabled' : 'type="submit"'}}>Validasi</button>
                                    @if(!$data->validator()) </form> @endif
                                </td>
                                @endif
                                <td>{{$data->validator() ? $data->validator()->name : '-'}}</td>
                                @if(Auth::user()->role_id == 7)
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
                                <label for="tanggal_audit" class="form-label">Tanggal audit</label>
                                <input type="date" class="form-control" id="tanggal_audit" name="tanggal_audit" required>
                            </div>
                            <div class="mb-3">
                                <label for="dokumen_audit" class="form-label">Dokumen audit</label>
                                <input type="file" class="form-control" id="dokumen_audit" name="dokumen_audit" required>
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
                    <form action="/rekam-medis/penjaminan-mutu/edit" method="POST" enctype="multipart/form-data">@csrf
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Data</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" id="idEdit" name="id">
                            <div class="mb-3">
                                <label for="tanggal_auditEdit" class="form-label">Tanggal audit</label>
                                <input type="date" class="form-control" id="tanggal_auditEdit" name="tanggal_audit">
                            </div>
                            <div class="mb-3">
                                <label for="dokumen_auditEdit" class="form-label">Dokumen audit</label>
                                <input type="file" class="form-control" id="dokumen_auditEdit" name="dokumen_audit">
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
                const datee = new Date(res.tanggal_audit);
                var day = ("0" + datee.getDate()).slice(-2);
                var month = ("0" + (datee.getMonth() + 1)).slice(-2);
                var today = datee.getFullYear()+"-"+(month)+"-"+(day);
                document.getElementById('idEdit').value=res.id;
                document.getElementById('tanggal_auditEdit').value= today;
            }
            xhttp.open("GET", "/api/rekam-medis/penjaminan-mutu/get?id="+id, true);
            xhttp.send();
        }
        function del(){
            $.ajax({
                url: "/rekam-medis/penjaminan-mutu/delete",
                type:"POST",
                data:{
                    id: document.getElementById('idEdit').value,
                    _token: document.getElementsByTagName("meta")[3].content
                }
            });
            setTimeout(function() {
                window.location.href = "/rekam-medis/penjaminan-mutu";
            }, 200);
        }
    </script>
@endsection
