<!-- Modal for Create and Edit -->
<div class="modal fade" id="formulirModal" tabindex="-1" aria-labelledby="customersModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="userModalLabel">Ubah Syarat</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Form for Create and Edit -->
                <form id="formulirForm">
                    <input type="hidden" id="formFomulirId" name="id">
                    <input type="hidden" id="formLayananId" name="id_layanan">
                    <div class="mb-3">
                        <label for="formNamaFormulir" class="form-label">Nama Syarat/form</label>
                        <input type="text" class="form-control" id="formNamaFormulir" name="nama_formulir" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="saveFormulirBtn">Save</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="create" tabindex="-1" aria-labelledby="customersModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="userModalLabel">Tambah Syarat</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Form for Create and Edit -->
                <form id="createFormulirForm">
                    <input type="hidden" id="formLayananId" name="id_layanan" value="{{ $layanan->id }}">
                    <div class="mb-3">
                        <label for="formNamaFormulir" class="form-label">Nama Syarat/form</label>
                        <input type="text" class="form-control" id="formNamaFormulir" name="nama_formulir" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="createFormulirBtn">Save</button>
            </div>
        </div>
    </div>
</div>
