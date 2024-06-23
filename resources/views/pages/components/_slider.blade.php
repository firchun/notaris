<div class="banner-carousel banner-carousel-1 mb-0">
    <div class="banner-carousel-item" style="background-image:url('{{ asset('img/slider/01.jpg') }}');">
        <div class="slider-content">
            <div class="container h-100">
                <div class="row align-items-center h-100">
                    <div class="col-md-12 text-center">
                        <h2 class="slide-title" data-animation-in="slideInLeft">NOTARIS & PPAT Dr. H. AHMAD ALI MUDDIN,
                            SH., M.Kn
                        </h2>
                        <h3 class="slide-sub-title" data-animation-in="slideInRight">Notaris & PPAT</h3>
                        <p data-animation-in="slideInLeft" data-duration-in="1.2">
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="banner-carousel-item" style="background-image:url({{ asset('img/') }}/slider/02.jpg)">
        <div class="slider-content">
            <div class="container h-100">
                <div class="row align-items-center h-100">
                    <div class="col-md-12 text-center   ">
                        <h2 class="slide-title" data-animation-in="slideInLeft">NOTARIS & PPAT Dr. H. AHMAD ALI MUDDIN,
                            SH.,
                            M.Kn</h2>
                        <h3 class="slide-sub-title" data-animation-in="slideInRight">Notaris & PPAT</h3>
                        <p data-animation-in="slideInLeft" data-duration-in="1.2">
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<section class="call-to-action-box no-padding">
    <div class="container">
        <div class="action-style-box">
            <div class="row align-items-center">
                <div class="col-md-8 text-center text-md-left">
                    <div class="call-to-action-text">
                        <h3 class="action-title">PERCAYAKAN BERKAS ANDA PADA KAMI</h3>
                    </div>
                </div><!-- Col end -->
                <div class="col-md-4 text-center text-md-right mt-3 mt-md-0">
                    <div class="call-to-action-btn d-flex">
                        @if (Auth::check())
                            @if (Auth::user()->role == 'User')
                                <a class="btn btn-dark mx-2" href="{{ url('/panduan') }}">Panduan Pengajuan</a>
                                <a class="btn btn-dark" href="{{ url('/pengajuan_user') }}">Cek Pengajuan Anda</a>
                            @endif
                        @else
                            <a class="btn btn-dark mx-2" href="{{ url('/panduan') }}">Panduan Pengajuan</a>
                            <a class="btn btn-dark" href="{{ route('register') }}">Daftar sekarang</a>
                        @endif
                    </div>
                </div><!-- col end -->
            </div><!-- row end -->
        </div><!-- Action style box -->
    </div><!-- Container end -->
</section>
