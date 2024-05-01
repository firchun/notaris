@push('js')
    <script>
        $(function() {
            $('#datatable-pelayanan').DataTable({
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
                        data: 'status',
                        name: 'status'
                    },
                    {
                        data: 'action',
                        name: 'action'
                    }
                ]
            });
            $('.refresh').click(function() {
                $('#datatable-pelayanan').DataTable().ajax.reload();
            });
            $('.btn-action').click(function() {
                var id = $(this).data('id');
                var action = $(this).data('action');
                $.ajax({
                    type: 'GET',
                    url: '/pelayanan/' + action + '/' +
                        id,
                    success: function(response) {
                        alert(response.message)
                        $('#customersModal').modal('hide');
                        $('#datatable-layanans').DataTable().ajax.reload();
                    },
                    error: function(xhr) {
                        alert('Terjadi kesalahan: ' + xhr.responseText);
                    }
                });
            });
            window.lihatPengajuan = function(id) {
                $('#loadingIcon').removeClass('d-none');
                $('#buttonText').addClass('d-none');
                $.ajax({
                    type: 'GET',
                    url: '/pelayanan/show/' + id,
                    success: function(response) {
                        $('#loadingIcon').addClass('d-none');
                        $('#buttonText').removeClass('d-none');
                        var tableHtml = '<table class="table table-striped table-bordered">' +
                            '<tr>' +
                            '<td>Nomor Dokumen</td>' +
                            '<td>' + response.no_dokumen + '</td>' +
                            '</tr>' +
                            '<tr>' +
                            '<td>Nama Pemohon</td>' +
                            '<td>' + response.nama_pemohon + '</td>' +
                            '</tr>' +
                            '<tr>' +
                            '<td>Layanan</td>' +
                            '<td>' + response.layanan.nama_layanan + '</td>' +
                            '</tr>';

                        tableHtml +=
                            '<tr><td colspan="2"><strong>Formulir</strong></td></tr>';
                        $.each(response.formulir, function(index, itemForm) {
                            tableHtml += '<tr>' +
                                '<td>' + itemForm.formulir_layanan.nama_formulir + '</td>' +
                                '<td>' + itemForm.isi_formulir + '</td>' +
                                '</tr>';
                        });
                        tableHtml +=
                            '<tr><td colspan="2"><strong>Berkas</strong></td></tr>';
                        $.each(response.berkas, function(index, itemBerkas) {
                            var berkasUrl = "{{ Storage::url('') }}" + itemBerkas.berkas;
                            berkasUrl = berkasUrl.replace('public/', '');
                            tableHtml += '<tr>' +
                                '<td>' + itemBerkas.berkas_layanan.nama_berkas + '</td>' +
                                '<td><a target="__blank" href="' + berkasUrl +
                                '" class="btn btn-success">Lihat' +
                                'Berkas</a></td>' +
                                '</tr>';
                            console.log(berkasUrl);
                        });

                        tableHtml += '</table>';
                        if (response.is_verified == 0) {
                            $('#btnTerima').show().data('id', response.id);
                            $('#btnTolak').show().data('id', response.id);
                        } else {
                            $('#btnTerima').hide();
                            $('#btnTolak').hide();
                        }

                        $('#customersModal .modal-body').html(tableHtml);
                        $('#customersModal').modal('show');
                    },
                    error: function(xhr) {
                        alert('Terjadi kesalahan: ' + xhr.responseText);
                    }
                });
            };
        });
    </script>
@endpush
