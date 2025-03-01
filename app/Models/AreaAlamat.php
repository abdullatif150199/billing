<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AreaAlamat extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function pengguna(): HasMany
    {
        return $this->hasMany(Pelanggan::class);
    }
}
