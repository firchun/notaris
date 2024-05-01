@extends('layouts.frontend.app')

@section('content')
    <section id="main-container " class="main-container pb-1">
        <div class="container">
            <div class="row text-center">
                <div class="col-12">
                    <h3 class="section-sub-title">{{ $title ?? '-' }}</h3>
                </div>
            </div>
        </div>
    </section>
    <section class="subscribe no-padding mb-5">
        <div class="container">
            <div class="row">
                {{-- <div class="col-lg-4">
                    <div class="subscribe-call-to-acton">
                        <h3>Can We Help?</h3>
                        <h4>(+9) 847-291-4353</h4>
                    </div>
                </div><!-- Col end --> --}}

                <div class="col-lg-12">
                    <div class="ts-newsletter row align-items-center">
                        <div class="col-md-5 newsletter-introtext">
                            <h4 class="text-white mb-0">{{ $title }}</h4>
                            <p class="text-white">Cek status pengajuan dokumen anda</p>
                        </div>

                        <div class="col-md-7 newsletter-form">
                            <form action="#" method="post">
                                <div class="form-group d-flex">
                                    <label for="newsletter-email" class="content-hidden">Nomor Dokumen</label>
                                    <input type="text" id="nomor" class="form-control form-control-lg"
                                        placeholder="Nomor Dokumen" autocomplete="off">
                                    <button type="button" class="btn btn-outline-light ml-2" id="cekDokumen">Cek</button>
                                </div>
                            </form>
                        </div>
                    </div><!-- Newsletter end -->
                </div><!-- Col end -->

            </div><!-- Content row end -->
        </div>
        <!--/ Container end -->
    </section>
    <section class="section container">
        <div id="statusDokumen"></div>
        <div id="trackingDokumen" class="mt-3"></div>
    </section>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>

    <script>
        $(document).ready(function() {

            $('#cekDokumen').click(function() {
                var nomor = $('#nomor').val();
                $.ajax({
                    type: 'GET',
                    url: '/dokumen/' + nomor,
                    success: function(response) {
                        var pelayanan = response;
                        var lastStatus = pelayanan.status[pelayanan.status.length - 1];
                        var tableHtml =
                            '<h4 class="text-center">Informasi Dokumen</h4><table class="table table-hover table-bordered">' +
                            '<tr>' +
                            '<td>Nomor Dokumen</td>' +
                            '<td>' + pelayanan.no_dokumen + '</td>' +
                            '</tr>' +
                            '<tr>' +
                            '<td>Nama Pemohon</td>' +
                            '<td>' + pelayanan.pemohon.name + '</td>' +
                            '</tr>' +
                            '<tr>' +
                            '<td>Layanan</td>' +
                            '<td>' + pelayanan.layanan.nama_layanan + '</td>' +
                            '</tr>' +
                            '<tr>' +
                            '<td>Status</td>' +
                            '<td>' + lastStatus + '</td>' +
                            '</tr>';
                        tableHtml += '</table>';
                        $('#statusDokumen').html(tableHtml);
                    },
                    error: function(xhr) {
                        alert('Terjadi kesalahan: ' + xhr.responseText);
                    }
                });
                $.ajax({
                    type: 'GET',
                    url: '/dokumen/' + nomor,
                    success: function(response) {
                        var status = response;
                        var tableHtml =
                            '<hr><h4 class="text-center">Tracking Dokumen</h4><table class="table table-hover table-bordered">' +
                            '<tr><th>#</th><th>Tanggal</th><th>Status Dokumen</th></tr>';
                        $.each(response.status, function(index, status) {
                            var formattedDate = moment(status.created_at).format(
                                'D MMMM YYYY');
                            tableHtml += '<tr>' +
                                '<td>' + status.id + '</td>' +
                                '<td>' + formattedDate + '</td>' +
                                '<td>' + status.status + '</td>' +
                                '</tr>';
                        });
                        tableHtml += '</table>';
                        $('#trackingDokumen').html(tableHtml);
                    },
                    error: function(xhr) {
                        alert('Terjadi kesalahan: ' + xhr.responseText);
                    }
                });


            });
        });
    </script>
@endsection
