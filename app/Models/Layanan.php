<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Layanan extends Model
{
    use HasFactory;
    protected $table = 'layanan';
    protected $guarded = [];
    public function formulir_pelayanan(): HasMany
    {
        return $this->hasMany(FormulirPelayanan::class, 'id_layanan');
    }
}
