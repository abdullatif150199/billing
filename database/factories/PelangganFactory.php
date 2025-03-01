<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Pelanggan>
 */
class PelangganFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $latitude = $this->faker->latitude();
        $longtitude = $this->faker->longitude();
        return [
            'nama' => $this->faker->name(),
            'foto_rumah' => "DUMMY IMAGE",
            'serial_number_modem' => "000 000 000",
            'ip_address' => $this->faker->ipv4(),
            'tanggal_tagihan' => $this->faker->numberBetween(1, 29),
            'tanggal_register' => now(),
            'tanggal_jatuh_tempo' => $this->faker->numberBetween(1, 29),
            'google_map' => "{$latitude}, {$longtitude}",
        ];
    }
}
