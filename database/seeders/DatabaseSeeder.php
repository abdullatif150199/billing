<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\AreaAlamat;
use App\Models\PaketLangganan;
use App\Models\Pelanggan;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        AreaAlamat::factory(20)->create();
        PaketLangganan::factory(10)->create();
        $user = User::factory()->create([
            'name' => 'admin',
            'email' => 'admin@example.com',
            'password' => 'admin',
        ]);

        $user->assignRole('admin');

        $password = 'password';
        $pelanggan = User::factory()->create([
            'password' => $password,
            'password_not_hashed' => $password,
        ]);
        $pelanggan->assignRole('pelanggan');


        $paket = PaketLangganan::factory()->create();
        $area = AreaAlamat::factory()->create();
        Pelanggan::factory()
            ->for($pelanggan)
            ->for($paket)
            ->for($area)
            ->create(['id' => '000002']);

        $pelanggan = User::factory()->create([
            'password' => $password,
            'password_not_hashed' => $password,
        ]);
        $pelanggan->assignRole('pelanggan');


        $paket = PaketLangganan::factory()->create();
        $area = AreaAlamat::factory()->create();
        Pelanggan::factory()
            ->for($pelanggan)
            ->for($paket)
            ->for($area)
            ->create(['id' => '000001']);
    }
}
