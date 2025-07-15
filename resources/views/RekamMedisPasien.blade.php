@extends('layouts.main')

@section('body')
    @include('layouts.cardOpen')
        @if(isset($errorMessage))
            <div class="alert-danger mt-1 p-2">{{ $errorMessage }}</div>
        @endif

        <div class="row mt-2">
        <div class="col-6">
            <h5 class="card-title">Rekam Medis Pasien</h5>
        </div>
        <div class="col-6">
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
                                <th>NIP</th>
                                <th>Nama</th>
                                <th>Tanggal Lahir</th>
                                <th>Umur</th>
                                <th>Jenis Kelamin</th>
                                <th>Bagian</th>
                                <th>Tanggal Registrasi</th>
                                <th>Rekam Medis Psikolog</th>
                                <th>Rekam Medis Klinis</th>
                            </tr>
                        </thead>
                        <tbody class="tbody">
                            <?php foreach($pasiens as $i=>$pasien){?>
                            <tr>
                                <td>{{$i+1}}</td>
                                <td>{{$pasien->nip}}</td>
                                <td>{{$pasien->nama}}</td>
                                <td>{{date("d M Y", strtotime($pasien->tanggal_lahir))}}</td>
                                <td>{{$pasien->umur()}}</td>
                                <td>{{$pasien->jenis_kelamin}}</td>
                                <td>{{$pasien->bagian}}</td>
                                <td>{{date("d M Y", strtotime($pasien->tanggal_registrasi))}}</td>
                                <td><a href="/rekam-medis/rekam-medis-pasien/psikolog?id={{$pasien->id}}" class="btn btn-primary">Rekam Medis Psikolog</a></td>
                                <td><a href="/rekam-medis/rekam-medis-pasien/klinis?id={{$pasien->id}}" class="btn btn-primary">Rekam Medis Klinis</a></td>
                            </tr>
                            <?php } ?>
                        </tbody>
                      </table>

                    </div>
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
