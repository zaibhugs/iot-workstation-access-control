<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PcAccessLog extends Model
{
    protected $fillable = [
        'occurred_at',
        'received_at',
        'device_uid',
        'pc_port',
        'rfid_uid',
        'workstation_id',
        'event_type',
        'result',
        'reason',
        'session_id',
        'student_external_id',
        'student_name',
        'course',
        'metadata',
    ];

    protected $casts = [
        'occurred_at' => 'datetime',
        'received_at' => 'datetime',
        'pc_port' => 'integer',
        'metadata' => 'array',
    ];

    public function workstation(): BelongsTo
    {
        return $this->belongsTo(Workstation::class);
    }
}
