<!-- Modal for Create and Edit -->
<div class="modal fade" id="customersModal" tabindex="-1" aria-labelledby="customersModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="userModalLabel">Lihat Pengajuan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="body">

                </div>
                <div class="berkas">

                </div>
                <!-- Form for Create and Edit -->
                <form id="keteranganPenolakan" style="display: none;">
                    <hr>
                    <label class="text-danger">Keterangan Penolakan</label>
                    <textarea class="form-control" name="keterangan" id="formKeteranganPenolakan"></textarea>
                </form>
                <div class="text-danger" id="keteranganTolak">
                    <hr>
                    Pengajuan ditolak dengan keterangan :<br>
                    <strong class="" id="textKeteranganTolak"></strong>
                </div>
            </div>
            <div class="modal-footer">
                @if (Auth::user()->role == 'Staff')
                    <button type="button" class="btn btn-success btn-action" data-action="terima" id="btnTerima"
                        style="display: none;">Terima</button>
                    <button type="button" class="btn btn-danger " id="btnTolak" style="display: none;">Tolak</button>
                @endif
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="terimaBerkas" tabindex="-1" aria-labelledby="customersModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="userModalLabel">Penerimaan Berkas</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Form for Create and Edit -->
                <form id="formTerimaBerkas">
                    <input type="hidden" name="id_pelayanan" id="idPelayanan">
                    <div class="mb-3">
                        <label for="formTermiaBerkasFoto" class="form-label">Bukti Penerimaan</label>
                        <input type="file" class="form-control" id="formTermiaBerkasFoto" name="foto" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary " id="btnTerimaBerkas">
                    <span id="terimaText">Simpan</span>
                    <span id="terimaSpinner" style="display: none;">
                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                        <span class="visually-hidden">Loading...</span>
                    </span>
                </button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="uploadBerkas" tabindex="-1" aria-labelledby="customersModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="userModalLabel">Upload Berkas yang telah selesai</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Form for Create and Edit -->
                <form id="formUploadBerkas" enctype="multipart/form-data">
                    <input type="hidden" name="id_pelayanan" id="idPelayananUploadBerkas">
                    <div class="mb-3">
                        <label for="formUploadBerkasAkhir" class="form-label">Upload Berkas</label>
                        <input type="file" class="form-control" id="formUploadBerkasAkhir" name="berkas_akhir"
                            required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary " id="btnUploadBerkas">
                    <span id="uploadText">Upload</span>
                    <span id="uploadSpinner" style="display: none;">
                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                        <span class="visually-hidden">Loading...</span>
                    </span>
                </button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
