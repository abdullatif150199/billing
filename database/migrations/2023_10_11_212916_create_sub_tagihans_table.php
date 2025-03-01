<?php

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
        Schema::create('sub_tagihans', function (Blueprint $table) {
            $table->id();
            $table->string('keterangan');
            $table->bigInteger('nominal');
            $table->boolean('terbayar')->default(false);
            $table->boolean('dapat_dihapus')->default(true);
            $table->foreignIdFor(Tagihan::class);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sub_tagihans');
    }
};
