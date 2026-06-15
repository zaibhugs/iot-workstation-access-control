<?php

namespace App\Models;

use App\Models\DeviceWorkstation;
use App\Models\PcAccessLogs;
use Illuminate\Database\Eloquent\Model;

class Workstations extends Model
{
    protected $fillable = [
        'pc_code',
        'location',
        'is_active',
    ];

    public function deviceWorkstations()
    {
        return $this->hasMany(DeviceWorkstation::class, 'workstation_id', 'id');
    }

    public function pcAccessLogs()
    {
        return $this->hasMany(PcAccessLogs::class);
    }
}
