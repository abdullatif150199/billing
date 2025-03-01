<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PaketLangganan extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function pelanggans(): HasMany
    {
        return $this->hasMany(Pelanggan::class);
    }
}
