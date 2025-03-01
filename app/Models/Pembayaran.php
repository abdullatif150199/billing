<?php

namespace App\Models;

use App\Enums\StatusPengajuan;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Pembayaran extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'status_pengajuan' => StatusPengajuan::class,
        'tanggal_pengajuan' => 'date',
        'tanggal_bayar' => 'date',
    ];

    public function tagihan(): BelongsTo
    {
        return $this->belongsTo(Tagihan::class);
    }

    public function subtagihan(): BelongsToMany
    {
        return $this->belongsToMany(SubTagihan::class)->using(PembayaranSubTagihan::class);
    }

    public function getNominal(): int
    {
        return $this->subtagihan->sum('nominal');
    }
}
