<?php

namespace Database\Seeders;

use App\Models\Devices;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DeviceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Devices::create([
            'device_uid' => 'DVC001',
            'is_active' => 1,
            'last_seen_at' => now(),
        ]);
        Devices::create([
            'device_uid' => 'DVC002',
            'is_active' => 1,
            'last_seen_at' => now(),
        ]);
    }
}
