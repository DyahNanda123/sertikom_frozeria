<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Barryvdh\DomPDF\Facade\Pdf;

class BarangController extends Controller
{
public function index(Request $request)
{
    $query = Barang::with('kategori');

    // LOGIKA SEARCH 
    if ($request->has('search') && $request->search != '') {
        $search = $request->search;
        $query->where('nama_barang', 'like', '%' . $search . '%');
    }

    // LOGIKA FILTER KATEGORI 
    if ($request->has('kategori_id') && $request->kategori_id != '') {
        $query->where('kategori_id', $request->kategori_id);
    }

    // 4. LOGIKA SORTING 
    $sortField = $request->get('sort', 'id'); 
    $sortOrder = $request->get('order', 'desc'); // Default terbaru di atas

    // Eksekusi urutan berdasarkan kolom Nama Barang
    $barang = $query->orderBy($sortField, $sortOrder)->paginate(10);
    
    $barang->appends($request->all());

    // Data buat dropdown filter & statistik dashboard
    $kategori = Kategori::all();
    $total_barang = Barang::count();
    $stok_menipis = Barang::whereColumn('jumlah_stok', '<=', 'stok_minimum')->count();
    $stok_habis = Barang::where('jumlah_stok', '<=', 0)->count();

    return view('barang.index', compact('barang', 'kategori', 'total_barang', 'stok_menipis', 'stok_habis'));
}

