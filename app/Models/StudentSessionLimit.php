<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentSessionLimit extends Model
{
    protected $fillable = [
        'student_external_id',
        'student_name',
        'allow_multiple_sessions',
        'max_sessions',
    ];

    protected $casts = [
        'allow_multiple_sessions' => 'boolean',
        'max_sessions' => 'integer',
    ];

    public function effectiveMaxSessions(): int
    {
        if (! $this->allow_multiple_sessions) {
            return 1;
        }

        return max(2, (int) $this->max_sessions);
    }
}
