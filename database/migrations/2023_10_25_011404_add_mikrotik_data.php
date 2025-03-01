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
            'nama' => 'mikrotik',
            'data' => json_encode([
                'ip' => '',
                'port' => '',
                'username' => '',
                'password' => '',
            ]),
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DataMaster::where('nama', 'mikrotik')->delete();
    }
};
