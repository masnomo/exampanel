<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ApkConfig extends Model
{
    protected $fillable = ['panel_name', 'cbt_url', 'exam_status', 'exit_password', 'app_secret_key', 'app_name', 'app_logo', 'welcome_message', 'available_rooms'];
}
