@extends('layouts.main')

@section('body')
    @include('layouts.cardOpen')
    @if (isset($errorMessage))
        <div class="alert-danger mt-1 p-2">{{ $errorMessage }}</div>
    @endif
    <div class="row mt-2 mb-2">
        <div class="col-6">
            <div class="col">
                <h5 class="card-title">Detail Pemusnahan Obat & BMHP</h5>
            </div>
        </div>
        <div class="col-6 d-flex justify-content-end h-50">
            <a class="btn btn-warning ms-3" href="/{{ Request::path() }}/export">Export Data</a>
            @if (Auth::user()->role_id == 6)
                <button class="btn btn-primary ms-3" data-bs-toggle="modal" data-bs-target="#editModal">Edit Data</button>
            @endif
        </div>
    </div>

    <div style="max-height: 100vh; overflow-y:auto;">
        <div class="card-text me-3">
            <div style="max-height: 68vh; overflow-y:auto;">
                <div class="card-text me-3">
                    <div class="row">
                        <div class="col-6">
                            <div class="mb-2">
                                <label for="nomor_pengadaan" class="form-label">Nomor Pengadaan</label>
                                <input type="text" class="form-control" id="nomor_pengadaan"
                                    value="{{ $data->pengadaan()->nomor_pengadaan }}" disabled>
                            </div>
                            <div class="mb-2">
                                <label for="tanggal_pengadaan" class="form-label">Tanggal Pengadaan</label>
                                <input type="text" class="form-control" id="tanggal_pengadaan"
                                    value="{{ date('d M Y', strtotime($data->pengadaan()->tanggal_pengadaan)) }}" disabled>
                            </div>
                            <div class="mb-2">
                                <label for="detail_pengadaan" class="form-label">Detail Pengadaan</label><br>
                                <button class="btn btn-secondary w-100" id="detail_pengadaan"
                                    onclick="window.open('/manajemen-farmasi/pengadaan/detail?id={{ $data->pengadaan()->id }}','_blank')">Lihat
                                    Detail</button>
                            </div>
                            <div class="mb-2">
                                <label for="editor" class="form-label">Editor Pemusnahan</label>
                                <input type="text" class="form-control" id="editor"
                                    value="{{ $data->editor()->name }}" disabled>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="mb-2">
                                <label for="tanggal_pemusnahan" class="form-label">Tanggal Pemusnahan</label>
                                <input type="text" class="form-control" id="tanggal_pemusnahan"
                                    value="{{ date('d M Y', strtotime($data->tanggal_pemusnahan)) }}" disabled>
                            </div>
                            <div class="mb-2">
                                <label for="alasan_pemusnahan" class="form-label">Alasan Pemusnahan</label>
                                <input type="text" class="form-control" id="alasan_pemusnahan"
                                    value="{{ $data->alasan_pemusnahan }}" disabled>
                            </div>
                            <div class="mb-2">
                                <label for="berita_acara" class="form-label">Berita Acara</label>
                                <input type="text" class="form-control" id="berita_acara"
                                    value="{{ $data->berita_acara }}" disabled>
                            </div>
                            <div class="mb-2">
                                @if (Auth::user()->role_id == 1)
                                    <div class="row">
                                        <div class="col-3">
                                            <label for="validator" class="form-label">Validate</label>
                                            @if (!$data->validator())
                                                <form method="POST" action="/manajemen-farmasi/pemusnahan/validate">@csrf
                                            @endif
                                            <input type="hidden" name="id" value="{{ $data->id }}">
                                            <button class="btn btn-success w-100"
                                                {{ $data->validator() ? 'disabled' : 'type="submit"' }}>Validasi</button>
                                            @if (!$data->validator())
                                                </form>
                                            @endif
                                        </div>
                                        <div class="col-9">
                                @endif
                                <label for="validator" class="form-label">Validator Pemusnahan</label>
                                <input type="text" class="form-control" id="validator"
                                    value="{{ $data->validator() ? $data->validator()->name : '-' }}" disabled>

                                @if (Auth::user()->role_id == 1)
                            </div>
                        </div>
                        @endif

                    </div>
                </div>
            </div>
            <hr>
            <table id="myTable">
                <thead class="thead">
                    <tr>
                        <th>No</th>
                        <th>Kategori</th>
                        <th>Nama</th>
                        <th>Satuan</th>
                        <th>Tempat Penyimpanan</th>
                        <th>Jumlah Pengadaan</th>
                        <th>Tanggal Kadaluarsa</th>
                        <th>Jumlah Pemusnahan</th>
                        @if (Auth::user()->role_id == 6)
                            <th>Save</th>
                        @endif
                    </tr>
                </thead>
                <tbody class="tbody">
                    <?php foreach($data->items() as $i=>$item){?>
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td>{{ $item->obatBMHP()->kategori }}</td>
                        <td>{{ $item->obatBMHP()->nama }}</td>
                        <td>{{ $item->obatBMHP()->satuan }}</td>
                        <td>{{ $item->obatBMHP()->tempat_penyimpanan }}</td>
                        <td>{{ $item->pemusnahan()->pengadaan()->items()->where('obat_bmhp_id', $item->obat_bmhp_id)->first()->jumlah }}
                        </td>
                        <td>
                            <button class="btn @if ($item->pemusnahan()->pengadaan()->items()->where('obat_bmhp_id', $item->obat_bmhp_id)->first()->hasExpired()) btn-danger @else btn-success @endif"
                                disabled>
                                {{ date('d M Y', strtotime($item->pemusnahan()->pengadaan()->items()->where('obat_bmhp_id', $item->obat_bmhp_id)->first()->tanggal_kadaluarsa)) }}
                            </button>
                        </td>
                        <form method="POST" action="/manajemen-farmasi/pengadaan/detail/update">@csrf
                            <input type="hidden" name="id" value="{{ $item->id }}">
                            <td>
                                @if (Auth::user()->role_id == 6)
                                    <input class="form-control" type="number" name="jumlah"
                                        max="{{ $item->pemusnahan()->pengadaan()->items()->where('obat_bmhp_id', $item->obat_bmhp_id)->first()->jumlah }}"
                                        id="" value="{{ $item->jumlah }}">
                                @else
                                    {{ $item->jumlah }}
                                @endif
                            </td>
                            @if (Auth::user()->role_id == 6)
                                <td>
                                    <button class="btn btn-success" type="submit">Save</button>
                                </td>
                        </form>
                        @endif
                    </tr>
                    <?php } ?>
                </tbody>
            </table>

        </div>
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
                        <input type="hidden" id="idEdit" name="id" value="{{ $data->id }}">
                        <input type="hidden" name="from_link" value="/manajemen-farmasi/pemusnahan">
                        <div class="">
                            <label for="pengadaan_id" class="form-label">Nomor Pengadaan</label>
                        </div>
                        <div class="mb-2">
                            <select class="selectpicker" data-live-search="true" id="pengadaan_id" name="pengadaan_id">
                                <option value="">Pilih Nomor Pengadaan</option>
                                @foreach ($pengadaans as $pengadaan)
                                    <option value="{{ $pengadaan->id }}">{{ $pengadaan->nomor_pengadaan }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="tanggal_pemusnahanEdit" class="form-label">Tanggal Pemusnahan</label>
                            <input type="date" class="form-control" id="tanggal_pemusnahanEdit"
                                name="tanggal_pemusnahan"
                                value="{{ date('Y-m-d', strtotime($data->tanggal_pemusnahan)) }}">
                        </div>
                        <div class="mb-3">
                            <label for="alasan_pemusnahanEdit" class="form-label">Alasan Pemusnahan</label>
                            <input type="text" class="form-control" id="alasan_pemusnahanEdit"
                                name="alasan_pemusnahan" value="{{ $data->alasan_pemusnahan }}">
                        </div>
                        <div class="mb-3">
                            <label for="berita_acaraEdit" class="form-label">Berita Acara</label>
                            <input type="text" class="form-control" id="berita_acaraEdit" name="berita_acara"
                                value="{{ $data->berita_acara }}">
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


@section('style2')
    <link rel="stylesheet" href="/vendor/bootstrap-select-1.14.0-beta3/css/bootstrap-select.min.css">
@endsection

@section('script')
    <script src="/vendor/bootstrap-select-1.14.0-beta3/js/bootstrap-select.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#myTable').DataTable({});
        });

        function del() {
            $.ajax({
                url: "/manajemen-farmasi/pengadaan/delete",
                type: "POST",
                data: {
                    id: document.getElementById('idEdit').value,
                    _token: document.getElementsByTagName("meta")[3].content
                }
            });
            setTimeout(function() {
                window.location.href = "/manajemen-farmasi/pengadaan";
            }, 200);
        }
    </script>
@endsection
