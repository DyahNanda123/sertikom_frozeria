<form action="{{ route('kategori.update', $kategori->id) }}" method="POST" id="form-edit-kategori" class="form-ajax">
    @csrf
    @method('PUT')
    
    {{-- ALERT INFO JUMLAH BARANG --}}
    <div class="alert alert-info d-flex align-items-center mb-4" style="border-radius: 12px; background-color: #f2f7ff; border: 1px solid #d1e3ff; color: #435ebe;">
        <i class="fas fa-info-circle fa-2x mr-3"></i>
        <div>
            <p class="mb-1 font-weight-bold" style="font-size: 14px;">
                Total: {{ $kategori->barang()->count() }} Item Barang
            </p>
            <p class="mb-0" style="font-size: 12px; color: #566a7f; line-height: 1.4;">
                Jumlah barang pada kategori ini dihitung otomatis oleh sistem dan hanya dapat diubah (ditambah/dihapus) melalui menu Data Barang.
            </p>
        </div>
    </div>

    {{-- INPUT NAMA KATEGORI --}}
    <div class="form-group mb-3">
        <label for="nama_kategori" class="font-weight-bold" style="color: #566a7f; font-size: 13px;">Nama Kategori <span class="text-danger">*</span></label>
        <input type="text" name="nama_kategori" id="nama_kategori" class="form-control font-weight-bold text-dark" value="{{ $kategori->nama_kategori }}" placeholder="Masukkan nama kategori" required style="border-radius: 8px; padding: 10px 15px;">
    </div>

    {{-- INPUT DESKRIPSI --}}
    <div class="form-group mb-4">
        <label for="deskripsi" class="font-weight-bold" style="color: #566a7f; font-size: 13px;">Deskripsi (Opsional)</label>
        <textarea name="deskripsi" id="deskripsi" class="form-control" rows="4" placeholder="Tambahkan deskripsi atau keterangan kategori..." style="border-radius: 8px; padding: 10px 15px;">{{ $kategori->deskripsi }}</textarea>
    </div>

    {{-- FOOTER TOMBOL --}}
    <div class="d-flex justify-content-end mt-4 pt-3" style="border-top: 1px solid #e1e8ed;">
        <button type="button" class="btn bg-white font-weight-bold mr-2" data-dismiss="modal" style="border-radius: 8px; color: #566a7f; border: 1px solid #d9dee3; padding: 10px 20px;">
            Batal
        </button>
        <button type="submit" class="btn font-weight-bold shadow-sm" style="background-color: #6366f1; color: white; border-radius: 8px; padding: 10px 20px;">
            Simpan Perubahan
        </button>
    </div>
</form>