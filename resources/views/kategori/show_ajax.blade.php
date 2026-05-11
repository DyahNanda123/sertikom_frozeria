<div class="container-fluid p-0">
    <div class="row">
        <div class="col-12">
            {{-- JUDUL & BADGE --}}
            <h4 class="font-weight-bold mb-2" style="color: #435ebe; font-size: 1.5rem;">
                {{ $kategori->nama_kategori }}
            </h4>
            <div class="mb-4">
                <span class="badge shadow-sm" style="background-color: #e7e7ff; color: #696cff; padding: 6px 12px; border-radius: 6px; font-weight: 600;">
                    <i class="fas fa-tags mr-1"></i> Kategori Produk
                </span>
            </div>

            {{-- KOTAK INFORMASI --}}
            <div class="p-4 mb-4" style="background-color: #f0f4f8; border-radius: 12px; border: 1px solid #e1e8ed;">
                <table class="table table-borderless table-sm m-0" style="color: #566a7f;">
                    <tr>
                        <td width="35%" class="text-muted" style="font-size: 13px; letter-spacing: 0.5px;">ID KATEGORI</td>
                        <td width="5%">:</td>
                        <td class="font-weight-bold text-dark">{{ $kategori->id }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted" style="font-size: 13px; letter-spacing: 0.5px;">JUMLAH BARANG</td>
                        <td>:</td>
                        <td class="font-weight-bold" style="color: #107c41; font-size: 15px;">
                            {{ $kategori->barang_count }} Item
                        </td>
                    </tr>
                    <tr>
                        <td class="text-muted" style="font-size: 13px; letter-spacing: 0.5px;">DIBUAT PADA</td>
                        <td>:</td>
                        <td class="font-weight-bold text-dark">
                            {{ \Carbon\Carbon::parse($kategori->created_at)->format('d-m-Y') }} 
                            <span class="text-muted font-weight-normal">({{ \Carbon\Carbon::parse($kategori->created_at)->format('H:i') }} WIB)</span>
                        </td>
                    </tr>
                    <tr>
                        <td class="text-muted" style="font-size: 13px; letter-spacing: 0.5px;">DIUPDATE PADA</td>
                        <td>:</td>
                        <td class="font-weight-bold text-dark">
                            {{ \Carbon\Carbon::parse($kategori->updated_at)->format('d-m-Y') }} 
                            <span class="text-muted font-weight-normal">({{ \Carbon\Carbon::parse($kategori->updated_at)->format('H:i') }} WIB)</span>
                        </td>
                    </tr>
                </table>
            </div>

            {{-- DESKRIPSI --}}
            <div>
                <h6 class="font-weight-bold text-muted mb-2" style="font-size: 12px; letter-spacing: 1px;">DESKRIPSI KATEGORI</h6>
                <p style="color: #566a7f; line-height: 1.6; font-size: 14px;">
                    @if($kategori->deskripsi)
                        {{ $kategori->deskripsi }}
                    @else
                        <span class="font-italic" style="color: #a1b0cb;">Kategori ini belum memiliki deskripsi tambahan.</span>
                    @endif
                </p>
            </div>
            
        </div>
    </div>
</div>