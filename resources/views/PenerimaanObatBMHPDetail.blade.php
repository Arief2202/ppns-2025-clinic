@extends('layouts.main')

@section('body')
    @include('layouts.cardOpen')
    @if (isset($errorMessage))
        <div class="alert-danger mt-1 p-2">{{ $errorMessage }}</div>
    @endif
    <div class="row mt-2 mb-2">
        <div class="col-6">
            <div class="col">
                <h5 class="card-title">Detail Penerimaan Obat & BMHP</h5>
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
                    <div class="row">
                        <div class="col-3">
                            <div class="mb-2">
                                <label for="nomor_pengadaan" class="form-label">Nomor Pengadaan</label>
                                <input type="text" class="form-control" id="nomor_pengadaan"
                                    value="{{ $data->nomor_pengadaan }}" disabled>
                            </div>
                            <div class="mb-2">
                                <label for="tanggal_pengadaan" class="form-label">Tanggal Pengadaan</label>
                                <input type="text" class="form-control" id="tanggal_pengadaan"
                                    value="{{ date('d M Y', strtotime($data->tanggal_pengadaan)) }}" disabled>
                            </div>
                            <div class="mb-2">
                                <label for="catatan" class="form-label">Catatan</label>
                                <input type="text" class="form-control" id="catatan" value="{{ $data->catatan }}"
                                    disabled>
                            </div>

                        </div>
                        <div class="col-3">
                            <div class="mb-2">
                                <label for="dokumen_pengadaan" class="form-label">Dokumen Pengadaan</label><br>
                                <button class="btn btn-secondary w-100" id="dokumen_pengadaan"
                                    onclick="window.open('{{ $data->dokumen_pengadaan }}','_blank')">Lihat Dokumen</button>
                            </div>
                            <div class="mb-2">
                                <label for="editor" class="form-label">Editor Pengadaan</label>
                                <input type="text" class="form-control" id="editor"
                                    value="{{ $data->editorPengadaan()->name }}" disabled>
                            </div>
                            <div class="mb-2">

                                <label for="validator" class="form-label">Validator Pengadaan</label>
                                <input type="text" class="form-control" id="validator"
                                    value="{{ $data->validatorPengadaan() ? $data->validatorPengadaan()->name : '-' }}"
                                    disabled>

                                {{-- @if (Auth::user()->role_id == 1) --}}
                            </div>
                        </div>
                        {{-- @endif --}}

                        <div class="col-3">
                            <div class="mb-2">
                                <label for="dokumen_pengadaan" class="form-label">Dokumen Penerimaan</label><br>
                                <button class="btn btn-secondary w-100" id="dokumen_pengadaan"
                                    onclick="window.open('{{ $data->dokumen_penerimaan }}','_blank')" @if(!$data->dokumen_penerimaan) disabled @endif>Lihat Dokumen</button>
                            </div>
                            <div class="mb-2">
                                <label for="validator" class="form-label">Editor Penerimaan</label>
                                <input type="text" class="form-control" id="validator"
                                    value="{{ $data->editorPenerimaan() ? $data->editorPenerimaan()->name : '-' }}"
                                    disabled>
                            </div>
                            <div class="mb-2">
                                <label for="validator" class="form-label">Validator Penerimaan</label>
                                <input type="text" class="form-control" id="validator"
                                    value="{{ $data->validatorPenerimaan() ? $data->validatorPenerimaan()->name : '-' }}"
                                    disabled>
                            </div>

                        </div>
                        <div class="col-3">
                            <div class="mb-2">
                                <label for="tanggal_pengadaan" class="form-label">Tanggal Penerimaan</label>
                                <input type="text" class="form-control" id="tanggal_pengadaan"
                                value="@if($data->tanggal_penerimaan) {{ date('d M Y', strtotime($data->tanggal_penerimaan)) }} @else - @endif" disabled>
                            </div>
                            <div class="mb-2">
                                <label for="status" class="form-label">Status</label>
                                <input type="text" class="form-control" id="status" value="{{ $data->status }}"
                                disabled>
                            </div>
                            @if(Auth::user()->role_id == 1)
                            <div class="mb-2">
                                <label for="validator" class="form-label">Validate</label>
                                @if (!$data->validatorPenerimaan() && $data->editorPenerimaan())
                                    <form method="POST" action="/manajemen-farmasi/penerimaan/validate">@csrf
                                @endif
                                <input type="hidden" name="id" value="{{ $data->id }}">
                                <button class="btn btn-success w-100"
                                    @if($data->validatorPenerimaan() || !$data->editorPenerimaan()) disabled @else type="submit" @endif>Validasi</button>
                                @if (!$data->validatorPenerimaan() && $data->editorPenerimaan())
                                    </form>
                                @endif
                            </div>

                            @elseif(Auth::user()->role_id == 6)

                            <div class="mb-2">
                                <label for="status" class="form-label">Ubah Status Penerimaan</label><br>
                                @if(!$data->editorPenerimaan())<button class="btn btn-success w-100" @if($data->checkExpired() || $data->editorPenerimaan()) disabled @else data-bs-toggle="modal" data-bs-target="#createModal" onclick="changeModal({{$data->id}})" @endif>Tandai Diterima</button>@endif
                                @if($data->editorPenerimaan())
                                    <form method="POST" action="/manajemen-farmasi/penerimaan/cancel">@csrf
                                        <input type="hidden" name="id" value="{{$data->id}}">
                                        <button class="btn btn-danger w-100" type="submit">Batalkan Penerimaan</button>
                                    </form>
                                @endif
                            </div>
                            @endif
                        </div>
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
                        <th>Jumlah</th>
                        <th>Satuan</th>
                        <th>Tempat Penyimpanan</th>
                        {{-- <th>Tanggal Kadaluarsa</th> --}}
                        @if (Auth::user()->role_id == 6)
                            <th>Tanggal Kadaluarsa</th>
                            @if(!$data->editorPenerimaan())<th>Save</th>@endif
                        @endif
                    </tr>
                </thead>
                <tbody class="tbody">
                    <?php foreach($data->items() as $i=>$item){?>
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td>{{ $item->obatBMHP()->kategori }}</td>
                        <td>{{ $item->obatBMHP()->nama }}</td>
                        <td>{{ $item->jumlah }}</td>
                        <td>{{ $item->obatBMHP()->satuan }}</td>
                        <td>{{ $item->obatBMHP()->tempat_penyimpanan }}</td>
                        {{-- <td>{{date("d M Y", strtotime($item->tanggal_kadaluarsa))}}</td> --}}
                        @if (Auth::user()->role_id == 6)
                        <form method="POST" action="/manajemen-farmasi/penerimaan/detail">@csrf
                            <input type="hidden" name="id" value="{{ $item->id }}">
                            <td>
                                <input type="date" class="form-control" name="tanggal_kadaluarsa" @if($item->tanggal_kadaluarsa) value="{{date('Y-m-d', strtotime($item->tanggal_kadaluarsa))}}" @endif required>
                            </td>
                            @if(!$data->editorPenerimaan())
                            <td>
                                <button class="btn btn-success" type="submit">Save</button>
                            </td>
                            @endif
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

    @if(Auth::user()->role_id == 6)
        <div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModal" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form method="POST" action="/manajemen-farmasi/penerimaan" enctype="multipart/form-data">@csrf
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


@section('style2')
    <link rel="stylesheet" href="/vendor/bootstrap-select-1.14.0-beta3/css/bootstrap-select.min.css">
@endsection

@section('script')
    <script src="/vendor/bootstrap-select-1.14.0-beta3/js/bootstrap-select.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#myTable').DataTable({});
            // $('select').selectpicker();
            $('#obat_bmhp_id').change(function() {
                if (this.options[this.selectedIndex].text == "Tambah Obat / BMHP Baru") {
                    document.getElementById('addNewItemDiv').innerHTML = document.getElementById(
                        'templateAddNewItem').innerHTML;
                } else {
                    document.getElementById('addNewItemDiv').innerHTML = null;
                }
            })
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
