<div class="btn-group">
    @if ($pelayanan->biaya == 0)
        <button class="btn btn-sm btn-primary" onclick="inputBiaya({{ $pelayanan->id }})">Input Biaya</button>
    @else
        @if ($pelayanan->is_continue == 0)
            <span>Menunggu persetujuan</span>
        @elseif ($pelayanan->is_continue == 1)
            @if ($pelayanan->is_paid == 1)
                <button class="btn btn-sm btn-primary" onclick="updatePembayaran({{ $pelayanan->id }})">
                    Riwayat
                    Pembayaran
                </button>
            @else
                <button class="btn btn-sm btn-primary" onclick="updatePembayaran({{ $pelayanan->id }})">
                    Update
                    Pembayaran
                </button>
            @endif
        @else
            <span class="text-danger"> Dihentikan</span>
        @endif
    @endif
</div>
