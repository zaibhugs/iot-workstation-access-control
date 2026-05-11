<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    protected $fillable = ['device_uid', 'is_active', 'last_seen_at'];
    
    protected $casts = [
        'last_seen_at' => 'datetime',
        'is_active' => 'boolean',
    ];

    public function deviceWorkstations()
    {
        // Note: Ensure the method name matches what you use in withCount()
        return $this->hasMany(DeviceWorkstation::class);
    }

    /**
     * Logic to check if the device is full (Port limit of 2)
     */
    public function getIsFullAttribute(): bool
    {
        // withCount('deviceWorkstations') provides the 'device_workstations_count' attribute
        return $this->device_workstations_count >= 2;
    }

    /**
     * Logic to calculate remaining ports
     */
    public function getRemainingPortsAttribute(): int
    {
        $limit = 2;
        $count = $this->device_workstations_count ?? 0;
        return max(0, $limit - $count);
    }
}