    public function create(Request $request)
    {
        $kategori = Kategori::all();
        if ($request->ajax()) {
            return view('barang.create_ajax', compact('kategori'));
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_barang' => 'required',
            'satuan' => 'required',
            'kategori_id' => 'required',
            'jumlah_stok' => 'required|numeric',
            'stok_minimum' => 'required|numeric',
            'harga_beli' => 'required|numeric',
            'harga_jual' => 'required|numeric',
            'foto_barang' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $data = $request->except('foto_barang');

        if ($request->hasFile('foto_barang')) {
            $file = $request->file('foto_barang');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('barang', $filename, 'public');
            $data['foto_barang'] = $filename;
        }

        Barang::create($data);

        return response()->json(['status' => 'success', 'message' => 'Produk berhasil ditambahkan!']);
    }

    public function show(Request $request, $id)
    {
        $barang = Barang::with('kategori')->findOrFail($id);
        if ($request->ajax()) {
            return view('barang.show_ajax', compact('barang'));
        }
    }

    public function edit(Request $request, $id)
    {
        $barang = Barang::findOrFail($id);
        $kategori = Kategori::all();
        if ($request->ajax()) {
            return view('barang.edit_ajax', compact('barang', 'kategori'));
        }
    }

    public function update(Request $request, $id)
    {
        $barang = Barang::findOrFail($id);
        $data = $request->except('foto_barang');

        if ($request->hasFile('foto_barang')) {
            if ($barang->foto_barang && Storage::disk('public')->exists('barang/' . $barang->foto_barang)) {
                Storage::disk('public')->delete('barang/' . $barang->foto_barang);
            }
            $file = $request->file('foto_barang');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('barang', $filename, 'public');
            $data['foto_barang'] = $filename;
        }

        $barang->update($data);

        return response()->json(['status' => 'success', 'message' => 'Data produk berhasil diperbarui!']);
    }

    public function destroy(Request $request, $id)
    {
        $barang = Barang::findOrFail($id);
        
        if ($barang->foto_barang && Storage::disk('public')->exists('barang/' . $barang->foto_barang)) {
            Storage::disk('public')->delete('barang/' . $barang->foto_barang);
        }

        $barang->delete();

        if ($request->ajax()) {
            return response()->json(['status' => 'success', 'message' => 'Data barang berhasil dihapus!']);
        }
    }

    public function importExcel(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'file_excel' => ['required', 'mimes:xlsx,xls', 'max:2048']
            ];

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors()
                ], 422); 
            }

            try {
                $file = $request->file('file_excel');
                $reader = IOFactory::createReader('Xlsx');
                $reader->setReadDataOnly(true);
                $spreadsheet = $reader->load($file->getRealPath());
                $sheet = $spreadsheet->getActiveSheet();
                
                $data = $sheet->toArray(null, false, true, true);
                $insert = [];

                if (count($data) > 1) { 
                    foreach ($data as $baris => $value) {
                        if ($baris > 1) { 
                            if (empty(trim($value['A']))) {
                                break; 
                            }

                            $insert[] = [
                                'nama_barang'   => $value['A'], 
                                'kategori_id'   => $value['B'], 
                                'satuan'        => $value['C'] ?? '-', 
                                'jumlah_stok'   => $value['D'] ?? 0,  
                                'stok_minimum'  => $value['E'] ?? 0,   
                                'harga_beli'    => $value['F'] ?? 0, 
                                'harga_jual'    => $value['G'] ?? 0,
                                'berat_ukuran'  => $value['H'] ?? '-',
                                'lokasi_simpan' => $value['I'] ?? '-',
                                'deskripsi'     => $value['J'],
                                'created_at'    => now(),
                                'updated_at'    => now(),
                            ];
                        }
                    }

                    if (count($insert) > 0) {
                        Barang::insertOrIgnore($insert);
                        return response()->json([
                            'status' => true,
                            'message' => 'Data barang berhasil diimport!'
                        ]);
                    } else {
                        return response()->json([
                            'status' => false,
                            'message' => 'Data di Excel kosong atau format tidak sesuai!'
                        ], 400);
                    }

                } else {
                    return response()->json([
                        'status' => false,
                        'message' => 'Tidak ada data di dalam file Excel'
                    ], 400);
                }

            } catch (\Exception $e) {
                return response()->json([
                    'status' => false,
                    'message' => 'Gagal Import: ' . $e->getMessage()
                ], 500); 
            }
        }
        return redirect('/');
    }
    
    public function exportExcel()
    {
        $barang = Barang::with('kategori')->orderBy('nama_barang', 'asc')->get();

        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Judul Kolom (Header)
        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'Nama Barang');
        $sheet->setCellValue('C1', 'Kategori');
        $sheet->setCellValue('D1', 'Jumlah Stok');
        $sheet->setCellValue('E1', 'Satuan');
        $sheet->setCellValue('F1', 'Harga Beli');
        $sheet->setCellValue('G1', 'Harga Jual');
        $sheet->setCellValue('H1', 'Lokasi Simpan');

        $sheet->getStyle('A1:H1')->getFont()->setBold(true);

        $no = 1;
        $baris = 2; 
        foreach ($barang as $b) {
            $sheet->setCellValue('A' . $baris, $no);
            $sheet->setCellValue('B' . $baris, $b->nama_barang);
            $sheet->setCellValue('C' . $baris, $b->kategori->nama_kategori ?? '-');
            $sheet->setCellValue('D' . $baris, $b->jumlah_stok);
            $sheet->setCellValue('E' . $baris, $b->satuan);
            $sheet->setCellValue('F' . $baris, $b->harga_beli);
            $sheet->setCellValue('G' . $baris, $b->harga_jual);
            $sheet->setCellValue('H' . $baris, $b->lokasi_simpan ?? '-');
            
            $baris++;
            $no++;
        }

        // Auto size kolom
        foreach (range('A', 'H') as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true);
        }

        $sheet->setTitle('Data Stok Frozeria'); 

        $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
        $filename = 'Laporan_Stok_Frozeria_' . date('Y-m-d_H-i-s') . '.xlsx';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        header('Cache-Control: max-age=1');
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
        header('Last-Modified:' . gmdate('D, d M Y H:i:s') . ' GMT');
        header('Cache-Control: cache, must-revalidate');
        header('Pragma: public');

        $writer->save('php://output');
        exit;
    }

    public function exportPdf()
    {
        $barang = Barang::with('kategori')->orderBy('nama_barang', 'asc')->get();

        $pdf = Pdf::loadView('barang.export_pdf', ['barang' => $barang]);
       
        $pdf->setPaper('a4', 'landscape'); 
        $pdf->setOption("isRemoteEnabled", true); 

        return $pdf->stream('Laporan_Stok_Frozeria_'.date('Y-m-d_H-i-s').'.pdf');
    }
}