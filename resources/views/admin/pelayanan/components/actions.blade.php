<div class="btn-group">
    <button class="btn btn-sm btn-primary" onclick="lihatPengajuan({{ $pelayanan->id }})">
        <span id="loadingIcon" class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
        <span id="buttonText">Lihat Pengajuan</span>
    </button>
    @if (Auth::user()->role == 'Staff' && $pelayanan->is_paid == 1)
        @if ($cek_berkas->count() == 0)
            <button class="btn btn-sm btn-success" onclick="uploadBerkas({{ $pelayanan->id }})">
                <span id="loadingIcon" class="spinner-border spinner-border-sm d-none" role="status"
                    aria-hidden="true"></span>
                <span id="buttonText">Upload Berkas</span>
            </button>
        @else
            @if ($cek_berkas->first()->diterima == 0)
                <button class="btn btn-sm btn-success" onclick="terimaBerkas({{ $pelayanan->id }})">
                    <span id="loadingIcon" class="spinner-border spinner-border-sm d-none" role="status"
                        aria-hidden="true"></span>
                    <span id="buttonText">Penerimaan Berkas</span>
                </button>
            @endif
        @endif
    @endif
</div>
