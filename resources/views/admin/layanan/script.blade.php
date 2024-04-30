@push('js')
    <script>
        $(function() {
            $('#datatable-layanans').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                ajax: '{{ url('layanans-datatable') }}',
                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'gambar',
                        name: 'gambar'
                    },
                    {
                        data: 'nama_layanan',
                        name: 'nama_layanan'
                    },
                    {
                        data: 'jenis',
                        name: 'jenis'
                    },
                    {
                        data: 'berkas',
                        name: 'berkas'
                    },
                    {
                        data: 'formulir',
                        name: 'formulir'
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
            $('.refresh').click(function() {
                $('#datatable-layanans').DataTable().ajax.reload();
            });
            window.editLayanan = function(id) {
                $.ajax({
                    type: 'GET',
                    url: '/layanan/edit/' + id,
                    success: function(response) {
                        $('#customersModalLabel').text('Edit Customer');
                        $('#formLayananId').val(response.id);
                        $('#formNamaLayanan').val(response.nama_layanan);
                        $('#formKeteranganLayanan').val(response.deskripsi);
                        $('#customersModal').modal('show');
                    },
                    error: function(xhr) {
                        alert('Terjadi kesalahan: ' + xhr.responseText);
                    }
                });
            };
            window.berkasLayanan = function(id) {
                var url = "/layanan/berkas/" + id;
                window.location.href = url;
            };
            window.syaratLayanan = function(id) {
                var url = "/layanan/formulir/" + id;
                window.location.href = url;
            };
            $('#saveLayananBtn').click(function() {
                var formData = $('#layananForm').serialize();

                $.ajax({
                    type: 'POST',
                    url: '/layanan/store',
                    data: formData,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        alert(response.message);
                        // Refresh DataTable setelah menyimpan perubahan
                        $('#datatable-layanans').DataTable().ajax.reload();
                        $('#customersModal').modal('hide');
                    },
                    error: function(xhr) {
                        alert('Terjadi kesalahan: ' + xhr.responseText);
                    }
                });
            });
            $('#createLayananBtn').click(function() {
                var formData = $('#createLayananForm').serialize();

                $.ajax({
                    type: 'POST',
                    url: '/layanan/store',
                    data: formData,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        alert(response.message);
                        $('#customersModalLabel').text('Edit Customer');
                        $('#formNamaLayanan').val('');
                        $('#formKeteranganLayanan').val('');
                        $('#datatable-layanans').DataTable().ajax.reload();
                        $('#create').modal('hide');
                    },
                    error: function(xhr) {
                        alert('Terjadi kesalahan: ' + xhr.responseText);
                    }
                });
            });
            window.deleteLayanan = function(id) {
                if (confirm('Apakah Anda yakin ingin menghapus layanan ini?')) {
                    $.ajax({
                        type: 'DELETE',
                        url: '/layanan/delete/' + id,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            // alert(response.message);
                            $('#datatable-layanans').DataTable().ajax.reload();
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
