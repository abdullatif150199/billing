<?php

use App\Models\Tagihan;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('tagihans', function (Blueprint $table) {
            $table->date('tanggal_bayar')->nullable();
        });

        $currentDate = now();

        Tagihan::whereYear('updated_at', $currentDate->year)
            ->whereMonth('updated_at', $currentDate->month)
            ->update(['tanggal_bayar' => DB::raw('updated_at')]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tagihans', function (Blueprint $table) {
            $table->dropColumn('tanggal_bayar');
        });
    }
};
