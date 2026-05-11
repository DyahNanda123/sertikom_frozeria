{{-- FORM TAMBAH KATEGORI AJAX --}}
<form action="{{ route('kategori.store') }}" method="POST" id="form-tambah-kategori" class="form-ajax">
    @csrf
    
    {{-- ALERT PETUNJUK --}}
    <div class="alert alert-primary d-flex align-items-center mb-4" style="border-radius: 12px; background-color: #f2f7ff; border: 1px solid #d1e3ff; color: #435ebe;">
        <i class="fas fa-info-circle fa-2x mr-3"></i>
        <div>
            <p class="mb-0" style="font-size: 13px; color: #566a7f; line-height: 1.4;">
                Silakan masukkan nama kategori baru. Kategori ini nantinya bisa kamu pilih saat menambahkan data produk di dashboard.
            </p>
        </div>
    </div>

    {{-- INPUT NAMA KATEGORI --}}
    <div class="form-group mb-3">
        <label for="nama_kategori" class="font-weight-bold" style="color: #566a7f; font-size: 13px;">NAMA KATEGORI <span class="text-danger">*</span></label>
        <input type="text" name="nama_kategori" id="nama_kategori" class="form-control font-weight-bold text-dark" placeholder="Contoh: Frozen Food, Minuman, Daging..." required style="border-radius: 8px; padding: 12px 15px; border: 1px solid #d9dee3;">
    </div>

    {{-- INPUT DESKRIPSI --}}
    <div class="form-group mb-4">
        <label for="deskripsi" class="font-weight-bold" style="color: #566a7f; font-size: 13px;">DESKRIPSI KATEGORI (OPSIONAL)</label>
        <textarea name="deskripsi" id="deskripsi" class="form-control" rows="4" placeholder="Jelaskan secara singkat kelompok produk ini..." style="border-radius: 8px; padding: 12px 15px; border: 1px solid #d9dee3;"></textarea>
    </div>

    {{-- FOOTER TOMBOL --}}
    <div class="d-flex justify-content-end mt-4 pt-3" style="border-top: 1px solid #e1e8ed;">
        <button type="button" class="btn bg-white font-weight-bold mr-2" data-dismiss="modal" style="border-radius: 8px; color: #566a7f; border: 1px solid #d9dee3; padding: 10px 20px;">
            Batal
        </button>
        <button type="submit" class="btn font-weight-bold shadow-sm" style="background: linear-gradient(135deg, #6366f1, #a855f7); color: white; border-radius: 8px; padding: 10px 25px; border: none;">
            <i class="fas fa-save mr-2"></i> Simpan Kategori
        </button>
    </div>
</form>