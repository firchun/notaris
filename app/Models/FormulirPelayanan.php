<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class FormulirPelayanan extends Model
{
    use HasFactory;
    protected $table = 'formulir_pelayanan';
    protected $guarded = [];
    public function formulir_layanan(): BelongsTo
    {
        return $this->belongsTo(FormulirLayanan::class, 'id_formulir_layanan');
    }
}
