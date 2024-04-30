<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BerkasPelayanan extends Model
{
    use HasFactory;
    protected $table = 'berkas_pelayanan';
    protected $guarded = [];
    public function berkas_layanan(): BelongsTo
    {
        return $this->belongsTo(BerkasLayanan::class, 'id_berkas_layanan');
    }
}
