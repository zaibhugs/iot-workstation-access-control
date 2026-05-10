<?php

namespace Database\Seeders;

use App\Models\DeviceWorkstation;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DeviceWorkstationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        DeviceWorkstation::create([
            'device_id' => 1,
            'workstation_id' => 1,
            'pc_port' => 1,
        ]);
        DeviceWorkstation::create([
            'device_id' => 2,
            'workstation_id' => 2,
            'pc_port' => 2,
        ]);
    }
}
