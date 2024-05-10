<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Notifikasi extends Model
{
    use HasFactory;
    protected $table = 'notifikasi';
    protected $guarded = [];

    public function user(): BelongsTo
    {
        return $this->BelongsTo(User::class, 'id_user');
    }
    static function getUserNotifikasi($id)
    {
        return Self::where('id_user', $id)->where('dibaca', 0)->get();
    }
    static function getCountNotifikasi($id)
    {
        return Self::where('id_user', $id)->where('dibaca', 0)->count();
    }
}
