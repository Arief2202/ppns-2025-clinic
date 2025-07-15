@extends('layouts.main')

@section('body')
    @include('layouts.cardOpen')
    @if (isset($errorMessage))
        <div class="alert-danger mt-1 p-2">{{ $errorMessage }}</div>
    @endif

    <div class="row mt-2 mb-3">
        <div class="col-6">
            <div class="col">
                <h5 class="card-title">Laporan Analisis Kecelakaan Kerja</h5>
            </div>
        </div>
        <div class="col-6 d-flex justify-content-end h-50">
            <a class="btn btn-warning ms-3" href="/{{ Request::path() }}/export">Export Data</a>
            @if (Auth::user()->role_id == 1 || Auth::user()->role_id == 2 || Auth::user()->role_id == 3)
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
                                <th>Tahun</th>
                                <th>Jumlah Kecelakaan</th>
                                <th>Kecelakaan Ringan</th>
                                <th>Kecelakaan Sedang</th>
                                <th>Kecelakaan Berat</th>
                                <th>Kecelakaan Fatality</th>
                                <th>Korban Meninggal</th>
                                <th>penyusun</th>
                                <th>Dokumen Laporan</th>
                                <th>Editor</th>
                                @if (Auth::user()->role_id == 4)
                                    <th>Validate</th>
                                @endif
                                <th>Validator</th>
                                @if (Auth::user()->role_id == 1 || Auth::user()->role_id == 2 || Auth::user()->role_id == 3)
                                    <th>Edit</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody class="tbody">
                            <?php foreach($datas as $i=>$data){?>
                            <tr>
                                <td>{{ $i + 1 }}</td>
                                <td>{{ $data->tahun }}</td>
                                <td>{{ $data->jumlah_kecelakaan }}</td>
                                <td>{{ $data->kecelakaan_ringan }}</td>
                                <td>{{ $data->kecelakaan_sedang }}</td>
                                <td>{{ $data->kecelakaan_berat }}</td>
                                <td>{{ $data->kecelakaan_fatality }}</td>
                                <td>{{ $data->korban_meninggal }}</td>
                                <td>{{ $data->penyusun }}</td>
                                <td><button class="btn btn-primary"
                                        onclick="window.open('{{ $data->dokumen_laporan }}','_blank')">Lihat
                                        Dokumen</button></td>
                                <td>{{ $data->editor()->name }}</td>
                                @if (Auth::user()->role_id == 4)
                                    <td>
                                        @if (!$data->validator())
                                            <form method="POST"
                                                action="/pelaporan-kecelakaan/laporan-analisis-kecelakaan-kerja/validate">
                                                @csrf
                                        @endif
                                        <input type="hidden" name="id" value="{{ $data->id }}">
                                        <button class="btn btn-success"
                                            {{ $data->validator() ? 'disabled' : 'type="submit"' }}>Validasi</button>
                                        @if (!$data->validator())
                                            </form>
                                        @endif
                                    </td>
                                @endif
                                <td>{{ $data->validator() ? $data->validator()->name : '-' }}</td>
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
                            <label for="tahun" class="form-label">tahun</label>
                            <input type="number" class="form-control" id="tahun" min="1800"
                                max="{{ date('Y') }}" name="tahun" required>
                        </div>
                        <div class="mb-3">
                            <label for="penyusun" class="form-label">penyusun</label>
                            <input type="text" class="form-control" id="penyusun" name="penyusun" required>
                        </div>
                        <div class="mb-3">
                            <label for="dokumen_laporan" class="form-label">Dokumen Laporan</label>
                            <input type="file" class="form-control" id="dokumen_laporan" name="dokumen_laporan" required>
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
                <form action="/pelaporan-kecelakaan/laporan-analisis-kecelakaan-kerja/edit" method="POST"
                    enctype="multipart/form-data">@csrf
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Data</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="idEdit" name="id">

                        <div class="mb-3">
                            <label for="tahunEdit" class="form-label">tahun</label>
                            <input type="number" class="form-control" id="tahunEdit" min="1800"
                                max="{{ date('Y') }}" name="tahun">
                        </div>
                        <div class="mb-3">
                            <label for="penyusunEdit" class="form-label">penyusun</label>
                            <input type="text" class="form-control" id="penyusunEdit" name="penyusun">
                        </div>
                        <div class="mb-3">
                            <label for="dokumen_laporanEdit" class="form-label">Dokumen Laporan</label>
                            <input type="file" class="form-control" id="dokumen_laporanEdit" name="dokumen_laporan">
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
                document.getElementById('idEdit').value = res.id;
                document.getElementById('tahunEdit').value = res.tahun;
                document.getElementById('penyusunEdit').value = res.penyusun;
            }
            xhttp.open("GET", "/api/pelaporan-kecelakaan/laporan-analisis-kecelakaan-kerja?id=" + id, true);
            xhttp.send();
        }

        function del() {
            $.ajax({
                url: "/pelaporan-kecelakaan/laporan-analisis-kecelakaan-kerja/delete",
                type: "POST",
                data: {
                    id: document.getElementById('idEdit').value,
                    _token: document.getElementsByTagName("meta")[3].content
                }
            });
            setTimeout(function() {
                window.location.href = "/pelaporan-kecelakaan/laporan-analisis-kecelakaan-kerja";
            }, 200);
        }
    </script>
@endsection
