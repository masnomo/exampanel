<?php

namespace App\Http\Controllers;

use App\Models\CheatLog;
use App\Models\ApkConfig;
use Illuminate\Http\Request;

class CheatLogController extends Controller
{
    public function index()
    {
        $logs = CheatLog::orderBy('created_at', 'desc')->paginate(20);
        $config = ApkConfig::first();
        return view('cheat_logs', compact('logs', 'config'));
    }

    public function clear()
    {
        CheatLog::truncate();
        return back()->with('success', 'Semua log kecurangan berhasil dibersihkan!');
    }
}
