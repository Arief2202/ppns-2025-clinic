@extends('layouts.main')

@section('body')
    @include('layouts.cardOpen')
        @if(isset($errorMessage))
            <div class="alert-danger mt-1 p-2">{{ $errorMessage }}</div>
        @endif

        <div class="row mt-2">
        <div class="col-6">
            <h5 class="card-title">Rekam Medis Klinis {{$pasien->nama}} (NIP. {{$pasien->nip}})</h5>
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
                                    <th>NIP Pemeriksa</th>
                                    <th>Nama Pemeriksa</th>
                                    <th>Tanggal Kunjungan</th>
                                    <th>Kode Icd</th>
                                    <th>Gejala</th>
                                    <th>Diagnosis</th>
                                    <th>Tindakan Medis</th>
                                    <th>Dokumentasi Resep</th>
                                    <th>Detail Obat & BMHP</th>
                                </tr>
                        </thead>
                        <tbody class="tbody">
                            <?php $index = 1;?>
                            @foreach($datas as $i=>$data)
                                @foreach($data->items() as $item)
                                    <tr>
                                    <td>{{$i+1}}</td>
                                    <td>{{$data->pemeriksa()->nip}}</td>
                                    <td>{{$data->pemeriksa()->name}}</td>
                                    <td>{{date("d M Y", strtotime($data->tanggal_kunjungan))}}</td>
                                    <td>{{$item->kode_icd}}</td>
                                    <td>{{$item->gejala}}</td>
                                    <td>{{$item->diagnosis}}</td>
                                    <td>{{$item->tindakan_medis}}</td>
                                    <td><button class="btn btn-secondary" onclick="window.open('{{$item->dokumentasi_resep}}','_blank')">Lihat Dokumen</button></td>
                                    <td>
                                        <a class="btn btn-primary" type="submit" href="/rekam-medis/registrasi-kunjungan-klinis/detail/obat-bmhp?id={{$item->id}}">Detail Obat & BMHP</a>
                                    </td>
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
