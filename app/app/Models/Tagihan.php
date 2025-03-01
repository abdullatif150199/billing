<?php

namespace App\Models;

use App\Enums\StatusPengajuan;
use App\Enums\StatusTagihan;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Tagihan extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'status_pengajuan' => StatusPengajuan::class,
        'status_tagihan' => StatusTagihan::class,
        'tanggal_tagihan' => 'date',
        'tanggal_bayar' => 'date',
    ];

    public function pelanggan(): BelongsTo
    {
        return $this->belongsTo(Pelanggan::class);
    }

    // public function totalTagihanOverdue()
    // {
    //     return Tagihan::where('pelanggan_id', $this->pelanggan_id)
    //         ->where('id', '!=', $this->id)
    //         ->whereMonth('tanggal_tagihan', '<=', $this->tanggal_tagihan->month)
    //         ->whereYear('tanggal_tagihan', '<=', $this->tanggal_tagihan->year)
    //         ->where('status_tagihan', StatusTagihan::TERLAMBAT)
    //         ->sum('total_tagihan');
    // }

    public function getNominal(): int
    {
        return $this->subtagihan->sum('nominal');
    }

    public function subtagihan(): HasMany
    {
        return $this->hasMany(SubTagihan::class);
    }

    public function pembayaran(): HasMany
    {
        return $this->hasMany(Pembayaran::class);
    }

    public function getUnpayedNominal(): int
    {
        return $this->subtagihan()->where('terbayar', false)->sum('nominal');
    }

    public function getFirstKeterangan(): string
    {
        return $this->subtagihan->where('terbayar', false)->where('nominal', '>=', 0)->first()->keterangan;
    }
}
