<?php

namespace App\Models;

use App\Models\Device;
use App\Models\Workstations;
use Illuminate\Database\Eloquent\Model;

class DeviceWorkstation extends Model
{
    protected $fillable = [
        'device_id',
        'workstation_id',
        'pc_port',
    ];

    public function device()
    {
        return $this->belongsTo(Device::class);
    }

    public function workstation()
    {
        return $this->belongsTo(Workstations::class);
    }
}
