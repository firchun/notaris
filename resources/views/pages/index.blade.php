@extends('layouts.frontend.app')

@section('content')
    @include('pages.components._slider')
    <section id="ts-features" class="ts-features pb-2">
        <div class="container">
            <div class="row">
                @foreach ($layanan as $item)
                    <div class="col-lg-4 col-md-6 mb-5">
                        <div class="ts-service-box p-2 border border-warning shadow shadow-sm" style="border-radius: 20px;">
                            <div class="ts-service-image-wrapper">
                                <img loading="lazy" class="w-100"
                                    src="{{ $item->thumbnail == null ? asset('img/layanan.png') : $item->thumbnail }}"
                                    alt="service-image">
                            </div>
                            <div class="d-flex">
                                <div class="ts-service-info p-3" style="margin:0;">
                                    <h3 class="service-box-title"><a href="#">{{ $item->nama_layanan }}</a></h3>
                                    <span class="badge badge-warning">{{ $item->jenis_layanan }}</span>
                                    <p>{!! Str::limit($item->deskripsi, 50) !!}</p>
                                    <a class="btn btn-block btn-dark" href="#" aria-label="service-details"
                                        data-toggle="modal" data-target="#serviceDetailsModal{{ $item->id }}">
                                        Lihat detail layanan
                                    </a>
                                </div>
                            </div>
                        </div><!-- Service1 end -->
                    </div><!-- Col 1 end -->

                    <div class="modal fade" id="serviceDetailsModal{{ $item->id }}" tabindex="-1"
                        aria-labelledby="serviceDetailsModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="serviceDetailsModalLabel">Layanan :
                                        {{ $item->nama_layanan }}</h5>
                                </div>
                                <div class="modal-body">
                                    @guest
                                        <small class="text-muted mb-1">* Untuk dapat mengajukan layanan, silahkan login atau
                                            membuat
                                            akun terlebih dahulu..</small>
                                        <hr style="margin:0">
                                    @endguest
                                    <h5 class="mt-3">Keterangan Layanan : </h5>
                                    <p>
                                        {{ $item->deskripsi }}</p>
                                    <h5 class="mt-3">Mengisi Formulir : </h5>
                                    <ul>
                                        @foreach (App\Models\FormulirLayanan::where('id_layanan', $item->id)->get() as $form)
                                            <li>{{ $form->nama_formulir }}</li>
                                        @endforeach
                                    </ul>
                                    <h5 class="mt-3">Berkas yang perlu disiapkan : </h5>
                                    <ul>
                                        @foreach (App\Models\BerkasLayanan::where('id_layanan', $item->id)->get() as $berkas)
                                            <li>{{ $berkas->nama_berkas }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                                <div class="modal-footer">
                                    @guest
                                        <a href="{{ route('login') }}" class="btn btn-primary">Login</a>
                                    @else
                                        @if (Auth::user()->role == 'User')
                                            <a href="{{ route('pengajuan_layanan', $item->id) }}"
                                                class="btn btn-primary btn-md">Ajukan</a>
                                        @endif
                                    @endguest
                                    <button type="button" class="btn btn-danger btn-md" data-dismiss="modal">Tutup</button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach

            </div><!-- Content row end -->
        </div><!-- Container end -->
    </section>
@endsection
