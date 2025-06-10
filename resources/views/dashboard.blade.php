@extends('layouts.main')

@section('body')
    @include('layouts.cardOpen')
        @if(isset($errorMessage))
            <div class="alert-danger mt-1 p-2">{{ $errorMessage }}</div>
        @endif

        <div class="row mt-2">
          <div class="col-6">
            <div class="col">
              <h5 class="card-title">Dashboard</h5>
            </div>
          </div>
        </div>
        <div class="row mt-4">
            <div class="col-md-4 d-flex justify-content-center">
                <a href="/sarana-prasarana" class="btn btn-primary btn-menu">Sarana Prasarana</a>
            </div>
            <div class="col-md-4 d-flex justify-content-center">
                <a href="/manajemen-farmasi" class="btn btn-primary btn-menu">Manajemen Farmasi</a>
            </div>
            <div class="col-md-4 d-flex justify-content-center">
                <a href="/kesehatan-mental" class="btn btn-primary btn-menu">Kesehatan Mental</a>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-md-4 d-flex justify-content-center">
                <a href="/sarana-prasarana" class="btn btn-primary btn-menu">Pelaporan Kecelakaan</a>
            </div>
            <div class="col-md-4 d-flex justify-content-center">
                <a href="/manajemen-farmasi" class="btn btn-primary btn-menu">SMK3</a>
            </div>
            <div class="col-md-4 d-flex justify-content-center">
                <a href="/kesehatan-mental" class="btn btn-primary btn-menu">Rekam Medis</a>
            </div>
        </div>

    @include('layouts.cardClose')
@endsection
