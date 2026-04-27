<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DeviceWorkstation extends Model
{
    protected $fillable = [
        'device_id',
        'pc_port',
        'workstation_id',
    ];

    protected $casts = [
        'pc_port' => 'integer',
    ];

    public function device(): BelongsTo
    {
        return $this->belongsTo(device::class);
    }

    public function workstation(): BelongsTo
    {
        return $this->belongsTo(workstation::class);
    }
}