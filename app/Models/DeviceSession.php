<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DeviceSession extends Model
{
    protected $fillable = ['device_id', 'student_identity', 'student_name', 'exam_room', 'status', 'last_ping', 'message', 'command', 'battery_level', 'wifi_signal'];

    protected $casts = [
        'last_ping' => 'datetime',
    ];
}
