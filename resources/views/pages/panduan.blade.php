@extends('layouts.frontend.app')

@section('content')
    <section id="main-container" class="main-container">
        <div class="container">
            <div class="mb-3 text-center">
                <a href="{{ asset('/panduan_page/panduan.pdf') }}" class="btn btn-dark" download>Download Panduan</a>
            </div>
            <iframe src="{{ asset('/panduan_page/panduan.pdf') }}" style="width: 100%; height:500px;"></iframe>
        </div>
    </section>
@endsection
