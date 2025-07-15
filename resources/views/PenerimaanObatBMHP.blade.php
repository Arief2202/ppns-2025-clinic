
@extends('layouts.main')

@section('body')
    @include('layouts.cardOpen')
        @if(isset($errorMessage))
            <div class="alert-danger mt-1 p-2">{{ $errorMessage }}</div>
        @endif

        <div class="row mt-2 mb-3">
          <div class="col-6">
            <div class="col">
              <h5 class="card-title">Penerimaan Obat & BMHP</h5>
            </div>
          </div>
            <div class="col-6 d-flex justify-content-end h-50">
                <a class="btn btn-warning ms-3" href="/{{ Request::path() }}/export">Export Data</a>
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
                                <th>Detail Penerimaan</th>
                                <th>Nomor Pengadaan</th>
                                <th>Tanggal Pengadaan</th>
                                <th>Dokumen Pengadaan</th>
                                <th>Jumlah Item Pengadaan</th>
                                <th>Editor Pengadaan</th>
                                <th>Validator Pengadaan</th>
                                <th>Detail Pengadaan</th>
                                <th>Tanggal Penerimaan</th>
                                <th>Dokumen Penerimaan</th>
                                <th>Editor Penerimaan</th>
                                <th>Validator Penerimaan</th>
                                <th>Catatan</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody class="tbody">
                            <?php foreach($datas as $i=>$data){?>
                            <tr>
                                <td>{{$i+1}}</td>
                                {{-- @if(Auth::user()->role_id == 6)
                                    @if(!$data->editorPenerimaan())<td><button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#createModal" onclick="changeModal({{$data->id}})">Tandai Diterima</button></td>@endif
                                    @if($data->editorPenerimaan())
                                    <td>
                                        <form method="POST" action="/manajemen-farmasi/penerimaan/cancel">@csrf
                                            <input type="hidden" name="id" value="{{$data->id}}">
                                            <button class="btn btn-danger" type="submit">Batalkan Penerimaan</button>
                                        </form>
                                    </td>
                                    @endif
                                @endif --}}
                                <td><a class="btn btn-success" href="/manajemen-farmasi/penerimaan/detail?id={{$data->id}}">Lihat Detail</button></td>
                                <td>{{$data->nomor_pengadaan}}</td>
                                <td>{{date("d M Y", strtotime($data->tanggal_pengadaan))}}</td>
                                <td><button class="btn btn-secondary" onclick="window.open('{{$data->dokumen_pengadaan}}','_blank')">Lihat Dokumen</button></td>
                                <td>{{$data->items()->count()}}</td>
                                <td>{{$data->editorPengadaan()->name}}</td>
                                <td>{{$data->validatorPengadaan() ? $data->validatorPengadaan()->name : '-'}}</td>
                                <td><a class="btn btn-primary" href="/manajemen-farmasi/pengadaan/detail?id={{$data->id}}">Lihat Detail</button></td>
                                <td>{{$data->tanggal_penerimaan ? date("d M Y", strtotime($data->tanggal_penerimaan)) : '-'}}</td>
                                <td>@if($data->dokumen_penerimaan) <button class="btn btn-secondary" onclick="window.open('{{$data->dokumen_penerimaan}}','_blank')">Lihat Dokumen</button>@else-@endif</td>
                                <td>@if($data->editorPenerimaan()) {{$data->editorPenerimaan()->name}} @else-@endif</td>
                                <td>{{$data->validatorPenerimaan() ? $data->validatorPenerimaan()->name : '-'}}</td>
                                <td>{{$data->catatan}}</td>
                                <td>{{$data->status}}</td>
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
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Penerimaan Pengadaan</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" id="id" name="id">
                            <div class="mb-3">
                                <label for="tanggal_penerimaan" class="form-label">Tanggal Penerimaan</label>
                                <input type="date" class="form-control" id="tanggal_penerimaan" name="tanggal_penerimaan" required>
                            </div>
                            <div class="mb-3">
                                <label for="dokumen_penerimaan" class="form-label">Dokumen Penerimaan</label>
                                <input type="file" class="form-control" id="dokumen_penerimaan" name="dokumen_penerimaan" required>
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
        @endif
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
                document.getElementById('id').value=res.id;
            }
            xhttp.open("GET", "/api/manajemen-farmasi/penerimaan/get?id="+id, true);
            xhttp.send();
        }
        function del(id){
            $.ajax({
                url: "/manajemen-farmasi/penerimaan/cancel",
                type:"POST",
                data:{
                    id: id,
                    _token: document.getElementsByTagName("meta")[3].content
                }
            });
            setTimeout(function() {
                window.location.href = "/manajemen-farmasi/penerimaan";
            }, 200);
        }
    </script>
@endsection

