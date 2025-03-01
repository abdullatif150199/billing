<?php

use App\Models\Pembayaran;
use App\Models\SubTagihan;
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
        Schema::create('pembayaran_sub_tagihan', function (Blueprint $table) {
            $table->foreignIdFor(SubTagihan::class)->constrained()->restrictOnDelete()->cascadeOnUpdate();
            $table->foreignIdFor(Pembayaran::class)->constrained()->restrictOnDelete()->cascadeOnUpdate();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembayaran_sub_tagihan');
    }
};
