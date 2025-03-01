<?php

use App\Enums\StatusPengajuan;
use App\Models\Kasir;
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
        Schema::table('tagihans', function (Blueprint $table) {
            $table->date('tanggal_pengajuan')->nullable();
            $table->enum('status_pengajuan', StatusPengajuan::toArray())->nullable();
            $table->foreignIdFor(Kasir::class)->nullable()->constrained()->cascadeOnUpdate()->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tagihans', function (Blueprint $table) {
            $table->dropColumn('tanggal_pengajuan');
            $table->dropColumn('status_pengajuan');
            $table->dropColumn('kasir_id');
        });
    }
};
