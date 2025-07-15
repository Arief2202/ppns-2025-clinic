@extends('layouts.main')

@section('body')
    @include('layouts.cardOpen')
    @if (isset($errorMessage))
        <div class="alert-danger mt-1 p-2">{{ $errorMessage }}</div>
    @endif

    <div class="row mt-2 mb-3">
        <div class="col-6">
            <div class="col">
                <h5 class="card-title">Klaim Pembiayaan</h5>
            </div>
        </div>
        <div class="col-6 d-flex justify-content-end h-50">
            <a class="btn btn-warning ms-3" href="/{{ Request::path() }}/export">Export Data</a>
            @if (Auth::user()->role_id == 7)
                <button class="btn btn-primary ms-3" data-bs-toggle="modal" data-bs-target="#createModal">Tambahkan Data</button>
            @endif
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
                                <th>Tanggal</th>
                                <th>Dokumentasi Klaim</th>
                                <th>Status</th>
                                <th>Alasan Penolakan</th>
                                <th>Editor</th>
                                @if (Auth::user()->role_id == 7)
                                    <th>Edit</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody class="tbody">
                            <?php foreach($datas as $i=>$data){?>
                            <tr>
                                <td>{{ $i + 1 }}</td>
                                <td>{{ date('d M Y', strtotime($data->tanggal_pengajuan)) }}</td>
                                <td><button class="btn btn-primary"
                                        onclick="window.open('{{ $data->dokumentasi_klaim }}','_blank')">Lihat
                                        Dokumen</button></td>
                                <td>{{ $data->status }}</td>
                                <td>{{ $data->alasan_penolakan }}</td>
                                <td>{{ $data->editor()->name }}</td>
                                @if (Auth::user()->role_id == 7)
                                    <td><button class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#editModal"
                                            onclick="changeModal({{ $data->id }})">Edit</button></td>
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
                            <label for="tanggal_pengajuan" class="form-label">Tanggal Pengajuan</label>
                            <input type="date" class="form-control" id="tanggal_pengajuan" name="tanggal_pengajuan"
                                required>
                        </div>
                        <div class="mb-3">
                            <label for="dokumentasi_klaim" class="form-label">Dokumentasi Klaim</label>
                            <input type="file" class="form-control" id="dokumentasi_klaim" name="dokumentasi_klaim"
                                required>
                        </div>
                        <div class="mb-3">
                            <label for="status" class="form-label">Status</label>
                            <input type="text" class="form-control" id="status" name="status" required>
                        </div>
                        <div class="mb-3">
                            <label for="alasan_penolakan" class="form-label">Alasan Penolakan</label>
                            <input type="text" class="form-control" id="alasan_penolakan" name="alasan_penolakan"
                                required>
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
                <form action="/rekam-medis/klaim-pembiayaan/edit" method="POST" enctype="multipart/form-data">@csrf
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Data</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="idEdit" name="id">
                        <div class="mb-3">
                            <label for="tanggal_pengajuanEdit" class="form-label">Tanggal Pengajuan</label>
                            <input type="date" class="form-control" id="tanggal_pengajuanEdit"
                                name="tanggal_pengajuan">
                        </div>
                        <div class="mb-3">
                            <label for="dokumentasi_klaimEdit" class="form-label">Dokumentasi Klaim</label>
                            <input type="file" class="form-control" id="dokumentasi_klaimEdit"
                                name="dokumentasi_klaim">
                        </div>
                        <div class="mb-3">
                            <label for="statusEdit" class="form-label">Status</label>
                            <input type="text" class="form-control" id="statusEdit" name="status">
                        </div>
                        <div class="mb-3">
                            <label for="alasan_penolakanEdit" class="form-label">Alasan Penolakan</label>
                            <input type="text" class="form-control" id="alasan_penolakanEdit"
                                name="alasan_penolakan">
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
        $(document).ready(function() {
            $('#myTable').DataTable({

            });
        });

        function changeModal(id) {
            const xhttp = new XMLHttpRequest();
            xhttp.onload = function() {
                const res = JSON.parse(this.responseText);
                const datee = new Date(res.tanggal_pengajuan);
                var day = ("0" + datee.getDate()).slice(-2);
                var month = ("0" + (datee.getMonth() + 1)).slice(-2);
                var today = datee.getFullYear() + "-" + (month) + "-" + (day);
                document.getElementById('idEdit').value = res.id;
                document.getElementById('tanggal_pengajuanEdit').value = today;
                document.getElementById('statusEdit').value = res.status;
                document.getElementById('alasan_penolakanEdit').value = res.alasan_penolakan;
            }
            xhttp.open("GET", "/api/rekam-medis/klaim-pembiayaan/get?id=" + id, true);
            xhttp.send();
        }

        function del() {
            $.ajax({
                url: "/rekam-medis/klaim-pembiayaan/delete",
                type: "POST",
                data: {
                    id: document.getElementById('idEdit').value,
                    _token: document.getElementsByTagName("meta")[3].content
                }
            });
            setTimeout(function() {
                window.location.href = "/rekam-medis/klaim-pembiayaan";
            }, 200);
        }
    </script>
@endsection
