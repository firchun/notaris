<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PembayaranPelayanan extends Model
{
    use HasFactory;
    protected $table = 'pembayaran_pelayanan';
    protected $guarded = [];
    public function pelayanan(): BelongsTo
    {
        return $this->belongsTo(Pelayanan::class, 'id_pelayanan');
    }
    public function staff(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_staff');
    }
}
