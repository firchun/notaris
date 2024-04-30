<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pelayanan extends Model
{
    use HasFactory;
    protected $table = 'pelayanan';
    protected $guarded = [];

    public function pemohon(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_user');
    }
    public function staff(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_staff');
    }
    public function layanan(): BelongsTo
    {
        return $this->belongsTo(Layanan::class, 'id_layanan');
    }
    public function berkas(): HasMany
    {
        return $this->hasMany(BerkasPelayanan::class, 'id_pelayanan');
    }
    public function formulir(): HasMany
    {
        return $this->hasMany(FormulirPelayanan::class, 'id_pelayanan');
    }
    public function status(): HasMany
    {
        return $this->hasMany(PelayananStatus::class, 'id_pelayanan');
    }
}
