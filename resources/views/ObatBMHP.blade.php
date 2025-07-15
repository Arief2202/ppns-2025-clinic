@extends('layouts.main')

@section('body')
    @include('layouts.cardOpen')
    @if (isset($errorMessage))
        <div class="alert-danger mt-1 p-2">{{ $errorMessage }}</div>
    @endif

    <div class="row mt-2 mb-3">
        <div class="col-6">
            <div class="col">
                <h5 class="card-title">{{ $title }}</h5>
            </div>
        </div>
        <div class="col-6 d-flex justify-content-end h-50">
            <a class="btn btn-warning ms-3" href="/{{ Request::path() }}/export">Export Data</a>
            @if (Auth::user()->role_id == 6)
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
                                <th>Satuan</th>
                                <th>Stok</th>
                                <th>Tempat Penyimpanan</th>
                                @if (Auth::user()->role_id == 6)
                                    <th>Edit</th>
                                @endif
                                <th>List Pengadaan</th>
                                <th>List Pemusnahan</th>
                            </tr>
                        </thead>
                        <tbody class="tbody">
                            <?php foreach($datas as $i=>$data){?>
                            <tr>
                                <td>{{ $i + 1 }}</td>
                                <td>{{ $data->nama }}</td>
                                <td>{{ $data->satuan }}</td>
                                <td>
                                    <button class="btn btn-{{ $data->hasExpired() ? 'danger' : 'success' }}" role="alert"
                                        disabled>
                                        {{ $data->stok() }}
                                    </button>
                                </td>
                                <td>{{ $data->tempat_penyimpanan }}</td>
                                @if (Auth::user()->role_id == 6)
                                    <td><button class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#editModal"
                                            onclick="changeModal({{ $data->id }})">Edit</button></td>
                                @endif
                                <td><a class="btn btn-primary"
                                        href="/manajemen-farmasi/list-pengadaan?id={{ $data->id }}">List Pengadaan</a>
                                </td>
                                <td><a class="btn btn-primary"
                                        href="/manajemen-farmasi/list-pemusnahan?id={{ $data->id }}">List
                                        Pemusnahan</a></td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>

    @if (Auth::user()->role_id == 6)
        <div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModal" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form action="/manajemen-farmasi/daftar-obat-bmhp" method="POST">@csrf
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Tambahkan Data</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" id="kategori" name="kategori" value="{{ $kategori }}">
                            <div class="mb-3">
                                <label for="nama" class="form-label">Nama</label>
                                <input type="text" class="form-control" id="nama" name="nama" required>
                            </div>
                            <div class="mb-3">
                                <label for="satuan" class="form-label">Satuan</label>
                                <input type="text" class="form-control" id="satuan" name="satuan" required>
                            </div>
                            <div class="mb-3">
                                <label for="tempat_penyimpanan" class="form-label">Tempat Penyimpanan</label>
                                <input type="text" class="form-control" id="tempat_penyimpanan" name="tempat_penyimpanan"
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
                    <form action="/manajemen-farmasi/daftar-obat-bmhp/edit" method="POST">@csrf
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Data</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" id="idEdit" name="id">
                            <div class="mb-3">
                                <label for="namaEdit" class="form-label">Nama</label>
                                <input type="text" class="form-control" id="namaEdit" name="nama" required>
                            </div>
                            <div class="mb-3">
                                <label for="satuanEdit" class="form-label">Satuan</label>
                                <input type="text" class="form-control" id="satuanEdit" name="satuan" required>
                            </div>
                            <div class="mb-3">
                                <label for="tempat_penyimpananEdit" class="form-label">Tempat Penyimpanan</label>
                                <input type="text" class="form-control" id="tempat_penyimpananEdit"
                                    name="tempat_penyimpanan" required>
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

                document.getElementById('idEdit').value = res.id;
                document.getElementById('namaEdit').value = res.nama;
                document.getElementById('satuanEdit').value = res.satuan;
                document.getElementById('tempat_penyimpananEdit').value = res.tempat_penyimpanan;
            }
            xhttp.open("GET", "/api/manajemen-farmasi/daftar-obat-bmhp/get?id=" + id, true);
            xhttp.send();
        }

        function del() {
            $.ajax({
                url: "/manajemen-farmasi/daftar-obat-bmhp/delete",
                type: "POST",
                data: {
                    id: document.getElementById('idEdit').value,
                    _token: document.getElementsByTagName("meta")[3].content
                }
            });
            setTimeout(function() {
                if (document.getElementById('kategori').value == 'Obat') window.location.href =
                    "/manajemen-farmasi/daftar-obat";
                if (document.getElementById('kategori').value == 'BMHP') window.location.href =
                    "/manajemen-farmasi/daftar-bmhp";
            }, 200);
        }
    </script>
@endsection
