<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pelanggan extends Model
{
    use HasFactory;

    public $incrementing = false;

    protected $guarded = [];

    protected $casts = [
        'tanggal_register' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function areaAlamat(): BelongsTo
    {
        return $this->belongsTo(AreaAlamat::class);
    }

    public function paketLangganan(): BelongsTo
    {
        return $this->belongsTo(PaketLangganan::class);
    }

    public function tagihan(): HasMany
    {
        return $this->hasMany(Tagihan::class);
    }
}
