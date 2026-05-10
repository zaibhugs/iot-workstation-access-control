<?php

namespace App\Models;

use App\Models\DeviceWorkstation;
use Illuminate\Database\Eloquent\Model;

class Devices extends Model
{
        protected $fillable = [
        'device_uid',
        'is_active',
        'last_seen_at',
    ];

    public function DeviceWorkstations()
    {
        return $this->hasMany(DeviceWorkstation::class);
    }
}
