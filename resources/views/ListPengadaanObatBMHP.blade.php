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
                                <th>Editor Pengadaan</th>
                                <th>Validator Pengadaan</th>
                                <th>Tanggal Penerimaan</th>
                                <th>Editor Penerimaan</th>
                                <th>Validator Penerimaan</th>
                                <th>Jumlah</th>
                                <th>Tanggal Kadaluarsa</th>
                                <th>Status</th>
                                <th>Lihat  Pengadaan</th>
                            </tr>
                        </thead>
                        <tbody class="tbody">
                            <?php foreach($datas as $i=>$data){?>
                            <tr>
                                <td>{{$i+1}}</td>
                                <td>{{$data->pengadaan()->nomor_pengadaan}}</td>
                                <td>{{date("d M Y", strtotime($data->pengadaan()->tanggal_pengadaan))}}</td>
                                <td>{{$data->pengadaan()->editorPengadaan() ? $data->pengadaan()->editorPengadaan()->name : "-"}}</td>
                                <td>{{$data->pengadaan()->validatorPengadaan() ? $data->pengadaan()->validatorPengadaan()->name : "-"}}</td>
                                <td>{{$data->pengadaan()->editorPenerimaan() ? date("d M Y", strtotime($data->pengadaan()->tanggal_penerimaan)) : '-'}}</td>
                                <td>{{$data->pengadaan()->editorPenerimaan() ? $data->pengadaan()->editorPenerimaan()->name : "-"}}</td>
                                <td>{{$data->pengadaan()->validatorPenerimaan() ? $data->pengadaan()->validatorPenerimaan()->name : "-"}}</td>
                                <td>{{$data->jumlah}}</td>
                                <td>
                                    <button class="btn btn-{{$data->hasExpired() ? 'danger' : 'success'}}" role="alert" disabled>
                                        {{date("d M Y", strtotime($data->tanggal_kadaluarsa))}}
                                    </button>
                                </td>
                                <td>{{$data->status}}</td>
                                <td><a class="btn btn-primary" href="http://clinic.ppns.seonsu.com/manajemen-farmasi/pengadaan/detail?id={{$data->pengadaan_id}}">Lihat Pengadaan</a></td>
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
