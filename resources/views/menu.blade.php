@extends('layouts.main')

@section('body')
    @include('layouts.cardOpen')
        @if(isset($errorMessage))
            <div class="alert-danger mt-1 p-2">{{ $errorMessage }}</div>
        @endif

        <div class="row mt-2 mb-4">
            <h5 class="card-title" style="font-size: 30px; font-weight:700">{{$title}}</h5>
        </div>
        <div class="row mb-3">
        @foreach($menu as $m)
        <div class="col-md-4 d-flex justify-content-center mb-3">
            <a href="{{$m[0]}}" class="btn btn-primary btn-menu">{{$m[1]}}</a>
        </div>
        @endforeach
        </div>

    @include('layouts.cardClose')
@endsection
