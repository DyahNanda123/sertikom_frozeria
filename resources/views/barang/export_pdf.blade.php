<!DOCTYPE html>
<html>
<head>
    <title>Laporan Detail Stok Frozeria</title>
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

    <div class="header text-center">
        <div class="title">LAPORAN DETAIL STOK BARANG LENGKAP</div>
        <div>FROZERIA - SISTEM MONITORING KINERJA SALES</div>
        <div style="margin-top: 5px;">Waktu Cetak: {{ date('d-m-Y H:i') }} WIB</div>
    </div>

    <table class="table">
        <thead>
            <tr>
                <th style="width: 3%">NO</th>
                <th style="width: 15%">NAMA BARANG</th>
                <th style="width: 10%">KATEGORI</th>
                <th style="width: 7%">STOK</th>
                <th style="width: 7%">MIN</th>
                <th style="width: 8%">SATUAN</th>
                <th style="width: 10%">HARGA BELI</th>
                <th style="width: 10%">HARGA JUAL</th>
                <th style="width: 10%">BERAT</th>
                <th style="width: 10%">LOKASI</th>
                <th style="width: 10%">DESKRIPSI</th>
            </tr>
        </thead>
        <tbody>
            @forelse($barang as $index => $b)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td>{{ $b->nama_barang }}</td>
                    <td class="text-center">{{ $b->kategori->nama_kategori ?? '-' }}</td>
                    <td class="text-center">{{ $b->jumlah_stok }}</td>
                    <td class="text-center">{{ $b->stok_minimum }}</td>
                    <td class="text-center">{{ $b->satuan }}</td>
                    <td class="text-right">{{ number_format($b->harga_beli, 0, ',', '.') }}</td>
                    <td class="text-right">{{ number_format($b->harga_jual, 0, ',', '.') }}</td>
                    <td class="text-center">{{ $b->berat_ukuran }}</td>
                    <td class="text-center">{{ $b->lokasi_simpan }}</td>
                    <td>{{ $b->deskripsi ?? '-' }}</td>
                </tr>
            @empty
                <tr><td colspan="11" class="text-center">Data tidak ditemukan.</td></tr>
            @endforelse
        </tbody>
    </table>

</body>
</html>