<!-- Modal for Create and Edit -->
<div class="modal fade" id="customersModal" tabindex="-1" aria-labelledby="customersModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="userModalLabel">Ubah Layanan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Form for Create and Edit -->
                <form id="userForm">
                    <input type="hidden" id="formCustomerId" name="id">
                    <div class="mb-3">
                        <label for="formNamaLayanan" class="form-label">Name</label>
                        <input type="text" class="form-control" id="formNamaLayanan" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="formCustomerPhone" class="form-label">Phone</label>
                        <input type="number" class="form-control" id="formCustomerPhone" name="phone" required>
                    </div>
                    <div class="mb-3">
                        <label for="formCustomerAddress" class="form-label">Address</label>
                        <input type="text" class="form-control" id="formCustomerAddress" name="address" required>
                    </div>

                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="saveCustomerBtn">Save</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="create" tabindex="-1" aria-labelledby="customersModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="userModalLabel">Tambah Layanan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Form for Create and Edit -->
                <form id="createLayananForm">
                    <div class="mb-3">
                        <label for="formNamaLayanan" class="form-label">Nama Layanan</label>
                        <input type="text" class="form-control" id="formNamaLayanan" name="nama_layanan" required>
                    </div>
                    <div class="mb-3">
                        <label for="formJenisLayanan" class="form-label">Jenis Layanan</label>
                        <select id="formJenisLayanan" name="jenis_layanan" class="form-select">
                            <option value="PPAT">PPAT</option>
                            <option value="Notaris">Notaris</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="formKeteranganLayanan" class="form-label">Keterangan Layanan</label>
                        <textarea class="form-control" name="deskripsi" id="formKeteranganLayanan"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="createLayananBtn">Save</button>
            </div>
        </div>
    </div>
</div>
