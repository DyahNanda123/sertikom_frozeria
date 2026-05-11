@extends('layouts.app')

@section('title', 'Manajemen Kategori')

@section('content')

{{-- HEADER BOX --}}
<div class="bg-white p-4 mb-4 shadow-sm d-flex justify-content-between align-items-center flex-wrap" style="border-radius: 16px; border-left: 6px solid var(--fz-primary);">
    <div class="d-flex align-items-center mb-2 mb-md-0">
        <div class="bg-primary text-white mr-3 d-flex align-items-center justify-content-center shadow" style="width: 50px; height: 50px; border-radius: 12px;">
            <i class="fas fa-tags"></i>
        </div>
        <div>
            <h1 style="font-weight: 800; font-size: 1.5rem; margin:0;">Kategori Barang</h1>
            <p class="text-muted m-0">Kelola kelompok produk Frozeria</p>
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
                <a class="dropdown-item py-2 font-weight-bold d-flex align-items-center" href="{{ route('kategori.exportExcel') }}" style="color: #107c41; border-radius: 8px;">
                    <i class="fas fa-file-excel fa-lg mr-3"></i> Excel
                </a>
                <a class="dropdown-item py-2 font-weight-bold d-flex align-items-center" href="{{ route('kategori.exportPdf') }}" style="color: #e3242b; border-radius: 8px;">
                    <i class="fas fa-file-pdf fa-lg mr-3"></i> PDF
                </a>
            </div>
        </div>

        {{-- Tombol Import --}}
        <button class="btn bg-white font-weight-bold shadow-sm mr-2" data-toggle="modal" data-target="#modalImport" style="border-radius: 10px; padding: 10px 16px; border: 1px solid #d9dee3; color: #566a7f;">
            <i class="fas fa-download mr-1"></i> Import
        </button>

        {{-- Tombol Tambah Kategori --}}
        <a href="{{ route('kategori.create') }}" class="btn btn-primary btn-create font-weight-bold shadow-sm" style="border-radius: 10px; padding: 10px 20px; border: none; background: linear-gradient(135deg, #6366f1, #a855f7);">
            <i class="fas fa-plus mr-2"></i> Tambah Kategori
        </a>
    </div>
</div>

<div class="bg-white p-3 mb-4 shadow-sm" style="border-radius: 16px;">
    <form id="search-form" action="{{ url()->current() }}" method="GET" class="m-0" onsubmit="return false;">
        <div class="input-group shadow-sm h-100" style="border-radius: 10px; overflow: hidden; background-color: #f3f4f6;">
            <div class="input-group-prepend">
                <span class="input-group-text border-0 bg-transparent text-primary px-3">
                    <i class="fas fa-search"></i>
                </span>
            </div>
            <input type="text" name="search" id="search-input" class="form-control border-0 bg-transparent font-weight-bold" placeholder="Cari nama kategori (ketik untuk mencari)..." value="{{ request('search') }}" autocomplete="off">
        </div>
    </form>
