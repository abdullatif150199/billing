<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class SubTagihan extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function tagihan(): BelongsTo
    {
        return $this->belongsTo(Tagihan::class);
    }

    public function pembayaran(): BelongsToMany
    {
        return $this->belongsToMany(Pembayaran::class)->using(PembayaranSubTagihan::class);
    }
}
