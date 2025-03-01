<?php

use App\Models\SubTagihan;
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
        $tagihan = Tagihan::with('pelanggan.paketLangganan')->get();

        $combinedData = [];
        foreach ($tagihan as $data) {
            $namaTagihan = $data->pelanggan->paketLangganan->nama;
            $harga = $data->total_tagihan;

            $combinedData[] = [
                'tagihan_id' => $data->id,
                'keterangan' => $namaTagihan,
                'dapat_dihapus' => false,
                'nominal' => $harga,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('sub_tagihans')->insert($combinedData);

        Schema::table('tagihans', function (Blueprint $table) {
            $table->dropColumn('total_tagihan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tagihans', function (Blueprint $table) {
            $table->bigInteger('total_tagihan')->nullable();
        });

        $subTagihan = SubTagihan::with('tagihan')->get();

        foreach ($subTagihan as $data) {
            $tagihan = $data->tagihan;
            $tagihan->total_tagihan += $data->nominal;
            $tagihan->save();
        }

        Schema::table('tagihans', function (Blueprint $table) {
            $table->bigInteger('total_tagihan')->nullable(false)->change();
        });
    }
};
