<?php

use App\Models\AreaAlamat;
use App\Models\PaketLangganan;
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
        Schema::table('pelanggans', function (Blueprint $table) {
            $table->foreignIdFor(PaketLangganan::class)->change()->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignIdFor(AreaAlamat::class)->change()->constrained()->cascadeOnUpdate()->restrictOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
