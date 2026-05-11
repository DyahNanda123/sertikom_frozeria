<!DOCTYPE html>
<html>
<head>
    <title>Laporan Kategori Frozeria</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 9px; color: #333; }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .table { width: 100%; border-collapse: collapse; margin-top: 20px; table-layout: fixed; }
        .table th, .table td { border: 1px solid #000; padding: 4px; word-wrap: break-word; }
        .table th { background-color: #f2f2f2; font-weight: bold; text-transform: uppercase; }
        .header { border-bottom: 2px solid #444; padding-bottom: 10px; margin-bottom: 15px; }
        .title { font-size: 14px; font-weight: bold; }
    </style>
</head>
<body>
    
    {{-- BAGIAN HEADER --}}
    <div class="header text-center">
        <div class="title">LAPORAN DATA KATEGORI LENGKAP</div>
        <div style="margin-top: 4px; text-transform: uppercase;">FROZERIA - SISTEM MONITORING KINERJA SALES</div>
        <div style="margin-top: 4px;">Waktu Cetak: {{ \Carbon\Carbon::now()->timezone('Asia/Jakarta')->format('d-m-Y H:i') }} WIB</div>
    </div>

    {{-- TABEL KATEGORI --}}
    <table class="table">
        <thead>
            <tr>
                <th width="5%">NO</th>
                <th width="35%">NAMA KATEGORI</th>
                <th width="20%">JUMLAH BARANG</th>
                <th width="40%">DESKRIPSI</th>
            </tr>
        </thead>
        <tbody>
            @foreach($kategori as $index => $k)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td>{{ $k->nama_kategori }}</td>
                    <td class="text-center">{{ $k->barang_count }} Item</td>
                    <td>{{ $k->deskripsi ?? '-' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    
</body>
</html>