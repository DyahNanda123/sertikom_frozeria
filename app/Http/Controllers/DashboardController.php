<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang;
use App\Models\Kategori;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $kategori_id = $request->input('kategori_id');

        $query = Barang::with('kategori');

        // Logika Fitur Pencarian
        if ($search) {
            $query->where('nama_barang', 'like', '%' . $search . '%');
        }

        // Logika Fitur Filter Dropdown Kategori
        if ($kategori_id) {
            $query->where('kategori_id', $kategori_id);
        }

        $sortField = $request->get('sort', 'id'); // Default urut berdasar ID
        $sortOrder = $request->get('order', 'desc'); // Default yang terbaru di atas

        $barang = $query->orderBy($sortField, $sortOrder)->paginate(10);
        
        $barang->appends($request->all());

        $kategori = Kategori::all();

        // Hitung data untuk Card Informasi di atas tabel
        $total_barang = Barang::count();
        $stok_menipis = Barang::where('jumlah_stok', '<', 20)->where('jumlah_stok', '>', 0)->count();
        $stok_habis = Barang::where('jumlah_stok', 0)->count();

        return view('dashboard.index', compact(
            'barang', 
            'kategori', 
            'total_barang', 
            'stok_menipis', 
            'stok_habis'
        ));
    }
}