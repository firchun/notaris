@extends('layouts.frontend.app')

@section('content')
    <section id="main-container" class="main-container">
        <div class="container">
            <div class="row text-center">
                <div class="col-12">
                    <h3 class="section-sub-title">{{ $title ?? '-' }}</h3>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6">
                    <h3 class="column-title">Tentang Kami</h3>

                    <p>{{ $setting->tentang_kami }}</p>

                </div><!-- Col end -->

                <div class="col-lg-6 mt-5 mt-lg-0">
                    <img src="{{ asset('img/kantor.webp') }}" alt="foto-kantor" class="img-fluid"
                        style="border-radius:20px;">

                </div><!-- Col end -->
            </div><!-- Content row end -->

        </div><!-- Container end -->
    </section>
@endsection
