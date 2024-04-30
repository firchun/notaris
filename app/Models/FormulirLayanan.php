<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class FormulirLayanan extends Model
{
    use HasFactory;
    protected $table = 'formulir_layanan';
    protected $guarded = [];

    public function layanan(): BelongsTo
    {
        return $this->belongsTo(Layanan::class, 'id_layanan');
    }
    public function formulir_pelayanan(): HasMany
    {
        return $this->hasMany(FormulirPelayanan::class, 'id_formulir_layanan');
    }
}