</div>
<div class="bg-white p-4 shadow-sm" style="border-radius: 16px;" id="table-section">
    <div class="table-responsive">
        <table class="table table-hover">
            <thead>
            <tr class="text-muted" style="text-transform: uppercase; font-size: 11px; letter-spacing: 1px;">
                <th width="5%">No</th>
                <th width="35%">
                    {{-- Tombol Klik untuk Urutkan Nama --}}
                    <a href="{{ request()->fullUrlWithQuery(['sort' => 'nama_kategori', 'order' => request('order') == 'asc' ? 'desc' : 'asc']) }}" class="text-muted d-flex align-items-center justify-content-between">
                        NAMA KATEGORI
                        <span class="ml-1">
                            @if(request('sort') == 'nama_kategori')
                                <i class="fas fa-sort-alpha-{{ request('order') == 'asc' ? 'down' : 'up' }} text-primary"></i>
                            @else
                                <i class="fas fa-sort text-light"></i>
                            @endif
                        </span>
                    </a>
                </th>
                <th width="20%" class="text-center">Jumlah Barang</th>
                <th width="20%" class="text-center">Dibuat Pada</th>
                <th width="20%" class="text-center">Aksi</th>
            </tr>
        </thead>
            <tbody>
                @forelse($kategori as $index => $item)
                <tr>
                    <td class="align-middle text-muted">{{ $kategori->firstItem() + $index }}</td>
                    <td class="align-middle font-weight-bold text-dark">{{ $item->nama_kategori }}</td>
                    
                    <td class="align-middle text-center">
                        <span class="badge shadow-sm" style="border-radius: 8px; background-color: #e7e7ff; color: #696cff; font-weight: 800; padding: 6px 12px;">
                            {{ $item->barang_count }} Item
                        </span>
                    </td>
                    
                    <td class="align-middle text-center text-muted" style="font-size: 13px;">
                        {{ \Carbon\Carbon::parse($item->created_at)->format('d M Y') }}
                    </td>
                    
                    <td class="align-middle text-center">
                        <div class="d-flex justify-content-center">
                            <a href="{{ route('kategori.show', $item->id) }}" class="fz-btn-action btn-view" title="Detail"><i class="fas fa-eye"></i></a>
                            <a href="{{ route('kategori.edit', $item->id) }}" class="fz-btn-action btn-edit mx-2" title="Edit"><i class="fas fa-pencil-alt"></i></a>
                            <button class="fz-btn-action btn-delete" onclick="deleteAjax(this, '{{ route('kategori.destroy', $item->id) }}', '{{ $item->nama_kategori }}')" title="Hapus"><i class="fas fa-trash"></i></button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" class="text-center p-5 text-muted">Belum ada data kategori.</td></tr>
                @endforelse
            </tbody>
        </table>
        
        @if($kategori->hasPages())
            <div class="d-flex justify-content-center mt-4">
                {{ $kategori->links('pagination::bootstrap-4') }}
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
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content" style="border-radius: 16px; border: none; box-shadow: 0 10px 30px rgba(0,0,0,0.1);">
            <div class="modal-header border-0 p-4">
                <h5 class="modal-title font-weight-bold" id="modalFormTitle" style="color: #566a7f;">Form Kategori</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <div class="modal-body p-4 pt-0"></div>
        </div>
    </div>
</div>
<div class="modal fade" id="modalImport" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content" style="border-radius: 16px; border: none;">
            <div class="modal-header border-0 p-4 pb-2">
                <h5 class="modal-title font-weight-bold"><i class="fas fa-file-excel mr-2 text-success"></i> Import Kategori</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <form action="{{ route('kategori.importExcel') }}" method="POST" enctype="multipart/form-data" class="form-ajax">
                @csrf
                <div class="modal-body p-4 pt-0">
                    <p class="text-muted small">Pilih file Excel (.xlsx) dengan kolom: <b>A: Nama Kategori, B: Deskripsi</b></p>
                    <div class="custom-file mb-3">
                        <input type="file" name="file_excel" class="custom-file-input" id="importKategori" accept=".xlsx" required>
                        <label class="custom-file-label" for="importKategori">Pilih file excel...</label>
                    </div>
                </div>
                <div class="modal-footer border-0 p-4 pt-0">
                    <button type="button" class="btn btn-light font-weight-bold" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success font-weight-bold">Upload & Import</button>
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

    $(document).on('change', '.custom-file-input', function() {
        let fileName = $(this).val().split('\\').pop();
        $(this).next('.custom-file-label').html(fileName);
    });

    $(document).on('click', '.btn-view', function(e) {
        e.preventDefault();
        $.get($(this).attr('href'), function(response) {
            $('#modalDetail .modal-body').html(response);
            $('#modalDetail').modal('show');
        });
    });
    $(document).on('click', '.btn-create, .btn-edit', function(e) {
        e.preventDefault();
        let title = $(this).hasClass('btn-create') ? 'Tambah Kategori Baru' : 'Edit Kategori';
        $('#modalFormTitle').text(title);
        
        $.get($(this).attr('href'), function(response) {
            $('#modalForm .modal-body').html(response);
            $('#modalForm').modal('show');
        });
    });

    $(document).on('submit', '.form-ajax', function(e) {
        e.preventDefault();
        let form = $(this);
        let submitBtn = form.find('button[type="submit"]');
        let originalText = submitBtn.html();

        submitBtn.html('<i class="fas fa-spinner fa-spin mr-1"></i> Memproses...').prop('disabled', true);

        $.ajax({
            url: form.attr('action'),
            type: form.attr('method'),
            data: new FormData(this), 
            processData: false,
            contentType: false,
            success: function(response) {
                // Paksa tutup modal dan hapus backdrop-nya biar gak nyangkut
                $('#modalForm, #modalImport').modal('hide');
                $('body').removeClass('modal-open');
                $('.modal-backdrop').remove();
                
                setTimeout(function() {
                    Swal.fire({ 
                        icon: 'success', 
                        title: 'BERHASIL', 
                        text: response.message, 
                        showConfirmButton: false, 
                        timer: 2000 
                    });
                }, 300);
                
                // Refresh tabel tanpa loading halaman
                $('#table-section').load(window.location.href + ' #table-section > *');
            },
            error: function(xhr) {
                submitBtn.html(originalText).prop('disabled', false);
                if(xhr.status === 422) {
                    let errors = xhr.responseJSON.errors || xhr.responseJSON.msgField;
                    let errorMsg = '';
                    $.each(errors, function(key, val) { errorMsg += val[0] + '<br>'; });
                    Swal.fire({ icon: 'error', title: 'Validasi Gagal', html: errorMsg, confirmButtonColor: '#ff3e1d' });
                } else if (xhr.responseJSON && xhr.responseJSON.message) {
                    Swal.fire({ icon: 'error', title: 'Gagal', text: xhr.responseJSON.message, confirmButtonColor: '#ff3e1d' });
                } else {
                    Swal.fire({ icon: 'error', title: 'Oops...', text: 'Terjadi kesalahan sistem!', confirmButtonColor: '#ff3e1d' });
                }
            }
        });
    });
    let typingTimer;                
    let doneTypingInterval = 500; 

    $(document).on('keyup', '#search-input', function () {
        clearTimeout(typingTimer);
        typingTimer = setTimeout(performSearch, doneTypingInterval);
    });

    function performSearch() {
        let search = $('#search-input').val();
        let url = "{{ url()->current() }}?search=" + encodeURIComponent(search);

        $('#table-section').css('opacity', '0.5'); 
        $('#table-section').load(url + ' #table-section > *', function() {
            $('#table-section').css('opacity', '1');
        });
        
        window.history.pushState({}, '', url); 
    }

    $(document).on('click', '.pagination a', function(e) {
        e.preventDefault();
        let url = $(this).attr('href');
        $('#table-section').css('opacity', '0.5').load(url + ' #table-section > *', function() { $(this).css('opacity', '1'); });
        window.history.pushState({}, '', url);
    });

    $('#modalImport, #modalForm').on('hidden.bs.modal', function () {
        let form = $(this).find('form');
        let submitBtn = form.find('button[type="submit"]');
        
        form.trigger('reset'); 
        $(this).find('.custom-file-label').html('Pilih file excel...'); 
        
        if ($(this).attr('id') === 'modalImport') {
            submitBtn.html('Upload & Import').prop('disabled', false);
        } else {
            submitBtn.html('Simpan').prop('disabled', false); 
        }
    });
});

