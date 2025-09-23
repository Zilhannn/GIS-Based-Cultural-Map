<?php

namespace App\Http\Controllers;

use App\Models\Cultural;
use Illuminate\Http\Request;

class CulturalController extends Controller
{
    // Menampilkan semua data kebudayaan dengan opsi sortir & pagination
    public function index(Request $request)
    {
        $query = Cultural::query();

        // Filter: nama yang diawali huruf tertentu
        if ($request->filled('starts_with')) {
            $query->where('name', 'LIKE', $request->starts_with . '%');
        }

        // Sorting A-Z / Z-A
        if ($request->has('sort')) {
            if ($request->sort === 'asc') {
                $query->orderBy('name', 'asc'); // A - Z
            } elseif ($request->sort === 'desc') {
                $query->orderBy('name', 'desc'); // Z - A
            }
        }

        // Ambil data dengan pagination, 12 item per halaman
        $culturals = $query->paginate(9)->withQueryString();;

        return view('cultural.index', compact('culturals'));
    }

    // Menampilkan detail kebudayaan berdasarkan ID
    public function show($id)
    {
        $cultural = Cultural::with('galleries')->findOrFail($id);
        return view('cultural.cultural_detail', compact('cultural'));
    }
}
