
@extends('layouts.main')

@section('body')
    @include('layouts.cardOpen')
        @if(isset($errorMessage))
            <div class="alert-danger mt-1 p-2">{{ $errorMessage }}</div>
        @endif

        <div class="row mt-2">
          <div class="col-6">
            <div class="col">
              <h5 class="card-title">Laporan Kecelakaan Kerja</h5>
            </div>
          </div>
          <div class="col-6 d-flex justify-content-end h-50">
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">Tambahkan Data</button>
          </div>
        </div>

        <div style="max-height: 100vh; overflow-y:auto;">
            <div class="card-text me-3">
                  <div style="max-height: 68vh; overflow-y:auto;">
                    <div class="card-text me-3">

                      <table id="myTable">
                        <thead class="thead">
                            <tr>
                                <th>Column 1</th>
                                <th>Column 2</th>
                                <th>Column 3</th>
                                <th>Column 4</th>
                                <th>Column 5</th>
                            </tr>
                        </thead>
                        <tbody class="tbody">
                            <?php for($a =0; $a<50; $a++){?>
                            <tr>
                                <td>Row {{$a}} Data 1</td>
                                <td>Row {{$a}} Data 2</td>
                                <td>Row {{$a}} Data 3</td>
                                <td>Row {{$a}} Data 4</td>
                                <td>Row {{$a}} Data 5</td>
                            </tr>
                            <?php } ?>
                        </tbody>
                      </table>

                    </div>
                  </div>
            </div>
        </div>


        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    ...
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
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
