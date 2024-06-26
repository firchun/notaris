<!-- Modal for Create and Edit -->
<div class="modal fade" id="berkasModal" tabindex="-1" aria-labelledby="customersModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="userModalLabel">Ubah Berkas</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Form for Create and Edit -->
                <form id="berkasForm">
                    <input type="hidden" id="formBerkasId" name="id">
                    <input type="hidden" id="formLayananId" name="id_layanan">
                    <div class="mb-3">
                        <label for="formNamaBerkas" class="form-label">Nama Berkas</label>
                        <input type="text" class="form-control" id="formNamaBerkas" name="nama_berkas" required>
                    </div>
                    <div class="mb-3">
                        <label for="formNamaBerkas" class="form-label">Pengisian</label>
                        <select name="is_required" class="form-select" id="formSelectRequired">
                            <option value="1">Wajib diisi</option>
                            <option value="0">Opsional</option>
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="saveBerkasBtn">Save</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="create" tabindex="-1" aria-labelledby="customersModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="userModalLabel">Tambah Berkas</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Form for Create and Edit -->
                <form id="createBerkasForm">
                    <input type="hidden" id="formLayananId" name="id_layanan" value="{{ $layanan->id }}">
                    <div class="mb-3">
                        <label for="formNamaBerkas" class="form-label">Nama Berkas</label>
                        <input type="text" class="form-control" id="formNamaBerkas" name="nama_berkas" required>
                    </div>
                    <div class="mb-3">
                        <label for="formNamaBerkas" class="form-label">Pengisian</label>
                        <select name="is_required" class="form-select" id="formSelectRequired">
                            <option value="1">Wajib diisi</option>
                            <option value="0">Opsional</option>
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="createBerkasBtn">Save</button>
            </div>
        </div>
    </div>
</div>
