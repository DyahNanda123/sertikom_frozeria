@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')

{{-- HEADER BOX --}}
<div class="bg-white p-4 mb-4 shadow-sm d-flex justify-content-between align-items-center flex-wrap" style="border-radius: 16px; border-left: 6px solid var(--fz-primary);">
    <div class="d-flex align-items-center mb-2 mb-md-0">
        <div class="bg-primary text-white mr-3 d-flex align-items-center justify-content-center shadow" style="width: 50px; height: 50px; border-radius: 12px;">
            <i class="fas fa-th-large"></i>
        </div>
        <div>
            <h1 style="font-weight: 800; font-size: 1.5rem; margin:0;">Dashboard</h1>
            <p class="text-muted m-0">Monitoring stok real-time Frozeria</p>
        </div>
    </div>
    
    {{-- GROUP TOMBOL AKSI --}}
    <div class="d-flex align-items-center">
        
        {{-- Tombol Export (Dropdown) --}}
        <div class="dropdown mr-2">
            <button class="btn bg-white font-weight-bold shadow-sm dropdown-toggle" type="button" id="exportDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="border-radius: 10px; padding: 10px 16px; border: 1px solid #d9dee3; color: #566a7f;">
                <i class="fas fa-upload mr-1"></i> Export
            </button>
            <div class="dropdown-menu dropdown-menu-right shadow-sm border-0" aria-labelledby="exportDropdown" style="border-radius: 12px; padding: 8px;">
                <a class="dropdown-item py-2 font-weight-bold d-flex align-items-center" href="{{ route('barang.exportExcel') }}" style="color: #107c41; border-radius: 8px;">
                    <i class="fas fa-file-excel fa-lg mr-3"></i> Excel
                </a>
                <a class="dropdown-item py-2 font-weight-bold d-flex align-items-center" href="{{ route('barang.exportPdf') }}" target="_blank" style="color: #e3242b; border-radius: 8px;">
                    <i class="fas fa-file-pdf fa-lg mr-3"></i> PDF
                </a>
            </div>
        </div>

        {{-- Tombol Import --}}
        <button class="btn bg-white font-weight-bold shadow-sm mr-2" data-toggle="modal" data-target="#modalImport" style="border-radius: 10px; padding: 10px 16px; border: 1px solid #d9dee3; color: #566a7f;">
            <i class="fas fa-download mr-1"></i> Import
        </button>

        {{-- Tombol Tambah Produk --}}
        <a href="{{ route('barang.create') }}" class="btn btn-primary btn-create font-weight-bold shadow-sm" style="border-radius: 10px; padding: 10px 20px; border: none; background: linear-gradient(135deg, #6366f1, #a855f7);">
            <i class="fas fa-plus mr-2"></i> Tambah Produk
        </a>
    </div>
</div>

{{-- STAT CARDS DIBUNGKUS ID UNTUK AUTO-REFRESH AJAX --}}
<div class="row mb-4 text-center" id="stats-section">
    <div class="col-md-3 col-sm-6 mb-3">
        <div class="bg-white p-4 shadow-sm h-100" style="border-radius: 16px;">
            <div class="d-inline-flex align-items-center justify-content-center mb-3" style="width: 55px; height: 55px; border-radius: 14px; background: #e7e7ff; color: #696cff;"><i class="fas fa-box fa-lg"></i></div>
            <h6 class="text-muted font-weight-bold">Total Produk</h6>
            <h2 class="font-weight-bold mb-0">{{ $total_barang ?? 0 }}</h2>
        </div>
    </div>
    <div class="col-md-3 col-sm-6 mb-3">
        <div class="bg-white p-4 shadow-sm h-100" style="border-radius: 16px;">
            <div class="d-inline-flex align-items-center justify-content-center mb-3" style="width: 55px; height: 55px; border-radius: 14px; background: #e8fadf; color: #71dd37;"><i class="fas fa-layer-group fa-lg"></i></div>
            <h6 class="text-muted font-weight-bold">Total Kategori</h6>
            {{-- UBAH DI SINI: Panggil variabel $total_kategori --}}
            <h2 class="font-weight-bold mb-0">{{ $total_kategori ?? 0 }}</h2>
        </div>
    </div>
    <div class="col-md-3 col-sm-6 mb-3">
        <div class="bg-white p-4 shadow-sm h-100" style="border-radius: 16px;">
            <div class="d-inline-flex align-items-center justify-content-center mb-3" style="width: 55px; height: 55px; border-radius: 14px; background: #fff2e0; color: #ffab00;"><i class="fas fa-hourglass-half fa-lg"></i></div>
            <h6 class="text-muted font-weight-bold">Stok Menipis</h6>
            <h2 class="font-weight-bold mb-0">{{ $stok_menipis ?? 0 }}</h2>
        </div>
    </div>
    <div class="col-md-3 col-sm-6 mb-3">
        <div class="bg-white p-4 shadow-sm h-100" style="border-radius: 16px;">
            <div class="d-inline-flex align-items-center justify-content-center mb-3" style="width: 55px; height: 55px; border-radius: 14px; background: #ffe5e5; color: #ff3e1d;"><i class="fas fa-times-circle fa-lg"></i></div>
            <h6 class="text-muted font-weight-bold">Stok Kosong</h6>
            <h2 class="font-weight-bold mb-0">{{ $stok_habis ?? 0 }}</h2>
        </div>
    </div>
