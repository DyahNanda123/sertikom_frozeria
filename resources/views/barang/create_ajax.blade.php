<form action="{{ route('barang.store') }}" method="POST" class="form-ajax" enctype="multipart/form-data"> 
    
    @csrf
    
    {{-- BAGIAN 1: INFORMASI UTAMA --}}
    <h6 class="text-primary mb-3" style="font-weight: 700; text-transform: uppercase; letter-spacing: 1px; font-size: 13px;">
        <i class="fas fa-info-circle mr-1"></i> Informasi Utama
    </h6>
    
    <div class="row">
        <div class="col-md-6 form-group">
            <label class="text-muted font-weight-bold">Nama Produk <span class="text-danger">*</span></label>
            <input type="text" name="nama_barang" class="form-control" required placeholder="Contoh: Ayam Nugget Crispy">
        </div>
        <div class="col-md-6 form-group">
            <label class="text-muted font-weight-bold">Kategori <span class="text-danger">*</span></label>
            <select name="kategori_id" class="form-control" required>
                <option value="">-- Pilih Kategori --</option>
                @foreach($kategori as $k)
                    <option value="{{ $k->id }}">{{ $k->nama_kategori }}</option>
                @endforeach
            </select>
        </div>
    </div>
    
    <div class="form-group">
        <label class="text-muted font-weight-bold">Deskripsi Produk</label>
        <textarea name="deskripsi" class="form-control" rows="3" placeholder="Tuliskan keterangan detail mengenai produk ini..."></textarea>
    </div>

    <div class="form-group mb-4">
        <label class="text-muted font-weight-bold">Foto Produk (Opsional)</label>
        <div class="custom-file">
            <input type="file" name="foto_barang" class="custom-file-input" id="customFile" accept="image/*">
            <label class="custom-file-label" for="customFile">Pilih file foto...</label>
        </div>
    </div>

    {{-- GARIS PEMISAH --}}
    <hr style="border-color: #f0f0f0; margin: 25px 0;">

    {{-- BAGIAN 2: MANAJEMEN STOK & HARGA --}}
    <h6 class="text-primary mb-3" style="font-weight: 700; text-transform: uppercase; letter-spacing: 1px; font-size: 13px;">
        <i class="fas fa-box-open mr-1"></i> Manajemen Stok & Harga
    </h6>

    <div class="row">
        <div class="col-md-4 form-group">
            <label class="text-muted font-weight-bold">Jumlah Stok <span class="text-danger">*</span></label>
            <input type="number" name="jumlah_stok" class="form-control" required placeholder="0">
        </div>
        <div class="col-md-4 form-group">
            <label class="text-muted font-weight-bold">Stok Minimum <span class="text-danger">*</span></label>
            <input type="number" name="stok_minimum" class="form-control" required placeholder="0">
        </div>
        <div class="col-md-4 form-group">
            <label class="text-muted font-weight-bold">Satuan <span class="text-danger">*</span></label>
            <input type="text" name="satuan" class="form-control" required placeholder="Pcs / Pack">
        </div>
    </div>

    <div class="row">
        <div class="col-md-6 form-group">
            <label class="text-muted font-weight-bold">Harga Beli <span class="text-danger">*</span></label>
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text font-weight-bold bg-light">Rp</span>
                </div>
                <input type="number" name="harga_beli" class="form-control" required placeholder="0">
            </div>
        </div>
        <div class="col-md-6 form-group">
            <label class="text-muted font-weight-bold">Harga Jual <span class="text-danger">*</span></label>
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text font-weight-bold bg-light">Rp</span>
                </div>
                <input type="number" name="harga_jual" class="form-control" required placeholder="0">
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6 form-group">
            <label class="text-muted font-weight-bold">Berat / Ukuran</label>
            <input type="text" name="berat_ukuran" class="form-control" placeholder="Contoh: 500 gram">
        </div>
        <div class="col-md-6 form-group">
            <label class="text-muted font-weight-bold">Lokasi Simpan</label>
            <input type="text" name="lokasi_simpan" class="form-control" placeholder="Contoh: Freezer A1">
        </div>
    </div>

    {{-- TOMBOL AKSI --}}
    <div class="text-right mt-4 pt-3" style="border-top: 1px solid #f0f0f0;">
        <button type="button" class="btn bg-white font-weight-bold mr-2" data-dismiss="modal" style="border-radius: 8px; color: #566a7f; border: 1px solid #d9dee3; padding: 10px 20px;">Batal</button>
        <button type="submit" class="btn btn-primary font-weight-bold shadow-sm" style="border-radius: 8px; padding: 10px 20px;">
            <i class="fas fa-save mr-2"></i> Simpan Produk
        </button>
    </div>
</form>

<script>
    $('.custom-file-input').on('change', function() {
        let fileName = $(this).val().split('\\').pop();
        $(this).next('.custom-file-label').addClass("selected").html(fileName);
    });
</script>