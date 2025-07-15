@extends('layouts.main')

@section('body')
    @include('layouts.cardOpen')
        @if(isset($errorMessage))
            <div class="alert-danger mt-1 p-2">{{ $errorMessage }}</div>
        @endif

        <div class="row mt-2 mb-3">
          <div class="col-6">
            <div class="col">
              <h5 class="card-title">{{$title}}</h5>
            </div>
          </div>
          <div class="col-6 d-flex justify-content-end h-50">
            <a class="btn btn-warning ms-3" href="/{{Request::path()}}/export">Export Data</a>
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
                                <th>Nomor Pengadaan</th>
                                <th>Tanggal Pengadaan</th>
                                <th>Tanggal Pemusnahan</th>
                                <th>Alasan Pemusnahan</th>
                                <th>Berita Acara</th>
                                <th>Editor</th>
                                <th>Validator</th>
                                <th>Tanggal Kadaluarsa</th>
                                <th>Jumlah Obat</th>
                                <th>Jumlah Pemusnahan</th>
                                <th>Lihat Pemusnahan</th>
                            </tr>
                        </thead>
                        <tbody class="tbody">
                            <?php foreach($datas as $i=>$data){?>
                            <tr>
                                <td>{{$i+1}}</td>
                                <td>{{$data->pemusnahan()->pengadaan()->nomor_pengadaan}}</td>
                                <td>{{date("d M Y", strtotime($data->pemusnahan()->pengadaan()->tanggal_pengadaan))}}</td>
                                <td>{{date("d M Y", strtotime($data->pemusnahan()->tanggal_pemusnahan))}}</td>
                                <td>{{$data->pemusnahan()->alasan_pemusnahan}}</td>
                                <td>{{$data->pemusnahan()->berita_acara}}</td>
                                <td>{{$data->pemusnahan()->editor()->name}}</td>
                                <td>{{$data->pemusnahan()->validator()->name}}</td>
                                <td>
                                    <button class="btn @if($data->pemusnahan()->pengadaan()->items()->where('obat_bmhp_id', $data->obat_bmhp_id)->first()->hasExpired()) btn-danger @else btn-success @endif" disabled>
                                        {{date("d M Y", strtotime($data->pemusnahan()->pengadaan()->items()->where('obat_bmhp_id', $data->obat_bmhp_id)->first()->tanggal_kadaluarsa))}}
                                    </button>
                                </td>
                                <td>{{$data->pemusnahan()->pengadaan()->items()->where('obat_bmhp_id', $data->obat_bmhp_id)->first()->jumlah}}</td>
                                <td>{{$data->jumlah}}</td>
                                <td><a class="btn btn-primary" href="/manajemen-farmasi/pemusnahan/detail?id={{$data->pemusnahan_id}}">Lihat Pemusnahan</a></td>
                                {{-- <td>{{date("d M Y", strtotime($data->pengadaan()->tanggal_pengadaan))}}</td>
                                <td>{{$data->pengadaan()->editorPengadaan()->name}}</td>
                                <td>{{$data->pengadaan()->validatorPengadaan()->name}}</td>
                                <td>{{date("d M Y", strtotime($data->pengadaan()->tanggal_penerimaan))}}</td>
                                <td>{{$data->pengadaan()->editorPenerimaan()->name}}</td>
                                <td>{{$data->pengadaan()->validatorPenerimaan()->name}}</td>
                                <td>{{$data->jumlah}}</td>
                                <td>
                                    <button class="btn btn-{{$data->hasExpired() ? 'danger' : 'success'}}" role="alert" disabled>
                                        {{date("d M Y", strtotime($data->tanggal_kadaluarsa))}}
                                    </button>
                                </td>
                                <td>{{$data->status}}</td>
                                <td><a class="btn btn-primary" href="http://clinic.ppns.seonsu.com/manajemen-farmasi/pengadaan/detail?id={{$data->pengadaan_id}}">Lihat Pengadaan</a></td> --}}
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
