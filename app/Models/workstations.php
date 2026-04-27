<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Workstation extends Model
{
    protected $fillable = [
        'pc_code',
        'location',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];
    /**
     * Because we enforce unique(workstation_id) in device_workstations,
     * one workstation is mapped to only one device (but via a port).
     */
    public function deviceMapping(): HasOne
    {
        return $this->hasOne(device_workstation::class);
    }
    public function accessLogs(): HasMany
    {
        return $this->hasMany(pc_access_log::class);
    }
}