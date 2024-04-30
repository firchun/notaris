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
                <form id="layananForm">
                    <input type="hidden" id="formLayananId" name="id">
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
                <button type="button" class="btn btn-primary" id="saveLayananBtn">Save</button>
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
                    {{-- <div class="mb-3">
                        <label for="formKeteranganLayanan" class="form-label">Keterangan Layanan</label>
                        <div id="editorCreate"></div>
                        <input type="hidden" name="deskripsi" id="#hidden-editor-create">
                    </div> --}}
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="createLayananBtn">Save</button>
            </div>
        </div>
    </div>
</div>
{{-- <script src="https://cdn.jsdelivr.net/npm/quill@2.0.0-rc.4/dist/quill.js"></script>
<script>
    var editor1 = new Quill('#editor', {
        theme: 'snow' // Tema Quill yang ingin Anda gunakan (snow atau bubble)
    });
    var form1 = document.querySelector('#layananForm');
    form1.onsubmit = function() {
        var editorContent = document.querySelector('#editor .ql-editor').innerHTML;
        document.querySelector('#hidden-editor').value = editorContent;
    };
    var editor2 = new Quill('#editorCreate', {
        theme: 'snow' // Tema Quill yang ingin Anda gunakan (snow atau bubble)
    });
    var form2 = document.querySelector('#createLayananForm');
    form2.onsubmit = function() {
        var editorContent = document.querySelector('#editorCreate .ql-editor').innerHTML;
        document.querySelector('#hidden-editor-create').value = editorContent;
    };
</script> --}}
