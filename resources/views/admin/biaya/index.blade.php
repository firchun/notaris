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
                </div>
                <div class="card-datatable table-responsive">
                    <table id="datatable-biaya" class="table table-hover table-bordered display">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Tanggal</th>
                                <th>No Dokumen</th>
                                <th>Nama Pemohon</th>
                                <th>Layanan</th>
                                <th>Biaya</th>
                                <th>detail</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>ID</th>
                                <th>Tanggal</th>
                                <th>No Dokumen</th>
                                <th>Nama Pemohon</th>
                                <th>Layanan</th>
                                <th>Biaya</th>
                                <th>Detail</th>
                                <th>Action</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @include('admin.biaya.components.modal')
    @include('admin.pelayanan.components.modal')
@endsection
@include('admin.pelayanan.script')
@push('js')
    <script>
        $(function() {
            $('#datatable-biaya').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                ajax: '{{ url('pelayanans-datatable') }}',
                columns: [{
                        data: 'id',
                        name: 'id'
                    },

                    {
                        data: 'date',
                        name: 'date'
                    },
                    {
                        data: 'no_dokumen',
                        name: 'no_dokumen'
                    },
                    {
                        data: 'pemohon',
                        name: 'pemohon'
                    },

                    {
                        data: 'layanan.nama_layanan',
                        name: 'layanan.nama_layanan'
                    },

                    {
                        data: 'biaya_text',
                        name: 'biaya_text'
                    },
                    {
                        data: 'action',
                        name: 'action'
                    }, {
                        data: 'action_biaya',
                        name: 'action_biaya'
                    }
                ]
            });

            $('.refresh').click(function() {
                $('#datatable-biaya').DataTable().ajax.reload();
            });
            window.inputBiaya = function(id) {
                $('#idPelayanan').val(id);
                $('#inputBiaya').modal('show');
            };
            window.destroyPembayaran = function(id) {
                $.ajax({
                    type: 'POST',
                    url: '/pembayaran/delete/' + id,
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        alert(response.message);
                        // Refresh DataTable after saving changes
                        $('#datatable-biaya').DataTable().ajax.reload();
                        $('#datatable-pembayaran').DataTable().ajax.reload();
                    },
                    error: function(xhr) {
                        alert('An error occurred: ' + xhr.responseText);
                    }
                });
            };
            window.updatePembayaran = function(id) {
                $('#datatable-pembayaran').DataTable().destroy();
                $('#idPelayananPembayaran').val(id);
                $('#updatePembayaran').modal('show');

                $('#datatable-pembayaran').DataTable({
                    processing: true,
                    serverSide: true,
                    responsive: true,
                    ajax: `{{ url('pembayaran-datatable') }}/${id}`,
                    columns: [{
                            data: 'id',
                            name: 'id'
                        },

                        {
                            data: 'total',
                            name: 'total'
                        },
                        {
                            data: 'action',
                            name: 'action'
                        },
                    ]
                });
            };
            $('#btnInputBiaya').click(function() {
                // var formData = $('#inputBiaya').serialize();
                var biaya = $('#formBiaya').val();
                var id = $('#idPelayanan').val();

                $.ajax({
                    type: 'POST',
                    url: '/pelayanan/input-biaya/',
                    data: {
                        id: id,
                        biaya: biaya,
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },

                    success: function(response) {
                        alert(response.message);
                        // Refresh DataTable setelah menyimpan perubahan
                        $('#datatable-biaya').DataTable().ajax.reload();

                        $('#inputBiaya').modal('hide');
                    },
                    error: function(xhr) {
                        alert('Terjadi kesalahan: ' + xhr.responseText);
                    }
                });
            });
            $('#btnUpdatePembayaran').click(function() {
                // var formData = $('#inputBiaya').serialize();
                var total = $('#formJumlahPembayaran').val();
                var id = $('#idPelayananPembayaran').val();

                $.ajax({
                    type: 'POST',
                    url: '/pembayaran/store',
                    data: {
                        id: id,
                        total: total,
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },

                    success: function(response) {
                        alert(response.message);
                        $('#formJumlahPembayaran').val('');
                        // Refresh DataTable setelah menyimpan perubahan
                        $('#datatable-biaya').DataTable().ajax.reload();
                        $('#datatable-pembayaran').DataTable().ajax.reload();
                    },
                    error: function(xhr) {
                        alert('Terjadi kesalahan: ' + xhr.responseText);
                    }
                });
            });
        });
    </script>
@endpush
