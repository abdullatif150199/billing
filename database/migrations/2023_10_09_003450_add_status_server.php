<?php

use App\Models\DataMaster;
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
        DataMaster::create([
            'nama' => 'status_server',
            'data' => 'Normal',
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DataMaster::where('nama', 'status_server')->delete();
    }
};
