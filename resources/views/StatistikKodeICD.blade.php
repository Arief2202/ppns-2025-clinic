@extends('layouts.main')

@section('body')
    @include('layouts.cardOpen')
    @if (isset($errorMessage))
        <div class="alert-danger mt-1 p-2">{{ $errorMessage }}</div>
    @endif

    <div class="row mt-2">
        <div class="col-6">
            <h5 class="card-title">Statistik Kode ICD</h5>
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
                                <th>Kode ICD</th>
                                <th>Jumlah</th>
                            </tr>
                        </thead>
                        <tbody class="tbody">
                            @foreach ($kode_icds as $i => $kode_icd)
                                <tr>
                                    <td>{{ $i + 1 }}</td>
                                    <td>{{ $kode_icd }}</td>
                                    <td>{{ $datas->where('kode_icd', $kode_icd)->count() }}</td>
                                </tr>
                            @endforeach
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
        $(document).ready(function() {
            $('#myTable').DataTable({

            });
        });
    </script>
@endsection
