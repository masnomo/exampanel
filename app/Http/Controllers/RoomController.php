<?php

namespace App\Http\Controllers;

use App\Models\ExamRoom;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|unique:exam_rooms,name'
        ]);

        ExamRoom::create([
            'name' => $request->name
        ]);

        return back()->with('success', 'Ruangan berhasil ditambahkan!');
    }

    public function destroy($id)
    {
        ExamRoom::destroy($id);
        return back()->with('success', 'Ruangan berhasil dihapus!');
    }
}
