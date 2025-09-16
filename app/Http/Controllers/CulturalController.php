<?php

namespace App\Http\Controllers;

use App\Models\Cultural;
use Illuminate\Http\Request;

class CulturalController extends Controller
{
    // Menampilkan semua data kebudayaan dengan opsi sortir
    public function index(Request $request)
    {
        $query = Cultural::query();
        // shorting huruf awal
        if ($request->filled('starts_with')) {
            $query->where('name', 'LIKE', $request->starts_with . '%');
        }
        // Cek apakah ada parameter sort dari URL
        if ($request->has('sort')) {
            if ($request->sort === 'asc') {
                $query->orderBy('name', 'asc'); // urut A - Z
            } elseif ($request->sort === 'desc') {
                $query->orderBy('name', 'desc'); // urut Z - A
            }
        }

        $culturals = $query->get(); // ambil hasil query
        return view('cultural.index', compact('culturals'));
    }

    // Menampilkan detail kebudayaan berdasarkan ID
    public function show($id)
    {
        $cultural = Cultural::findOrFail($id); // ambil 1 data berdasarkan ID
        return view('cultural.cultural_detail', compact('cultural'));
    }
}
