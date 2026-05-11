<?php

namespace App\Http\Controllers;

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class KategoriController extends Controller
{
    public function index(Request $request)
    {
        $query = Kategori::withCount('barang');

        // Pencarian
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where('nama_kategori', 'like', '%' . $search . '%');
        }

        // --- FITUR SORTING (PENGURUTAN) ---
        $sortField = $request->get('sort', 'id'); 
        $sortOrder = $request->get('order', 'desc'); 

        $kategori = $query->orderBy($sortField, $sortOrder)->paginate(10);
        
        $kategori->appends($request->all());

        return view('kategori.index', compact('kategori'));
    }

    public function create(Request $request)
    {
        if ($request->ajax()) {
            return view('kategori.create_ajax');
        }
    }

    public function store(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'nama_kategori' => 'required|string|max:255',
                'deskripsi'     => 'nullable|string'
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors()
                ], 422);
            }

            Kategori::create([
                'nama_kategori' => $request->nama_kategori,
                'deskripsi'     => $request->deskripsi
            ]);

            return response()->json(['status' => true, 'message' => 'Kategori berhasil ditambahkan!']);
        }
    }

    public function show(Request $request, $id)
    {
        if ($request->ajax()) {
            $kategori = Kategori::withCount('barang')->findOrFail($id);
            return view('kategori.show_ajax', compact('kategori'));
        }
    }

    public function edit(Request $request, $id)
    {
        if ($request->ajax()) {
            $kategori = Kategori::findOrFail($id);
            return view('kategori.edit_ajax', compact('kategori'));
        }
    }

    public function update(Request $request, $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'nama_kategori' => 'required|string|max:255',
                'deskripsi'     => 'nullable|string'
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors()
                ], 422);
            }

            $kategori = Kategori::findOrFail($id);
            $kategori->update([
                'nama_kategori' => $request->nama_kategori,
                'deskripsi'     => $request->deskripsi
            ]);

            return response()->json(['status' => true, 'message' => 'Kategori berhasil diperbarui!']);
        }
    }

    public function destroy(Request $request, $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $kategori = Kategori::withCount('barang')->findOrFail($id);
            
            if ($kategori->barang_count > 0) {
                return response()->json([
                    'status' => false, 
                    'message' => 'Gagal menghapus! Kategori "' . $kategori->nama_kategori . '" masih memiliki ' . $kategori->barang_count . ' barang aktif.'
                ], 400);
            }

            $kategori->delete();
            return response()->json([
                'status' => true, 
                'message' => 'Kategori "' . $kategori->nama_kategori . '" berhasil dihapus permanen.'
            ]);
        }
    }

    public function importExcel(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = ['file_excel' => ['required', 'mimes:xlsx,xls', 'max:2048']];
            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json(['status' => false, 'message' => 'Validasi Gagal', 'msgField' => $validator->errors()], 422);
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
                            if (empty(trim($value['A']))) break; 
                            
                            $insert[] = [
                                'nama_kategori' => $value['A'],
                                'deskripsi'     => $value['B'] ?? '-',
                                'created_at'    => now(),
                                'updated_at'    => now(),
                            ];
                        }
                    }

                    if (count($insert) > 0) {
                        Kategori::insert($insert);
                        return response()->json(['status' => true, 'message' => 'Data kategori berhasil diimport!']);
                    }
                }
                return response()->json(['status' => false, 'message' => 'File Excel kosong!'], 400);
            } catch (\Exception $e) {
                return response()->json(['status' => false, 'message' => 'Gagal Import: ' . $e->getMessage()], 500);
            }
        }
    }

    public function exportExcel()
    {
        $kategori = Kategori::withCount('barang')->get();
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', 'No')->setCellValue('B1', 'Nama Kategori')->setCellValue('C1', 'Jumlah Barang')->setCellValue('D1', 'Deskripsi');
        $sheet->getStyle('A1:D1')->getFont()->setBold(true);

        $row = 2;
        foreach ($kategori as $index => $k) {
            $sheet->setCellValue('A' . $row, $index + 1);
            $sheet->setCellValue('B' . $row, $k->nama_kategori);
            $sheet->setCellValue('C' . $row, $k->barang_count . ' Item');
            $sheet->setCellValue('D' . $row, $k->deskripsi ?? '-');
            $row++;
        }

        foreach (range('A', 'D') as $col) $sheet->getColumnDimension($col)->setAutoSize(true);

        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Data_Kategori_Frozeria.xlsx"');
        $writer->save('php://output');
        exit;
    }

    public function exportPdf()
    {
        $kategori = Kategori::withCount('barang')->get();
        $pdf = Pdf::loadView('kategori.export_pdf', compact('kategori'));
        $pdf->setPaper('a4', 'portrait');
        return $pdf->stream('Laporan_Kategori_Frozeria.pdf'); // Ganti ke stream biar "numpuk"
    }
}