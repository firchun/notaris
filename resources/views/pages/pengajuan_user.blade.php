@extends('layouts.frontend.app')
@push('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.5/css/dataTables.dataTables.css" />
@endpush
@section('content')
    <section id="main-container pb-2" class="main-container">
        <div class="container pb-2">
            <div class="row text-center">
                <div class="col-12">
                    <h3 class="section-sub-title">{{ $title ?? '-' }}</h3>
                </div>
            </div>
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
        </div>
    </section>
    <section class="container">
        <div class="table-responsive">
            <table class="table table-striped table-bordered display">
                <thead class="bg-warning">
                    <tr>
                        <th>ID</th>
                        <th>No Dokumen</th>
                        <th>Nama Pemohon</th>
                        <th>Layanan</th>
                        <th>Status</th>
                        <th>Kelengkapan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($pelayanan as $item)
                        <tr>
                            <td>{{ $item->id }}</td>
                            <td>{{ $item->no_dokumen }}</td>
                            <td>{{ $item->pemohon->name }}</td>
                            <td>{{ $item->layanan->nama_layanan }}</td>
                            <td>
                                {{ App\Models\PelayananStatus::where('id_pelayanan', $item->id)->latest()->first()->status }}
                            </td>
                            <td>
                                <a class="btn btn-dark" href="#" aria-label="service-details" data-toggle="modal"
                                    data-target="#serviceDetailsModal{{ $item->id }}">
                                    Lihat
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </section>
    @foreach ($pelayanan as $item)
        <div class="modal fade" id="serviceDetailsModal{{ $item->id }}" tabindex="-1"
            aria-labelledby="serviceDetailsModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="serviceDetailsModalLabel">No Dokument :
                            {{ $item->no_dokumen }}</h5>
                    </div>
                    <div class="modal-body">
                        <table class="table table-striped table-bordered">
                            <tr>
                                <td>Nomor Dokumen</td>
                                <td>{{ $item->no_dokumen }}</td>
                            </tr>
                            <tr>
                                <td>Nama Pemohon</td>
                                <td>{{ $item->nama_pemohon }}</td>
                            </tr>
                            <tr>
                                <td>Layanan </td>
                                <td>{{ $item->layanan->nama_layanan }}</td>
                            </tr>
                            @foreach (App\Models\Formulirpelayanan::where('id_pelayanan', $item->id)->get() as $itemForm)
                                <tr>
                                    <td>{{ $itemForm->formulir_layanan->nama_formulir }} </td>
                                    <td>{{ $itemForm->isi_formulir }}</td>
                                </tr>
                            @endforeach
                            @foreach (App\Models\BerkasPelayanan::where('id_pelayanan', $item->id)->get() as $itemBerkas)
                                <tr>
                                    <td>Berkas {{ $itemBerkas->berkas_layanan->nama_berkas }} </td>
                                    <td><a target="__blank" href="{{ Storage::url($itemBerkas->berkas) }}"
                                            class="btn btn-success">Lihat
                                            Berkas</a></td>
                                </tr>
                            @endforeach
                            <tr>
                                <td>Tanggal pengajuan </td>
                                <td>{{ $item->created_at->format('d F Y') }}</td>
                            </tr>
                            <tr>
                                <td>Status pengajuan </td>
                                <td>{{ App\Models\PelayananStatus::where('id_pelayanan', $item->id)->latest()->first()->status }}
                                </td>
                            </tr>
                        </table>
                        <hr>
                        <h6>Tracking dokumen</h6>
                        <table class=" table table-bordered">
                            <tr>
                                <th>#</th>
                                <th>Tanggal</th>
                                <th>Status Dokumen</th>
                            </tr>
                            @foreach (App\Models\PelayananStatus::where('id_pelayanan', $item->id)->get() as $status)
                                <tr>
                                    <td>{{ $status->id }}</td>
                                    <td>{{ $status->created_at->format('d F Y') }}</td>
                                    <td>{{ $status->status }}</td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                    <div class="modal-footer">

                        <button type="button" class="btn btn-danger btn-md" data-dismiss="modal">Tutup</button>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endsection
@push('js')
    <script src="https://cdn.datatables.net/2.0.5/js/dataTables.js"></script>
    <script>
        $(document).ready(function() {
            $('#datatable').DataTable({
                // responsive: true,
                "language": {
                    "lengthMenu": "Tampilkan _MENU_ ",
                    "zeroRecords": "Maaf belum ada data",
                    "info": "Tampilkan data _PAGE_ dari _PAGES_",
                    "infoEmpty": "belum ada data",
                    "infoFiltered": "(saring from _MAX_ total data)",
                    "search": "Cari : ",
                    "paginate": {
                        "previous": "Sebelumnya ",
                        "next": "Selanjutnya"
                    }
                }

            });
        });
    </script>
@endpush