</div>

<div class="bg-white p-3 mb-4 shadow-sm" style="border-radius: 16px;">
    <form id="search-form" action="{{ url()->current() }}" method="GET" class="m-0 row" onsubmit="return false;">
        
        {{-- Kotak Search (Lebih Panjang, 8 Kolom) --}}
        <div class="col-md-8 mb-2 mb-md-0">
            <div class="input-group shadow-sm h-100" style="border-radius: 10px; overflow: hidden; background-color: #f3f4f6;">
                <div class="input-group-prepend">
                    <span class="input-group-text border-0 bg-transparent text-primary px-3">
                        <i class="fas fa-search"></i>
                    </span>
                </div>
                <input type="text" name="search" id="search-input" class="form-control border-0 bg-transparent font-weight-bold" placeholder="Cari nama produk (ketik untuk mencari)..." value="{{ request('search') }}" autocomplete="off">
            </div>
        </div>
        
        {{-- Dropdown Filter Kategori (4 Kolom) --}}
        <div class="col-md-4">
            <div class="input-group shadow-sm h-100" style="border-radius: 10px; overflow: hidden; background-color: #f3f4f6;">
                <div class="input-group-prepend">
                    <span class="input-group-text border-0 bg-transparent text-primary px-3">
                        <i class="fas fa-filter"></i>
                    </span>
                </div>
                <select name="kategori_id" id="kategori-select" class="form-control border-0 bg-transparent font-weight-bold">
                    <option value="">Semua Kategori</option>
                    @foreach($kategori as $k)
                        <option value="{{ $k->id }}" {{ request('kategori_id') == $k->id ? 'selected' : '' }}>
                            {{ $k->nama_kategori }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

    </form>
</div>

{{-- TABEL DIBUNGKUS ID UNTUK AUTO-REFRESH AJAX --}}
<div class="bg-white p-4 shadow-sm" style="border-radius: 16px;" id="table-section">
    <div class="table-responsive">
        <table class="table table-hover">
            <thead>
            <tr class="text-muted" style="text-transform: uppercase; font-size: 11px; letter-spacing: 1px;">
                <th width="5%">No</th>
                <th>
                    {{-- Link Sorting Nama Barang --}}
                    <a href="{{ request()->fullUrlWithQuery(['sort' => 'nama_barang', 'order' => request('order') == 'asc' ? 'desc' : 'asc']) }}" class="text-muted d-flex align-items-center justify-content-between">
                        NAMA BARANG
                        <span class="ml-1">
                            @if(request('sort') == 'nama_barang')
                                <i class="fas fa-sort-alpha-{{ request('order') == 'asc' ? 'down' : 'up' }} text-primary"></i>
                            @else
                                <i class="fas fa-sort text-light"></i>
                            @endif
                        </span>
                    </a>
                </th>
                <th>KATEGORI</th>
                <th class="text-center">STOK</th>
                <th class="text-center">SATUAN</th>
                <th class="text-right">HARGA JUAL</th>
                <th class="text-center">AKSI</th>
            </tr>
        </thead>
            <tbody>
                @forelse($barang as $index => $item)
                <tr>
                    <td class="align-middle text-muted">{{ $barang->firstItem() + $index }}</td>
                    <td class="align-middle font-weight-bold text-dark">{{ $item->nama_barang }}</td>
                    <td class="align-middle"><span class="badge badge-light p-2" style="border-radius: 8px;">{{ $item->kategori->nama_kategori ?? '-' }}</span></td>
                    
                    <td class="align-middle text-center">
                        @if($item->jumlah_stok <= 0)
                            <span class="badge shadow-sm" style="border-radius: 8px; background-color: #ffe5e5; color: #ff3e1d; font-weight: 800;">{{ $item->jumlah_stok }} (Kosong)</span>
                        @elseif($item->jumlah_stok <= $item->stok_minimum)
                            <span class="badge shadow-sm" style="border-radius: 8px; background-color: #fff2e0; color: #ffab00; font-weight: 800;">{{ $item->jumlah_stok }} (Menipis)</span>
                        @else
                            <span class="badge shadow-sm" style="border-radius: 8px; background-color: #e8fadf; color: #71dd37; font-weight: 800;">{{ $item->jumlah_stok }}</span>
                        @endif
                    </td>
                    <td class="align-middle text-center"><span class="text-muted" style="font-size: 13px;">{{ $item->satuan }}</span></td>
                    <td class="align-middle text-right font-weight-bold">Rp {{ number_format($item->harga_jual, 0, ',', '.') }}</td>
                    <td class="align-middle text-center">
                        <div class="d-flex justify-content-center">
                            <a href="{{ route('barang.show', $item->id) }}" class="fz-btn-action btn-view" title="Detail"><i class="fas fa-eye"></i></a>
                            <a href="{{ route('barang.edit', $item->id) }}" class="fz-btn-action btn-edit mx-2" title="Edit"><i class="fas fa-pencil-alt"></i></a>
                            {{-- Parameter 'this' dikirim supaya baris ini bisa hilang otomatis --}}
                            <button class="fz-btn-action btn-delete" onclick="deleteAjax(this, '{{ route('barang.destroy', $item->id) }}', '{{ $item->nama_barang }}')" title="Hapus"><i class="fas fa-trash"></i></button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="7" class="text-center p-5 text-muted">Data barang tidak ditemukan.</td></tr>
                @endforelse
            </tbody>
        </table>
        
        {{-- Tampilkan tombol halaman kalau datanya banyak --}}
        @if($barang->hasPages())
            <div class="d-flex justify-content-center mt-4">
                {{ $barang->links('pagination::bootstrap-4') }}
            </div>
        @endif
    </div>
</div>

{{-- MODAL DETAIL --}}
<div class="modal fade" id="modalDetail" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content" style="border-radius: 16px; border: none; box-shadow: 0 10px 30px rgba(0,0,0,0.1);">
            <div class="modal-header border-0 pb-0">
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <div class="modal-body pb-5"></div>
        </div>
    </div>
</div>

{{-- MODAL FORM (CREATE & EDIT) --}}
<div class="modal fade" id="modalForm" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content" style="border-radius: 16px; border: none; box-shadow: 0 10px 30px rgba(0,0,0,0.1);">
            <div class="modal-header border-0 p-4">
                <h5 class="modal-title font-weight-bold" id="modalFormTitle" style="color: #566a7f;">Form Produk</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <div class="modal-body p-4 pt-0"></div>
        </div>
    </div>
</div>

{{-- MODAL IMPORT EXCEL --}}
<div class="modal fade" id="modalImport" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content" style="border-radius: 16px; border: none; box-shadow: 0 10px 30px rgba(0,0,0,0.1);">
            <div class="modal-header border-0 p-4 pb-2">
                <h5 class="modal-title font-weight-bold" style="color: #566a7f;">
                    <i class="fas fa-file-excel mr-2" style="color: #107c41;"></i> Import Data Barang
                </h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>
            
            {{-- Form Import (Nanti action-nya diisi route import backend) --}}
            <form action="{{ route('barang.importExcel') }}" method="POST" enctype="multipart/form-data" class="form-ajax">
                @csrf
                <div class="modal-body p-4 pt-0">
                    <p class="text-muted" style="font-size: 14px; line-height: 1.6;">Upload file Excel (.xlsx atau .xls) untuk menambahkan data barang secara massal. Pastikan format kolom sesuai dengan template.</p>
                    
                    <div class="custom-file mb-3">
                        <input type="file" name="file_excel" class="custom-file-input" id="customFileImport" accept=".xlsx, .xls" required>
                        <label class="custom-file-label" for="customFileImport">Pilih file excel...</label>
                    </div>
                </div>
                <div class="modal-footer border-0 p-4 pt-0">
                    <button type="button" class="btn bg-white font-weight-bold mr-2" data-dismiss="modal" style="border-radius: 8px; color: #566a7f; border: 1px solid #d9dee3; padding: 8px 16px;">Batal</button>
                    <button type="submit" class="btn font-weight-bold shadow-sm" style="background-color: #107c41; color: white; border-radius: 8px; padding: 8px 16px;">
                        Upload & Import
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
$(document).ready(function() {
    
    // --- 1. AJAX DETAIL (SHOW) ---
    $(document).on('click', '.btn-view', function(e) {
        e.preventDefault();
        // Tarik data dulu secara diam-diam, baru modalnya dimunculkan
        $.get($(this).attr('href'), function(response) {
            $('#modalDetail .modal-body').html(response);
            $('#modalDetail').modal('show');
        });
    });

    // --- 2. AJAX MUNCULIN FORM (CREATE & EDIT) ---
    $(document).on('click', '.btn-create, .btn-edit', function(e) {
        e.preventDefault();
        let title = $(this).hasClass('btn-create') ? 'Tambah Produk Baru' : 'Edit Produk';
        $('#modalFormTitle').text(title);
        
        $.get($(this).attr('href'), function(response) {
            $('#modalForm .modal-body').html(response);
            $('#modalForm').modal('show');
        });
    });

    // --- 3. AJAX SUBMIT FORM (CREATE, EDIT, IMPORT) ---
    $(document).on('submit', '.form-ajax', function(e) {
        e.preventDefault();
        let form = $(this);
        let submitBtn = form.find('button[type="submit"]');
        let originalText = submitBtn.html();

        // Efek loading di tombol
        submitBtn.html('<i class="fas fa-spinner fa-spin mr-1"></i> Memproses...').prop('disabled', true);

        $.ajax({
            url: form.attr('action'),
            type: form.attr('method'),
            data: new FormData(this), 
            processData: false,
            contentType: false,
            success: function(response) {
                $('#modalForm, #modalImport').modal('hide');
                
                setTimeout(function() {
                    Swal.fire({ 
                        icon: 'success', 
                        title: 'BERHASIL', 
                        text: response.message, 
                        showConfirmButton: false, // Dibuat tanpa tombol biar smooth
                        timer: 2000 // Hilang otomatis dalam 2 detik
                    });
                }, 300);
                
                $('#table-section').load(window.location.href + ' #table-section > *');
                $('#stats-section').load(window.location.href + ' #stats-section > *');
            },
            error: function(xhr) {
                submitBtn.html(originalText).prop('disabled', false);
                
                if(xhr.status === 422) {
                    let errors = xhr.responseJSON.errors || xhr.responseJSON.msgField;
                    let errorMsg = '';
                    $.each(errors, function(key, val) { errorMsg += val[0] + '<br>'; });
                    Swal.fire({ icon: 'error', title: 'Validasi Gagal', html: errorMsg, confirmButtonColor: '#ff3e1d' });
                } 
                else if (xhr.responseJSON && xhr.responseJSON.message) {
                    Swal.fire({ icon: 'error', title: 'Gagal', text: xhr.responseJSON.message, confirmButtonColor: '#ff3e1d' });
                }
                else {
                    Swal.fire({ icon: 'error', title: 'Oops...', text: 'Terjadi kesalahan sistem!', confirmButtonColor: '#ff3e1d' });
                }
            }
        });
    });

    // --- 4. FITUR LIVE SEARCH & FILTER AJAX ---
    let typingTimer;                
    let doneTypingInterval = 500; 

    $(document).on('keyup', '#search-input', function () {
        clearTimeout(typingTimer);
        typingTimer = setTimeout(performSearch, doneTypingInterval);
    });

    $(document).on('change', '#kategori-select', function() {
        performSearch();
    });

    function performSearch() {
        let search = $('#search-input').val();
        let kategori = $('#kategori-select').val();
        let url = "{{ url()->current() }}?search=" + encodeURIComponent(search) + "&kategori_id=" + encodeURIComponent(kategori);

        $('#table-section').css('opacity', '0.5'); 
        $('#table-section').load(url + ' #table-section > *', function() {
            $('#table-section').css('opacity', '1');
        });
        
        window.history.pushState({}, '', url); 
    }

    $(document).on('click', '.pagination a', function(e) {
        e.preventDefault();
        let url = $(this).attr('href');
        
        $('#table-section').css('opacity', '0.5');
        $('#table-section').load(url + ' #table-section > *', function() {
            $('#table-section').css('opacity', '1');
        });
        window.history.pushState({}, '', url);
    });

    $(document).on('change', '.custom-file-input', function() {
        let fileName = $(this).val().split('\\').pop();
        $(this).next('.custom-file-label').html(fileName);
    });

    $('#modalImport, #modalForm').on('hidden.bs.modal', function () {
        let form = $(this).find('form');
        let submitBtn = form.find('button[type="submit"]');

        form.trigger('reset'); // Kosongkan input
        $(this).find('.custom-file-label').html('Pilih file excel...'); // Reset tulisan browse file
        
        // Kembalikan tulisan tombol
        if ($(this).attr('id') === 'modalImport') {
            submitBtn.html('Upload & Import').prop('disabled', false);
        } else {
            submitBtn.html('Simpan').prop('disabled', false); 
        }
    });

});

function deleteAjax(btn, url, namaBarang) {
    Swal.fire({
        title: 'Hapus barang?',
        html: `Data <strong style="color: #566a7f;">${namaBarang}</strong> akan dihapus permanen. Tindakan ini tidak dapat dibatalkan.`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#ffe5e5',
        cancelButtonColor: '#fff',
        confirmButtonText: '<span style="color:#ff3e1d">Ya, Hapus</span>',
        cancelButtonText: '<span style="color:#566a7f">Batal</span>',
        customClass: { confirmButton: 'border border-danger', cancelButton: 'border border-secondary' }
    }).then((result) => {
        if (result.isConfirmed) {
            
            // Tampilkan SweetAlert Loading SEBELUM nge-hit server
            Swal.fire({
                title: 'Menghapus Data...',
                html: 'Mohon tunggu sebentar.',
                allowOutsideClick: false,
                showConfirmButton: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            // Eksekusi hapus ke server
            $.ajax({
                url: url,
                type: 'POST',
                data: { _method: 'DELETE', _token: '{{ csrf_token() }}' },
                success: function(response) {
                    // Transisi halus dari loading langsung ke centang hijau
                    Swal.fire({ 
                        icon: 'success', 
                        title: 'BERHASIL', 
                        text: response.message, 
                        showConfirmButton: false, 
                        timer: 1500 
                    });
                 
                    $(btn).closest('tr').fadeOut(500, function() {
                        // Refresh tabel biar nomor urutnya (1,2,3,4) ke-reset otomatis
                        $('#table-section').load(window.location.href + ' #table-section > *');
                    });
                    
                    $('#stats-section').load(window.location.href + ' #stats-section > *');
                },
                error: function(xhr) {
                    Swal.fire({ icon: 'error', title: 'Oops...', text: 'Gagal menghapus data!' });
                }
            });
        }
    });
}
    $(document).on('click', 'thead th a', function(e) {
        e.preventDefault();
        let url = $(this).attr('href');

        // Efek loading smooth (opacity)
        $('#table-section').css('opacity', '0.5');
        $('#table-section').load(url + ' #table-section > *', function() {
            $('#table-section').css('opacity', '1');
        });
        
        window.history.pushState({}, '', url);
    });
</script>
@endsection