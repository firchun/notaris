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
                        data: 'send',
                        name: 'send'
                    },

                    {
                        data: 'date',
                        name: 'date'
                    },
                    {
                        data: 'capture',
                        name: 'capture'
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
            window.sendWhatsapp = function(id) {
                $.ajax({
                    type: 'GET',
                    url: '/send-wa/' + id,
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        Swal.fire({
                            title: "Confirmation",
                            text: response.status,
                            icon: "warning",
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'OK',
                            cancelButtonText: 'Cancel'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                // Open new tab and redirect to the URL received from the response
                                window.open(response.url, '_blank');

                                // Refresh DataTable after saving changes
                                $('#datatable-biaya').DataTable().ajax.reload();
                            }
                        });

                    },
                    error: function(xhr) {
                        alert('An error occurred: ' + xhr.responseText);
                    }
                });
            };
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
            window.terimaBerkas = function(id) {
                $('#terimaBerkas').modal('show');
                $('#idPelayanan').val(id);
            };
            window.uploadBerkas = function(id) {
                $('#uploadBerkas').modal('show');
                $('#idPelayananUploadBerkas').val(id);
            };
            $('#btnUploadBerkas').click(function() {
                var formData = new FormData($('#formUploadBerkas')[0]);
                $('#uploadText').hide();
                $('#uploadSpinner').show();
                $.ajax({
                    type: 'POST',
                    url: '/berkas/upload-berkas',
                    data: formData,
                    processData: false,
                    contentType: false,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        $('#uploadText').show();
                        $('#uploadSpinner').hide();
                        alert(response.message);
                        $('#idPelayanan').val('');
                        $('#formTermiaBerkasFoto').val('');
                        $('#datatable-pelayanan').DataTable().ajax.reload();
                        $('#uploadBerkas').modal('hide');
                    },
                    error: function(xhr) {
                        $('#uploadText').show();
                        $('#uploadSpinner').hide();
                        alert('Terjadi kesalahan: ' + xhr.responseText);
                    }
                });
            });
            $('#btnTerimaBerkas').click(function() {
                var formData = new FormData($('#formTerimaBerkas')[0]);
                $('#terimaText').hide();
                $('#terimaSpinner').show();
                $.ajax({
                    type: 'POST',
                    url: '/berkas/terima-berkas',
                    data: formData,
                    processData: false,
                    contentType: false,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        $('#terimaText').show();
                        $('#terimaSpinner').hide();
                        alert(response.message);
                        $('#idPelayanan').val('');
                        $('#formTermiaBerkasFoto').val('');
                        $('#datatable-pelayanan').DataTable().ajax.reload();
                        $('#terimaBerkas').modal('hide');
                    },
                    error: function(xhr) {
                        alert('Terjadi kesalahan: ' + xhr.responseText);
                    }
                });
            });
            window.lihatPengajuan = function(id) {
                $('#loadingIcon-' + id).removeClass('d-none');
                $('#buttonText-' + id).addClass('d-none');
                $.ajax({
                    type: 'GET',
                    url: '/pelayanan/show/' + id,
                    success: function(response) {
                        $('#loadingIcon-' + id).addClass('d-none');
                        $('#buttonText-' + id).removeClass('d-none');
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
                        //verified 0 = menunggu
                        // verified 1 = setuju
                        // verified 2 = tolak
                        if (response.is_verified == 0) {
                            $('#btnTerima').show().data('id', response.id);
                            $('#btnTolak').show().data('id', response.id);
                            // $('#btnTolak').show();
                            $('#keteranganPenolakan').show();
                            $('#keteranganTolak').hide();
                        } else if (response.is_verified == 2) {
                            $('#textKeteranganTolak').text(response.keterangan);
                            $('#keteranganTolak').show();
                        } else {
                            $('#keteranganTolak').hide();
                            $('#btnTerima').hide();
                            $('#btnTolak').hide();
                            $('#keteranganPenolakan').hide();
                        }

                        $('#customersModal .body').html(tableHtml);
                        $('#customersModal').modal('show');
                    },
                    error: function(xhr) {
                        alert('Terjadi kesalahan: ' + xhr.responseText);
                    }
                });
                $.ajax({
                    type: 'GET',
                    url: 'berkas/get-api-berkas/' + id,
                    success: function(response) {
                        if (response.length != 0) {
                            var berkasUrl = "{{ Storage::url('') }}" + response.berkas_akhir;
                            berkasUrl = berkasUrl.replace('public/', '');

                            var fotoUrl = "{{ Storage::url('') }}" + response.foto_penerimaan;
                            fotoUrl = fotoUrl.replace('public/', '');
                            var berkasView = '<table class="table table-striped table-bordered">' +
                                '<tr>' +
                                '<td>Berkas Akhir</td>' +
                                '<td><a target="__blank" href="' + berkasUrl +
                                '" class="btn btn-success">Lihat' +
                                'Berkas</a></td>' +
                                '</tr>';

                            if (response.diterima == 1) {
                                berkasView +=
                                    '<tr>' +
                                    '<td>Foto penerimaan</td>' +
                                    '<td><img src="' + fotoUrl +
                                    '" style="width:200px;height:200px;object-fit:cover;"></td>' +
                                    '</tr>';

                            }
                            berkasView += '</table>';

                            $('#customersModal .berkas').html(berkasView);
                        }
                    },
                    error: function(xhr) {
                        alert('Terjadi kesalahan: ' + xhr.responseText);
                    }



                });
            };
        });
        $('#btnTolak').click(function() {
            var keterangan = $('#formKeteranganPenolakan').val();
            var idPelayanan = $(this).data('id');

            if (!keterangan) {
                alert('Keterangan penolakan harus diisi!');
                return;
            }

            $.ajax({
                type: 'POST',
                url: '/pelayanan/tolak/' + idPelayanan,
                data: {
                    keterangan: keterangan,
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    alert(response.message);
                    $('#datatable-pelayanan').DataTable().ajax.reload();
                    $('#customersModal').hide();
                },
                error: function(xhr) {
                    $('#datatable-pelayanan').DataTable().ajax.reload();
                    $('#customersModal').hide();
                    // alert('Terjadi kesalahan: ' + xhr.responseText);
                }
            });
        });
    </script>
@endpush
