@extends('layouts.frontend.app')

@section('content')
    <section id="main-container" class="main-container">
        <div class="container">
            <div class="row text-center">
                <div class="col-12">
                    <h3 class="section-sub-title">{{ $title ?? '-' }}</h3>
                </div>
            </div>
        </div>
    </section>
    <section id="main-container" class="main-container">
        <div class="container">
            <div class="mb-3">
                <h2>Biaya Pengurusan Notaris</h2>
            </div>
            <div class="mb-3 text-center">
                <a href="{{ asset('/biaya/notaris.pdf') }}" class="btn btn-dark" download>Download Biaya Notaris</a>
            </div>
            <iframe src="{{ asset('/biaya/notaris.pdf') }}" style="width: 100%; height:500px;"></iframe>
        </div>
    </section>
    <section id="main-container" class="main-container">
        <div class="container">
            <div class="mb-3">
                <h2>Biaya Pengurusan PPAT</h2>
            </div>
            <div class="mb-3 text-center">
                <a href="{{ asset('/biaya/ppat.pdf') }}" class="btn btn-dark" download>Download Biaya PPAT</a>
            </div>
            <iframe src="{{ asset('/biaya/ppat.pdf') }}" style="width: 100%; height:500px;"></iframe>
        </div>
    </section>
@endsection
