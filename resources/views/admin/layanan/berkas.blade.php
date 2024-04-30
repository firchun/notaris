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
                            <button class="btn btn-secondary create-new btn-primary" type="button" data-bs-toggle="modal"
                                data-bs-target="#create">
                                <span>
                                    <i class="bx bx-plus me-sm-1"> </i>
                                    <span class="d-none d-sm-inline-block">Tambah Data</span>
                                </span>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="card-datatable table-responsive">
                    <table id="datatable-berkas" class="table table-hover table-bordered display">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nama Berkas</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        <tfoot>
                            <tr>
                                <th>ID</th>
                                <th>Nama Berkas</th>
                                <th>Action</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @include('admin.layanan.components.modal_berkas')
@endsection
@push('js')
    <script>
        $(function() {
            $('#datatable-berkas').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                ajax: '{{ url('berkas-datatable', $layanan->id) }}',
                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'nama_berkas',
                        name: 'nama_berkas'
                    },
                    {
                        data: 'action',
                        name: 'action'
                    }
                ]
            });
            $('.create-new').click(function() {
                $('#create').modal('show');
            });
            window.editBerkas = function(id) {
                $.ajax({
                    type: 'GET',
                    url: '/berkas/edit/' + id,
                    success: function(response) {
                        $('#formBerkasId').val(response.id);
                        $('#formLayananId').val(response.id_layanan);
                        $('#formNamaBerkas').val(response.nama_berkas);
                        $('#berkasModal').modal('show');
                    },
                    error: function(xhr) {
                        alert('Terjadi kesalahan: ' + xhr.responseText);
                    }
                });
            };

            $('#saveBerkasBtn').click(function() {
                var formData = $('#berkasForm').serialize();

                $.ajax({
                    type: 'POST',
                    url: '/berkas/store',
                    data: formData,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        alert(response.message);
                        // Refresh DataTable setelah menyimpan perubahan
                        $('#datatable-berkas').DataTable().ajax.reload();
                        $('#berkasModal').modal('hide');
                    },
                    error: function(xhr) {
                        alert('Terjadi kesalahan: ' + xhr.responseText);
                    }
                });
            });
            $('#createBerkasBtn').click(function() {
                var formData = $('#createBerkasForm').serialize();

                $.ajax({
                    type: 'POST',
                    url: '/berkas/store',
                    data: formData,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        alert(response.message);
                        $('#formNamaBerkas').val('');
                        $('#datatable-berkas').DataTable().ajax.reload();
                        $('#create').modal('hide');
                    },
                    error: function(xhr) {
                        alert('Terjadi kesalahan: ' + xhr.responseText);
                    }
                });
            });
            window.deleteBerkas = function(id) {
                if (confirm('Apakah Anda yakin ingin menghapus berkas ini?')) {
                    $.ajax({
                        type: 'DELETE',
                        url: '/berkas/delete/' + id,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            // alert(response.message);
                            $('#datatable-berkas').DataTable().ajax.reload();
                        },
                        error: function(xhr) {
                            alert('Terjadi kesalahan: ' + xhr.responseText);
                        }
                    });
                }
            };
        });
    </script>
@endpush
