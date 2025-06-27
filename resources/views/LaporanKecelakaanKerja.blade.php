
@extends('layouts.main')

@section('body')
    @include('layouts.cardOpen')
        @if(isset($errorMessage))
            <div class="alert-danger mt-1 p-2">{{ $errorMessage }}</div>
        @endif

        <div class="row mt-2 mb-3">
          <div class="col-6">
            <div class="col">
              <h5 class="card-title">Laporan Kecelakaan Kerja</h5>
            </div>
          </div>
          @if(Auth::user()->role_id == 1 || Auth::user()->role_id == 2 || Auth::user()->role_id == 3)
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
                                <th>Tanggal Kejadian</th>
                                <th>Waktu Kejadian</th>
                                <th>Lokasi Kejadian</th>
                                <th>Jenis Kecelakaan</th>
                                <th>Jumlah Korban</th>
                                <th>Uraian Kejadian</th>
                                <th>Berita Acara</th>
                                <th>Editor</th>
                                @if(Auth::user()->role_id == 3)
                                <th>Validate</th>
                                @endif
                                <th>Validator</th>
                                <th>Detail</th>
                            </tr>
                        </thead>
                        <tbody class="tbody">
                            <?php foreach($datas as $i=>$data){?>
                            <tr>
                                <td>{{$i+1}}</td>
                                <td>{{date("d M Y", strtotime($data->tanggal_kejadian))}}</td>
                                <td>{{date("H:i:s", strtotime($data->tanggal_kejadian))}}</td>
                                <td>{{$data->lokasi_kejadian}}</td>
                                <td>{{$data->jenis_kecelakaan}}</td>
                                <td>{{$data->korbans()->count()}}</td>
                                <td>{{$data->uraian_kejadian}}</td>
                                <td>{{$data->berita_acara}}</td>
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
                                <td><a class="btn btn-primary" href="/pelaporan-kecelakaan/laporan-kecelakaan-kerja/detail?id={{$data->id}}">Detail</button></td>
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
                                <label for="tanggal_kejadian" class="form-label">Tanggal & Waktu Kejadian</label>
                                <input type="datetime-local" class="form-control" id="tanggal_kejadian" name="tanggal_kejadian" required>
                            </div>
                            <div class="mb-3">
                                <label for="lokasi_kejadian" class="form-label">Lokasi Kejadian</label>
                                <input type="text" class="form-control" id="lokasi_kejadian" name="lokasi_kejadian" required>
                            </div>
                            <div class="mb-3">
                                <label for="jenis_kecelakaan" class="form-label">Jenis Kecelakaan</label>
                                <select class="form-select" id="jenis_kecelakaan" name="jenis_kecelakaan" required>
                                    <option value="Ringan">Ringan</option>
                                    <option value="Sedang">Sedang</option>
                                    <option value="Berat">Berat</option>
                                    <option value="Fatality">Fatality</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="uraian_kejadian" class="form-label">Uraian Kejadian</label>
                                <input type="text" class="form-control" id="uraian_kejadian" name="uraian_kejadian" required>
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
    @include('layouts.cardClose')
@endsection


@section('script')
    <script>
        $(document).ready( function () {
            $('#myTable').DataTable({

            });
        });
    </script>
@endsection

