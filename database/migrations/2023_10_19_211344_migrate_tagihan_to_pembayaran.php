<?php

use App\Enums\StatusPengajuan;
use App\Enums\StatusTagihan;
use App\Models\Kasir;
use App\Models\Pembayaran;
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
        $tagihans = Tagihan::with('subtagihan')->where('status_pengajuan', '!=', null)->orWhere('tanggal_bayar', '!=', null)->get();

        foreach ($tagihans as $tagihan) {

            $keterangan = $tagihan->tanggal_tagihan->translatedFormat('F');

            $pembayaran = Pembayaran::create([
                'tagihan_id' => $tagihan->id,
                'kasir_id' => $tagihan->kasir_id,
                'keterangan' => $keterangan,
                'tanggal_bayar' => $tagihan->tanggal_bayar,
                'status_pengajuan' => $tagihan->status_pengajuan,
                'tanggal_pengajuan' => $tagihan->tanggal_pengajuan,
            ]);

            $subtagihans = $tagihan->subtagihan()->where('terbayar', false)->get();

            foreach ($subtagihans as $subtagihan) {
                if ($tagihan->tanggal_bayar != null) {
                    $subtagihan->fill(['terbayar' => true]);
                    $subtagihan->save();
                }

                $subtagihan->pembayaran()->attach($pembayaran->id);
            }
        }

        Schema::table('tagihans', function (Blueprint $table) {
            $table->dropColumn('tanggal_bayar');
            $table->dropColumn('tanggal_pengajuan');
            $table->dropColumn('status_pengajuan');
            $table->dropForeignIdFor(Kasir::class);
            $table->dropColumn('kasir_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tagihans', function (Blueprint $table) {
            $table->date('tanggal_bayar')->nullable();
            $table->date('tanggal_pengajuan')->nullable();
            $table->enum('status_pengajuan', StatusPengajuan::toArray())->nullable();
            $table->foreignIdFor(Kasir::class)->nullable()->constrained()->cascadeOnUpdate()->cascadeOnDelete();
        });
    }
};
