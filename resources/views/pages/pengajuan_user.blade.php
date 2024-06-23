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
                        <th>Persetujuan</th>
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
                            <td>
                                @if ($item->biaya != 0 && $item->is_continue == 0)
                                    <a class="btn btn-primary" href="#" aria-label="service-details"
                                        data-toggle="modal" data-target="#persetujuan{{ $item->id }}">
                                        Lanjutkan
                                    </a>
                                @endif
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
                        @if ($item->is_paid == 0 && $item->is_continue == 1)
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <p>
                                    Pembayaran dapat di bayarkan langsung ke kantor atau bisa dengan transfer
                                    pada bank
                                    yang tersedia sebagai berikut :
                                <ol>
                                    <li>Bank Negara Indonesia (Persero) Tbk,Cabang Merauke di Nomor Rekening Giro :
                                        8888811793
                                        a/n
                                        Ahmad Ali
                                        Muddin
                                    </li>
                                    <li>Bank Mandiri (Persero) Tbk, di Nomor Rekening : 1520001417746 a/n Ahmad Ali Muddin
                                    </li>
                                </ol>
                                </p>
                            </div>
                        @endif
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
                            @foreach (App\Models\FormulirPelayanan::where('id_pelayanan', $item->id)->get() as $itemForm)
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
                                <td>Biaya pengurusan </td>
                                <td>{{ $item->biaya != 0 ? 'Rp ' . number_format($item->biaya) : 'Menunggu..' }}</td>
                            </tr>
                            <tr>
                                <td>Status pengajuan </td>
                                <td>{{ App\Models\PelayananStatus::where('id_pelayanan', $item->id)->latest()->first()->status }}
                                </td>
                            </tr>

                            @if (App\Models\BerkasAkhir::where('id_pelayanan', $item->id)->first() != null && $item->is_paid == 1)
                                <tr>
                                    <td>Berkas Akhir</td>
                                    <td>
                                        <a href="{{ Storage::url(App\Models\BerkasAkhir::where('id_pelayanan', $item->id)->first()->berkas_akhir) }}"
                                            class="btn btn-dark" download>Download Berkas Akhir</a><br>
                                        <small class="text-mutted">*Berkas ini di bersifat preview, untuk berkas asli harap
                                            mengambil di
                                            kantor</small>
                                    </td>
                                </tr>
                            @endif
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
                        @if ($item->is_verified == 2)
                            <a href="{{ url('/pengajuan_layanan/edit', $item->id) }}"
                                class="btn btn-warning btn-md">Perbaiki Pengajuan</a>
                        @endif
                        <button type="button" class="btn btn-danger btn-md" data-dismiss="modal">Tutup</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="persetujuan{{ $item->id }}" tabindex="-1"
            aria-labelledby="serviceDetailsModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="serviceDetailsModalLabel">Persetujuan melanjutkan dokumen :
                            {{ $item->no_dokumen }}</h5>
                    </div>
                    <div class="modal-body">
                        <p>Klik <b>Setujui</b> untuk melanjutkan pengurusan dokumen dengan biaya :
                            <b class="text-danger"> Rp {{ number_format($item->biaya) }}</b>
                        </p>
                        <p>
                            Mohon Biaya tersebut kirannya dapat di bayarkan langsung ke kantor atau bisa dengan transfer
                            pada bank
                            yang tersedia sebagai berikut :
                        <ol>
                            <li>Bank Negara Indonesia (Persero) Tbk,Cabang Merauke di Nomor Rekening Giro : 8888811793 a/n
                                Ahmad Ali
                                Muddin
                            </li>
                            <li>Bank Mandiri (Persero) Tbk, di Nomor Rekening : 1520001417746 a/n Ahmad Ali Muddin</li>
                        </ol>
                        </p>

                    </div>
                    <div class="modal-footer">
                        <a href="{{ url('/setujui-dokumen', $item->id) }}" class="btn btn-success btn-md">Setujui</a>
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
