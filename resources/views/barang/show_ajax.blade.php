<div class="row px-2">
    <div class="col-md-5 mb-4 mb-md-0 text-center">
        @if($barang->foto_barang)
            <img src="{{ asset('storage/barang/' . $barang->foto_barang) }}" alt="{{ $barang->nama_barang }}" 
                 class="img-fluid border-0 shadow-sm" style="border-radius: 12px; width: 100%; object-fit: cover; aspect-ratio: 1/1;">
        @else
            <div class="d-flex align-items-center justify-content-center bg-light text-muted" 
                 style="height: 220px; border-radius: 12px; border: 2px dashed #e6e6e6;">
                <div class="text-center">
                    <i class="fas fa-image fa-3x mb-2 opacity-25"></i>
                    <p class="small m-0">Belum ada foto</p>
                </div>
            </div>
        @endif
    </div>

    <div class="col-md-7">
        <div class="mb-3">
            <h4 style="font-weight: 700; color: #566a7f; margin-bottom: 15px;">{{ $barang->nama_barang }}</h4>
            <span class="badge badge-light text-primary px-3 py-2 d-inline-block" style="border-radius: 8px; font-weight: 600;">
                <i class="fas fa-tag mr-1"></i> {{ $barang->kategori->nama_kategori ?? 'Umum' }}
            </span>
        </div>

        <div class="card shadow-none border-0 bg-light p-3" style="border-radius: 12px; margin-bottom: 20px;">
            <div class="row mb-2">
                <div class="col-5 text-muted small">STOK SAAT INI</div>
                <div class="col-7 font-weight-bold" style="color: #566a7f;">: {{ $barang->jumlah_stok }} {{ $barang->satuan }}</div>
            </div>
            <div class="row mb-2">
                <div class="col-5 text-muted small">STOK MINIMUM</div>
                <div class="col-7" style="color: #566a7f;">: {{ $barang->stok_minimum }} {{ $barang->satuan }}</div>
            </div>
            <div class="row mb-2">
                <div class="col-5 text-muted small">HARGA BELI</div>
                <div class="col-7" style="color: #566a7f;">: Rp {{ number_format($barang->harga_beli, 0, ',', '.') }}</div>
            </div>
            <div class="row mb-2">
                <div class="col-5 text-muted small">HARGA JUAL</div>
                <div class="col-7 font-weight-bold text-success">: Rp {{ number_format($barang->harga_jual, 0, ',', '.') }}</div>
            </div>
            <div class="row mb-2">
                <div class="col-5 text-muted small">BERAT/UKURAN</div>
                <div class="col-7" style="color: #566a7f;">: {{ $barang->berat_ukuran ?? '-' }}</div>
            </div>
            <div class="row">
                <div class="col-5 text-muted small">LOKASI SIMPAN</div>
                <div class="col-7" style="color: #566a7f;">: {{ $barang->lokasi_simpan ?? '-' }}</div>
            </div>
        </div>

        <div>
            <label class="text-muted small font-weight-bold mb-1">DESKRIPSI</label>
            <p style="font-size: 13.5px; color: #697a8d; line-height: 1.6;">
                {{ $barang->deskripsi ?? 'Tidak ada deskripsi produk.' }}
            </p>
        </div>
    </div>
</div>