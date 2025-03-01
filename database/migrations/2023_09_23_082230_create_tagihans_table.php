<?php

use App\Enums\StatusTagihan;
use App\Models\Pelanggan;
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
        Schema::create('tagihans', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Pelanggan::class)->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->bigInteger('total_tagihan');
            $table->enum('status_tagihan', StatusTagihan::toArray())->default(StatusTagihan::BELUM_BAYAR->name);
            $table->date('tanggal_tagihan'); // Untuk jaga jaga
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tagihans');
    }
};
