@extends('layouts.backend.admin')

@section('content')
    @include('layouts.backend.alert')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header flex-column flex-md-row">
                    <div class="head-label ">
                        <h5 class="card-title mb-0">{{ $title ?? 'Title' }}</h5>
                    </div>
                    <div class="dt-action-buttons text-end pt-3 pt-md-0">
                        <div class=" btn-group " role="group">
                            <button class="btn btn-secondary refresh btn-default" type="button">
                                <span>
                                    <i class="bx bx-sync me-sm-1"> </i>
                                    <span class="d-none d-sm-inline-block"></span>
                                </span>
                            </button>
                        </div>
                    </div>
                    <hr>
                    <div style="margin-left:24px; margin-right: 24px;">
                        <strong>Filter Data</strong>
                        <div class="d-flex justify-content-center align-items-center row gap-3 gap-md-0">

                            <div class="col-md-4 col-12">
                                <div class="input-group">
                                    <span class="input-group-text">Periode Tanggal</span>
                                    <input type="date" id="tanggalAwal" name="tanggal_awal" class="form-control">
                                    <input type="date" id="tanggalAkhir" name="tanggal_akhir" class="form-control">

                                </div>
                            </div>
                            <div class="col-md-3 col-12">
                                <div class="input-group">
                                    <span class="input-group-text">Layanan</span>
                                    <select id="selectLayanan" name="layanan" class="form-select">
                                        <option value="">Semua</option>
                                        @foreach ($layanan as $item)
                                            <option value="{{ $item->id }}">{{ $item->nama_layanan }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3 col-12">
                                <div class="input-group">
                                    <span class="input-group-text">Staff</span>
                                    <select id="selectStaff" name="staff" class="form-select">
                                        <option value="">Semua</option>
                                        @foreach ($user as $item)
                                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2 col-12 ">
                                <button type="button" id="filter" class="btn btn-primary"><i class="bx bx-filter"></i>
                                    Filter</button>
                            </div>
                        </div>
                    </div>
                    <hr>
                </div>
                <div class="card-datatable table-responsive">
                    <table id="datatable-pembayaran" class="table table-hover table-bordered display">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Tanggal</th>
                                <th>No Dokumen</th>
                                <th>Layanan</th>
                                <th>Total Bayar</th>
                                <th>Staff</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>ID</th>
                                <th>Tanggal</th>
                                <th>No Dokumen</th>
                                <th>Layanan</th>
                                <th>Total Bayar</th>
                                <th>Staff</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script>
        $(function() {
            var table = $('#datatable-pembayaran').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                ajax: '{{ url('all-pembayaran-datatable') }}',
                columns: [{
                        data: 'id',
                        name: 'id'
                    },

                    {
                        data: 'tanggal',
                        name: 'tanggal'
                    },

                    {
                        data: 'pelayanan.no_dokumen',
                        name: 'pelayanan.no_dokumen'
                    },
                    {
                        data: 'pelayanan.layanan.nama_layanan',
                        name: 'pelayanan.layanan.nama_layanan'
                    },
                    {
                        data: 'total',
                        name: 'total'
                    },
                    {
                        data: 'staff.name',
                        name: 'staff.name'
                    },

                ],
                dom: 'Blfrtip',
                buttons: [{
                        extend: 'pdf',
                        text: '<i class="bx bxs-file-pdf"></i> PDF',
                        className: 'btn-danger mx-3',
                        orientation: 'landscape',
                        title: 'Data Laporan Pembayaran',
                        pageSize: 'A4',
                        exportOptions: {
                            columns: ':visible'
                        },
                        customize: function(doc) {
                            doc.defaultStyle.fontSize = 8;
                            doc.styles.tableHeader.fontSize = 8;
                            doc.styles.tableHeader.fillColor = '#2a6908';


                        },
                        header: true
                    },
                    {
                        extend: 'excelHtml5',
                        text: '<i class="bx bxs-file-export"></i> Excel',
                        className: 'btn-success',
                        exportOptions: {
                            columns: ':visible'
                        }
                    }
                ]
            });
            $('.refresh').click(function() {
                $('#datatable-pembayaran').DataTable().ajax.reload();
            });
            $('#filter').click(function() {
                table.ajax.url('{{ url('all-pembayaran-datatable') }}?tanggal_awal=' +
                    $('#tanggalAwal').val() + '&tanggal_akhir=' + $('#tanggalAkhir').val() +
                    '&layanan=' + $('#selectLayanan').val() + '&staff=' + $('#selectStaff')
                    .val()).load();
            });
        });
    </script>
    <!-- JS DataTables Buttons -->
    <script src="https://cdn.datatables.net/buttons/2.1.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.1.1/js/buttons.html5.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
@endpush
