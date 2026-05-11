@extends('layouts.app')

@section('title', 'Bantuan')

@section('content')
{{-- HEADER BOX --}}
<div class="bg-white p-4 mb-4 shadow-sm d-flex justify-content-between align-items-center flex-wrap" style="border-radius: 16px; border-left: 6px solid var(--fz-primary);">
    <div class="d-flex align-items-center mb-2 mb-md-0">
        <div class="bg-primary text-white mr-3 d-flex align-items-center justify-content-center shadow" style="width: 50px; height: 50px; border-radius: 12px;">
            <i class="fas fa-life-ring"></i>
        </div>
        <div>
            <h1 style="font-weight: 800; font-size: 1.5rem; margin:0;">Panduan Penggunaan Sistem</h1>
            <p class="text-muted m-0">Bantuan navigasi dan operasional fitur Frozeria</p>
        </div>
    </div>
</div>

{{-- KONTEN PANDUAN LENGKAP --}}
<div class="card shadow-sm mb-4" style="border-radius: 16px; border: none;">
    <div class="card-body p-4">
        
        {{-- 1. Tambah Data --}}
        <div class="border p-4 mb-4" style="border-radius: 12px; background-color: #fcfdfd;">
            <h6 class="font-weight-bold text-dark mb-3">A. Cara Menambah Data Baru</h6>
            <ol class="mb-0 pl-3" style="line-height: 1.8; color: #566a7f;">
                <li>Buka menu <strong>Data Produk</strong> atau <strong>Kategori</strong>, lalu klik tombol <strong>+ Tambah</strong> di sudut kanan atas.</li>
                <li>Sebuah <em>pop-up</em> formulir akan muncul. Isi semua kolom data yang dibutuhkan dengan benar. Khusus produk, foto bersifat opsional (boleh dikosongkan).</li>
                <li>Klik tombol <strong>Simpan</strong>. Sistem akan memproses dan data otomatis muncul di baris teratas tabel.</li>
            </ol>
        </div>

        {{-- 2. Lihat Detail --}}
        <div class="border p-4 mb-4" style="border-radius: 12px; background-color: #fcfdfd;">
            <h6 class="font-weight-bold text-dark mb-3">B. Cara Melihat Detail Data</h6>
            <ol class="mb-0 pl-3" style="line-height: 1.8; color: #566a7f;">
                <li>Cari data yang ingin dilihat pada tabel, lalu klik tombol <strong>Detail</strong> pada kolom aksi.</li>
                <li><em>Pop-up</em> layar detail akan muncul menampilkan informasi lengkap dari data tersebut, termasuk gambar dan waktu data diinputkan tanpa perlu berpindah halaman.</li>
            </ol>
        </div>

        {{-- 3. Edit Data --}}
        <div class="border p-4 mb-4" style="border-radius: 12px; background-color: #fcfdfd;">
            <h6 class="font-weight-bold text-dark mb-3">C. Cara Mengubah (Update) Data</h6>
            <ol class="mb-0 pl-3" style="line-height: 1.8; color: #566a7f;">
                <li>Pilih data yang ingin diperbarui, lalu klik tombol <strong>Edit</strong> pada baris tabel tersebut.</li>
                <li>Ubah isian form sesuai kebutuhan (misalnya: menyesuaikan jumlah stok fisik dengan stok sistem).</li>
                <li>Klik <strong>Simpan</strong> untuk memperbarui data ke dalam database.</li>
            </ol>
        </div>

        {{-- 4. Hapus Data --}}
        <div class="border p-4 mb-4" style="border-radius: 12px; background-color: #fcfdfd;">
            <h6 class="font-weight-bold text-dark mb-3">D. Cara Menghapus Data</h6>
            <ol class="mb-0 pl-3" style="line-height: 1.8; color: #566a7f;">
                <li>Klik tombol <strong>Hapus</strong> pada data yang ingin dibuang dari sistem.</li>
                <li>Sistem akan menampilkan kotak peringatan keamanan. Jika sudah yakin, klik <strong>Ya, Hapus</strong>.</li>
                <li><strong>Penting:</strong> Sistem secara otomatis akan mencegah Anda menghapus <em>Kategori</em> jika di dalamnya masih terdapat <em>Produk</em> yang aktif.</li>
            </ol>
        </div>

        {{-- 5. Import Data --}}
        <div class="border p-4 mb-4" style="border-radius: 12px; background-color: #fcfdfd;">
            <h6 class="font-weight-bold text-dark mb-3">E. Cara Import Data Massal (Excel)</h6>
            <ol class="mb-0 pl-3" style="line-height: 1.8; color: #566a7f;">
                <li>Klik tombol <strong>Import</strong> di bagian atas tabel.</li>
                <li>Siapkan file Microsoft Excel (<code>.xlsx</code>) sesuai dengan format kolom yang telah ditentukan.</li>
                <li>Klik tombol <em>Pilih file excel...</em> dan pilih file Anda. Selanjutnya tekan <strong>Upload & Import</strong>. Sistem akan menyalin seluruh baris secara otomatis.</li>
            </ol>
        </div>

        {{-- 6. Export Data --}}
        <div class="border p-4 mb-4" style="border-radius: 12px; background-color: #fcfdfd;">
            <h6 class="font-weight-bold text-dark mb-3">F. Cara Cetak & Export Laporan</h6>
            <ol class="mb-0 pl-3" style="line-height: 1.8; color: #566a7f;">
                <li>Klik tombol <em>dropdown</em> <strong>Export</strong> di bagian atas tabel.</li>
                <li>Pilih <strong>Excel</strong> untuk mengunduh rekapitulasi mentah yang bisa diolah kembali.</li>
                <li>Pilih <strong>PDF</strong> untuk mencetak dokumen rapi (tab baru akan terbuka menampilkan laporan bergaris siap cetak).</li>
            </ol>
        </div>

        {{-- Note Alert --}}
        <div class="alert alert-light border d-flex align-items-center mb-0" style="border-radius: 12px; color: #566a7f;">
            <i class="far fa-lightbulb fa-2x mr-3" style="color: #ffab00;"></i>
            <div>
                <strong>Tips Pencarian:</strong> Anda dapat menggunakan kotak <em>Search</em> dan filter urutan tabel (mengklik judul kolom NAMA) untuk mempermudah pencarian data sebelum melakukan Edit atau Hapus.
            </div>
        </div>

    </div>
