<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Kategori;
use App\Models\Barang;

class DummySeeder extends Seeder
{
    public function run(): void
    {
        // 1. Data Kategori Sesuai PDF
        $katAyam = Kategori::create(['nama_kategori' => 'Ayam']); // [cite: 150]
        $katSeafood = Kategori::create(['nama_kategori' => 'Seafood']); // [cite: 155]
        $katSapi = Kategori::create(['nama_kategori' => 'Sapi']); // [cite: 159]
        $katSayuran = Kategori::create(['nama_kategori' => 'Sayuran']); // [cite: 163]
        $katSiapSaji = Kategori::create(['nama_kategori' => 'Siap saji']); // [cite: 167]

        // 2. Data Barang Sesuai PDF
        Barang::create([
            'kategori_id' => $katAyam->id,
            'nama_barang' => 'Ayam nugget crispy', // [cite: 60]
            'satuan' => 'pcs', // [cite: 63]
            'jumlah_stok' => 120, // [cite: 62]
            'stok_minimum' => 20, // [cite: 102]
            'harga_beli' => 28000, // [cite: 102]
            'harga_jual' => 35000, // [cite: 64]
            'berat_ukuran' => '500 gram', // [cite: 102]
            'lokasi_simpan' => 'Rak A-3', // [cite: 102]
            'deskripsi' => 'Nugget ayam dengan lapisan tepung erispy, cocok untuk camilan atau bekal. Tersedia dalam kemasan 500 gr berisi 120 pcs.' // [cite: 102]
        ]);

        Barang::create([
            'kategori_id' => $katSapi->id,
            'nama_barang' => 'Sosis sapi premium', // [cite: 66]
            'satuan' => 'pack', // [cite: 69]
            'jumlah_stok' => 15, // [cite: 68]
            'stok_minimum' => 20, // Data asumsi agar masuk stok menipis
            'harga_beli' => 22000, // Data asumsi
            'harga_jual' => 28000, // [cite: 70]
            'berat_ukuran' => '300 gram', // Data asumsi
            'lokasi_simpan' => 'Rak A-2', // Data asumsi
            'deskripsi' => 'Sosis sapi premium lezat.' 
        ]);

        Barang::create([
            'kategori_id' => $katSeafood->id,
            'nama_barang' => 'Dim sum udang', // [cite: 72]
            'satuan' => 'box', // [cite: 75]
            'jumlah_stok' => 0, // [cite: 74]
            'stok_minimum' => 15, // Data asumsi
            'harga_beli' => 38000, // Data asumsi
            'harga_jual' => 45000, // [cite: 76]
            'berat_ukuran' => '250 gram', // Data asumsi
            'lokasi_simpan' => 'Freezer A-1', // Data asumsi
            'deskripsi' => 'Dim sum udang segar isi 10.'
        ]);

        Barang::create([
            'kategori_id' => $katSapi->id,
            'nama_barang' => 'Bakso urat sapi', // [cite: 79]
            'satuan' => 'pack', // [cite: 81]
            'jumlah_stok' => 60, // [cite: 80]
            'stok_minimum' => 20, // Data asumsi
            'harga_beli' => 18000, // Data asumsi
            'harga_jual' => 22000, // [cite: 82]
            'berat_ukuran' => '500 gram', // Data asumsi
            'lokasi_simpan' => 'Freezer B-2', // Data asumsi
            'deskripsi' => 'Bakso urat asli daging sapi.'
        ]);

        Barang::create([
            'kategori_id' => $katSayuran->id,
            'nama_barang' => 'Edamame beku', // [cite: 84]
            'satuan' => 'pack', // [cite: 87]
            'jumlah_stok' => 0, // [cite: 86]
            'stok_minimum' => 10, // Data asumsi
            'harga_beli' => 14000, // Data asumsi
            'harga_jual' => 18000, // [cite: 88]
            'berat_ukuran' => '200 gram', // Data asumsi
            'lokasi_simpan' => 'Freezer C-1', // Data asumsi
            'deskripsi' => 'Kacang edamame beku siap rebus.'
        ]);
    }
}