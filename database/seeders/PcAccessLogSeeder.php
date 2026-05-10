<?php

namespace Database\Seeders;

use App\Models\PcAccessLogs;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PcAccessLogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        PcAccessLogs::create([
            'occurred_at' => now(),
            'received_at' => now(),
            'device_uid' => 'DVC001',
            'pc_port' => 1,
            'rfid_uid' => 'RFID1234',
            'workstation_id' => 1,
            'event_type' => 'LOGIN',
            'result' => 'SUCCESS',
            'reason' => 'Authorized',
            'session_id' => 'SESS001',
            'student_external_id' => '2310501-2',
            'student_name' => 'Hannah D. Dalmacio',
            'course' => 'INFOTECH NETWORKING',
            'metadata' => json_encode(['ip' => '192.168.0.10']),
        ]);
    }
}