</div>

{{-- INFORMASI DETAIL MAHASISWA --}}
<div class="card shadow-sm" style="border-radius: 16px; border: none; border-top: 4px solid #6366f1;">
    <div class="card-header bg-white pt-4 pb-2 border-0">
        <h5 class="font-weight-bold text-dark m-0">Informasi Pengembang Sistem</h5>
    </div>
    <div class="card-body pb-4">
        <div class="row">
            <div class="col-md-6">
                <table class="table table-borderless table-sm mb-0">
                    <tr>
                        <td width="30%" class="text-muted font-weight-bold">Nama</td>
                        <td width="5%">:</td>
                        <td class="font-weight-bold text-dark">Dyah Nanda Ayu Purnamayansyah</td>
                    </tr>
                    <tr>
                        <td class="text-muted font-weight-bold">NIM</td>
                        <td>:</td>
                        <td class="font-weight-bold text-dark">2241760017</td>
                    </tr>
                    <tr>
                        <td class="text-muted font-weight-bold">Kelas</td>
                        <td>:</td>
                        <td class="font-weight-bold text-dark">SIB-4C</td>
                    </tr>
                    <tr>
                        <td width="30%" class="text-muted font-weight-bold">Program Studi</td>
                        <td width="5%">:</td>
                        <td class="font-weight-bold text-dark">Sistem Informasi Bisnis</td>
                    </tr>
                </table>
            </div>
            <div class="col-md-6">
                <table class="table table-borderless table-sm mb-0">
                    <tr>
                        <td class="text-muted font-weight-bold">Nomor Telepon</td>
                        <td>:</td>
                        <td class="font-weight-bold text-dark">0881-714-0376</td>
                    </tr>
                    <tr>
                        <td class="text-muted font-weight-bold">Email</td>
                        <td>:</td>
                        <td class="font-weight-bold text-dark">nandadyah2@gmail.com</td>
                    </tr>
                    <tr>
                        <td class="text-muted font-weight-bold">Alamat</td>
                        <td>:</td>
                        <td class="font-weight-bold text-dark">Magetan, Jawa Timur</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection