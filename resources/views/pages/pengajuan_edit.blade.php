@extends('layouts.frontend.app')

@section('content')
    <section id="main-container" class="main-container pb-1">
        <div class="container">
            <div class="row text-center">
                <div class="col-12">
                    <h3 class="section-sub-title">{{ $title ?? '-' }}</h3>
                </div>
            </div>

        </div>
    </section>

    <section class="container pt-2">
        @if (Session::has('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ Session::get('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
        @elseif (Session::has('danger'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ Session::get('danger') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
        @endif
        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                @foreach ($errors->all() as $item)
                    <ul>
                        <li>{{ $item }}</li>
                    </ul>
                @endforeach
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
        @endif
        <div class="alert alert-primary" role="alert">
            <h4 class="alert-heading">petunjuk pengisian!</h4>
            <ol>
                <li>Pastikan anda mengisi dengan data yang benar</li>
                <li>Isilah dengan teliti dan jangan sampai ada data yang terlewat </li>
                <li>Pastikan bahwa dokumen anda telah lengkap dan siap di upload</li>
                <li>Dokumen di upload dalam bentuk PDF</li>
            </ol>
        </div>
        <div class="alert alert-danger" role="alert">
            Keterangan penolakan : <strong>{{ $pengajuan->keterangan }}</strong>
        </div>
        <form action="{{ route('pengajuan_layanan.storePerbaikan') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="card shadow shadow-sm border border-warning">
                <div class="card-header bg-warning ">
                    <h5>Formulir Update Pengajuan {{ $layanan->nama_layanan }} </h5>
                </div>
                <div class="card-body">
                    <input type="hidden" name="id" value="{{ $pengajuan->id }}">
                    <input type="hidden" name="is_verified" value="0">

                    <div class="mb-3">
                        <label>Username</label>
                        <input type="text" class="form-control" value="{{ $pengajuan->nama_pemohon }}"
                            name="nama_pemohon">
                    </div>
                    @foreach (App\Models\FormulirLayanan::where('id_layanan', $layanan->id)->get() as $form)
                        <input type="hidden" name="id_formulir_layanan[]" value="{{ $form->id }}">
                        <div class="mb-3">
                            <label>{{ $form->nama_formulir }} <span class="text-danger">*</span></label>
                            <input type="text" name="isi_formulir[]" class="form-control"
                                value="{{ App\Models\FormulirPelayanan::where('id_pelayanan', $pengajuan->id)->where('id_formulir_layanan', $form->id)->latest()->first()->isi_formulir }}"
                                required>
                        </div>
                    @endforeach
                    <h5>Upload Kelengkapan Berkas</h5>
                    @foreach (App\Models\BerkasLayanan::where('id_layanan', $layanan->id)->get() as $berkas)
                        <input type="hidden" name="id_berkas_layanan[]" value="{{ $berkas->id }}">
                        <div class="mb-3">
                            <label>Berkas : {{ $berkas->nama_berkas }} <span
                                    class="text-danger">{{ $berkas->is_required == 1 ? '*' : '' }} (PDF)(Ukuran berkas
                                    maksimal
                                    2MB)</span></label><br>
                            @if (App\Models\BerkasPelayanan::where('id_pelayanan', $pengajuan->id)->where('id_berkas_layanan', $berkas->id)->latest()->first() != null)
                                <a href="{{ Storage::url(App\Models\BerkasPelayanan::where('id_pelayanan', $pengajuan->id)->where('id_berkas_layanan', $berkas->id)->latest()->first()->berkas) }}"
                                    target="__blank" class="btn btn-success mb-2 btn-sm">Lihat berkas
                                    <strong>{{ $berkas->nama_berkas }}</strong>
                                    sebelumnya</a>
                            @endif
                            <input type="file" name="berkas[]" class="form-control" accept=".pdf">
                        </div>
                    @endforeach
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Update Pengajuan</button>
                </div>
            </div>
        </form>
    </section>

@endsection
