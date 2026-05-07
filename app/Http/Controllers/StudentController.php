<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\ApkConfig;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response;

class StudentController extends Controller
{
    public function downloadTemplate()
    {
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="template_siswa.csv"',
        ];

        $columns = ['username', 'name', 'password'];

        $callback = function() use ($columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);
            
            // Contoh baris
            fputcsv($file, ['siswa1', 'Siswa Contoh 1', 'password123']);
            fputcsv($file, ['siswa2', 'Siswa Contoh 2', 'password123']);
            
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function index()
    {
        $students = User::where('role', 'student')->get(); 
        $config = ApkConfig::first();
        return view('students', compact('students', 'config'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'username' => 'required|unique:users',
            'password' => 'required',
        ]);

        User::create([
            'name' => $request->name,
            'username' => $request->username,
            'password' => Hash::make($request->password),
        ]);

        return back()->with('success', 'Siswa berhasil ditambahkan');
    }

    public function import(Request $request)
    {
        $request->validate([
            'csv_file' => 'required|file|mimes:csv,txt'
        ]);

        $file = $request->file('csv_file');
        $data = file($file->getRealPath());

        foreach ($data as $index => $row) {
            if ($index == 0) continue; // Skip header

            $columns = str_getcsv($row);
            if (count($columns) >= 3) {
                User::updateOrCreate(
                    ['username' => $columns[0]],
                    [
                        'name' => $columns[1],
                        'password' => Hash::make($columns[2]),
                    ]
                );
            }
        }

        return back()->with('success', 'Import siswa berhasil');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'username' => 'required|unique:users,username,' . $id,
            'name' => 'required',
        ]);

        $student = User::findOrFail($id);
        $data = [
            'username' => $request->username,
            'name' => $request->name,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $student->update($data);

        return back()->with('success', 'Data siswa berhasil diperbarui!');
    }

    public function destroy($id)
    {
        User::destroy($id);
        return back()->with('success', 'Siswa berhasil dihapus');
    }
}
