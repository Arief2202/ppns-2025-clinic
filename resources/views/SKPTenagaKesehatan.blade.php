@extends('layouts.main')

@section('body')
    @include('layouts.cardOpen')
    @if (isset($errorMessage))
        <div class="alert-danger mt-1 p-2">{{ $errorMessage }}</div>
    @endif

    <div class="row mt-2 mb-3">
        <div class="col-6">
            <div class="col">
                <h5 class="card-title">SKP Tenaga Kesehatan</h5>
            </div>
        </div>
        <div class="col-6 d-flex justify-content-end h-50">
            <a class="btn btn-warning ms-3" href="/{{ Request::path() }}/export">Export Data</a>
            @if (Auth::user()->role_id == 1 || Auth::user()->role_id == 3)
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
                                <th>Nama</th>
                                <th>NIP</th>
                                <th>Dokumen SKP</th>
                                <th>Masa Berlaku</th>
                                <th>Editor</th>
                                @if (Auth::user()->role_id == 1 || Auth::user()->role_id == 3)
                                    <th>Edit</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody class="tbody">
                            <?php foreach($datas as $i=>$data){?>
                            <tr>
                                <td>{{ $i + 1 }}</td>
                                <td>{{ $data->nama }}</td>
                                <td>{{ $data->nip }}</td>
                                <td><button class="btn btn-primary"
                                        onclick="window.open('{{ $data->dokumen_SKP }}','_blank')">Lihat Dokumen</button>
                                </td>
                                <td>{{ date('d M Y', strtotime($data->masa_berlaku)) }}</td>
                                <td>{{ $data->editor()->name }}</td>
                                @if (Auth::user()->role_id == 1 || Auth::user()->role_id == 3)
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
                            <label for="nama" class="form-label">Nama</label>
                            <input type="text" class="form-control" id="nama" name="nama" required>
                        </div>
                        <div class="mb-3">
                            <label for="nip" class="form-label">NIP</label>
                            <input type="text" class="form-control" id="nip" name="nip" required>
                        </div>
                        <div class="mb-3">
                            <label for="dokumen_SKP" class="form-label">Dokumen SKP</label>
                            <input type="file" class="form-control" id="dokumen_SKP" name="dokumen_SKP" required>
                        </div>
                        <div class="mb-3">
                            <label for="masa_berlaku" class="form-label">Masa Berlaku</label>
                            <input type="date" class="form-control" id="masa_berlaku" name="masa_berlaku" required>
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
                <form action="/smk3/skp-tenaga-kesehatan/edit" method="POST" enctype="multipart/form-data">@csrf
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Data</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="idEdit" name="id">
                        <div class="mb-3">
                            <label for="nama" class="form-label">Nama</label>
                            <input type="text" class="form-control" id="namaEdit" name="nama">
                        </div>
                        <div class="mb-3">
                            <label for="nip" class="form-label">NIP</label>
                            <input type="text" class="form-control" id="nipEdit" name="nip">
                        </div>
                        <div class="mb-3">
                            <label for="dokumen_SKP" class="form-label">Dokumen SKP</label>
                            <input type="file" class="form-control" id="dokumen_SKPEdit" name="dokumen_SKP">
                        </div>
                        <div class="mb-3">
                            <label for="masa_berlaku" class="form-label">Masa Berlaku</label>
                            <input type="date" class="form-control" id="masa_berlakuEdit" name="masa_berlaku">
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
                const datee = new Date(res.masa_berlaku);
                var day = ("0" + datee.getDate()).slice(-2);
                var month = ("0" + (datee.getMonth() + 1)).slice(-2);
                var today = datee.getFullYear() + "-" + (month) + "-" + (day);
                document.getElementById('idEdit').value = res.id;
                document.getElementById('namaEdit').value = res.nama;
                document.getElementById('nipEdit').value = res.nip;
                document.getElementById('masa_berlakuEdit').value = today;
            }
            xhttp.open("GET", "/api/smk3/skp-tenaga-kesehatan/get?id=" + id, true);
            xhttp.send();
        }

        function del() {
            $.ajax({
                url: "/smk3/skp-tenaga-kesehatan/delete",
                type: "POST",
                data: {
                    id: document.getElementById('idEdit').value,
                    _token: document.getElementsByTagName("meta")[3].content
                }
            });
            setTimeout(function() {
                window.location.href = "/smk3/skp-tenaga-kesehatan";
            }, 200);
        }
    </script>
@endsection
