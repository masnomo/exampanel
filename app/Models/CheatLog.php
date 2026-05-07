<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CheatLog extends Model
{
    protected $fillable = ['device_id', 'violation_type'];
}
