<?php

use App\Enums\StatusPengajuan;
use App\Models\Kasir;
use App\Models\Tagihan;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pembayarans', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Kasir::class)->nullable()->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignIdFor(Tagihan::class)->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->string('keterangan');
            $table->date('tanggal_bayar')->nullable();
            $table->date('tanggal_pengajuan')->nullable();
            $table->enum('status_pengajuan', StatusPengajuan::toArray())->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembayarans');
    }
};
