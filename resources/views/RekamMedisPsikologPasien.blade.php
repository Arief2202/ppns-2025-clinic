@extends('layouts.main')

@section('body')
    @include('layouts.cardOpen')
        @if(isset($errorMessage))
            <div class="alert-danger mt-1 p-2">{{ $errorMessage }}</div>
        @endif

        <div class="row mt-2">
        <div class="col">
            <h5 class="card-title">Rekam Medis Psikolog {{$pasien->nama}} (NIP. {{$pasien->nip}})</h5>
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
                                <th>NIP Pemeriksa</th>
                                <th>Nama Pemeriksa</th>
                                <th>Tanggal Kunjungan</th>
                                <th>Catatan Kondisi</th>
                                <th>Intervensi</th>
                                <th>Status Intervensi Lanjutan</th>
                                <th>Tanggal Rujukan</th>
                                <th>Dokumen Rujukan</th>
                            </tr>
                        </thead>
                        <tbody class="tbody">
                            <?php $index = 1;?>
                            @foreach($datas as $i=>$data)
                                @foreach($data->items() as $item)
                                    <tr>
                                        <td>{{$index++}}</td>
                                        <td>{{$data->pemeriksa()->nip}}</td>
                                        <td>{{$data->pemeriksa()->name}}</td>
                                        <td>{{date("d M Y", strtotime($data->tanggal_kunjungan))}}</td>
                                        <td>{{$item->catatan_kondisi}}</td>
                                        <td>{{$item->intervensi}}</td>
                                        <td>{{$item->status_intervensi_lanjutan}}</td>
                                        <td>{{date("d M Y", strtotime($item->tanggal_rujukan))}}</td>
                                        <td><button class="btn btn-secondary" onclick="window.open('{{$item->dokumen_rujukan}}','_blank')">Lihat Dokumen</button></td>
                                    </tr>
                                @endforeach
                            @endforeach
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