function deleteAjax(btn, url, namaKategori) {
    Swal.fire({
        title: 'Hapus Kategori?',
        html: `Apakah kamu yakin ingin menghapus kategori <strong style="color: #435ebe;">${namaKategori}</strong>?`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#ffe5e5',
        cancelButtonColor: '#fff',
        confirmButtonText: '<span style="color:#ff3e1d">Ya, Hapus</span>',
        cancelButtonText: '<span style="color:#566a7f">Batal</span>',
        customClass: { confirmButton: 'border border-danger', cancelButton: 'border border-secondary' }
    }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire({
                title: 'Sedang Memproses...',
                allowOutsideClick: false,
                showConfirmButton: false,
                didOpen: () => { Swal.showLoading(); }
            });

            $.ajax({
                url: url,
                type: 'POST',
                data: { _method: 'DELETE', _token: '{{ csrf_token() }}' },
                success: function(response) {
                    Swal.fire({ icon: 'success', title: 'BERHASIL', text: response.message, showConfirmButton: false, timer: 1500 });
                    $(btn).closest('tr').fadeOut(500, function() {
                        $('#table-section').load(window.location.href + ' #table-section > *');
                    });
                },
                error: function(xhr) {
                    let errorMsg = xhr.responseJSON && xhr.responseJSON.message ? xhr.responseJSON.message : 'Gagal menghapus data!';
                    Swal.fire({ icon: 'error', title: 'TIDAK DAPAT DIHAPUS', text: errorMsg, confirmButtonColor: '#ff3e1d' });
                }
            });
        }
    });
}
$(document).on('click', 'thead th a', function(e) {
    e.preventDefault();
    let url = $(this).attr('href');

    $('#table-section').css('opacity', '0.5');
    $('#table-section').load(url + ' #table-section > *', function() {
        $('#table-section').css('opacity', '1');
    });
    
    window.history.pushState({}, '', url);
});
</script>
@endsection