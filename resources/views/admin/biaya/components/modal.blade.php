<!-- Modal for Create and Edit -->
<div class="modal fade" id="inputBiaya" tabindex="-1" aria-labelledby="customersModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">
                <form id="inputBiaya">
                    <h4>Input Biaya Layanan</h4>
                    <input type="hidden" name="id" id="idPelayanan">
                    <div class="mb-3">
                        <label for="formBiaya" class="form-label">Jumlah Biaya</label>
                        <input type="number" class="form-control" id="formBiaya" name="biaya" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="btnInputBiaya">Save</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="updatePembayaran" tabindex="-1" aria-labelledby="customersModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-body">
                <h4>Pembayaran</h4>
                <form id="updatePembayaran" enctype="multipart/form-data">
                    <input type="hidden" name="id" id="idPelayananPembayaran">
                    <div class="mb-3">
                        <label for="fotoPembayaran" class="form-label">Bukti Pembayaran <small
                                class="text-muted">(Berupa bukti transfer atau kwitansi)</small></label>
                        <input type="file" class="form-control" id="fotoPembayaran" name="foto">
                    </div>
                    <div class="mb-3">
                        <label for="formJumlahPembayaran" class="form-label">Jumlah Pembayaran</label>
                        <input type="number" class="form-control" id="formJumlahPembayaran" name="biaya" required>
                    </div>
                </form>
                <button type="button" class="btn btn-primary" id="btnUpdatePembayaran">Tambah Pembayaran</button>
                <hr>
                <div class="mt-4">
                    <div class=" table-responsive">
                        <table id="datatable-pembayaran" class="table table-hover table-bordered display">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Foto</th>
                                    <th>Total Bayar</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>ID</th>
                                    <th>Foto</th>
                                    <th>Total Bayar</th>
                                    <th>Action</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
