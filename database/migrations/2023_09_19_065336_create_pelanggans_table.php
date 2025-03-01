<?php

use App\Models\AreaAlamat;
use App\Models\PaketLangganan;
use App\Models\User;
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
        Schema::create('pelanggans', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignIdFor(User::class);
            $table->string('nama', 255);
            $table->string('foto_rumah', 255);
            $table->string('serial_number_modem', 255);
            $table->string('ip_address', 255);
            $table->foreignIdFor(PaketLangganan::class);
            $table->foreignIdFor(AreaAlamat::class);
            $table->date('tanggal_register');
            $table->integer('tanggal_tagihan');
            $table->integer('tanggal_jatuh_tempo');
            $table->text('google_map');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pelanggans');
    }
};
