<?php

namespace Database\Seeders;

use App\Models\Harga;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        Harga::create([
            'pegawai_id' => 1,
            'keterangan_id' => 1,
            'harga' => 6000
        ]);
        Harga::create([
            'pegawai_id' => 2,
            'keterangan_id' => 1,
            'harga' => 10000
        ]);
        Harga::create([
            'pegawai_id' => 3,
            'keterangan_id' => 1,
            'harga' => 12000
        ]);
    }
}
