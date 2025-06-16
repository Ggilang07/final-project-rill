<?php

namespace App\Http\Controllers\Api;

use Carbon\Carbon;
use App\Models\LetterRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RequestController extends Controller
{
    public function numberToRoman($number) 
    {
        $romans = [
            1 => "I",
            2 => "II",
            3 => "III",
            4 => "IV",
            5 => "V",
            6 => "VI",
            7 => "VII",
            8 => "VIII",
            9 => "IX",
            10 => "X",
            11 => "XI",
            12 => "XII"
        ];
        return $romans[$number] ?? '';
    }

    public function generateLetterNumber($category, $letterDate)
    {
        $prefix = 'FAV';
        $month = Carbon::parse($letterDate)->month;
        $romanMonth = $this->numberToRoman($month);
        $year = Carbon::parse($letterDate)->year;
        $categoryCodes = [
            'IZIN_TIDAK_MASUK' => 'IZ-TM',
            'IZIN_TERLAMBAT' => 'IZ-TB',
            'IZIN_PULANG_AWAL' => 'IZ-PA',
            'IZIN_SAKIT' => 'IZ-SK',
            'CUTI_TAHUNAN' => 'CT-TH',
            'CUTI_MELAHIRKAN' => 'CT-ML',
            'CUTI_MENIKAH' => 'CT-MN',
            'CUTI_KEMATIAN' => 'CT-KM',
            'CUTI_IBADAH' => 'CT-IB',
            'CUTI_BESAR' => 'CT-BR',
            'DINAS_LUAR' => 'DN-LR',
            'WORK_FROM_HOME' => 'WFH',
            'SURAT_KETERANGAN_KERJA' => 'SK-KJ',
            'SURAT_KETERANGAN_PENGHASILAN' => 'SK-PG',
            'SURAT_KETERANGAN_AKTIF' => 'SK-AK',
            'SURAT_TUGAS' => 'ST',
            'SURAT_REKOMENDASI' => 'SR',
            'SURAT_UNDANGAN' => 'UND',
            'SURAT_PENGUNDURAN_DIRI' => 'SPD'
        ];

        $code = $categoryCodes[$category] ?? strtoupper(substr($category, 0, 3));

        // Hitung jumlah surat dengan kategori dan tahun yang sama
        $count = LetterRequest::where('category', $category)
            ->whereYear('letter_date', $year)
            ->count();

        $nextNumber = str_pad($count + 1, 3, '0', STR_PAD_LEFT); // 001, 002, ...

        return "$nextNumber/$prefix/$code/$romanMonth/$year";
    }
    public function getCategories()
    {
        $categories = [
            'IZIN_TIDAK_MASUK',
            'IZIN_TERLAMBAT',
            'IZIN_PULANG_AWAL',
            'IZIN_SAKIT',
            'CUTI_TAHUNAN',
            'CUTI_MELAHIRKAN',
            'CUTI_MENIKAH',
            'CUTI_KEMATIAN',
            'CUTI_IBADAH',
            'CUTI_BESAR',
            'DINAS_LUAR',
            'WORK_FROM_HOME',
            'SURAT_KETERANGAN_KERJA',
            'SURAT_KETERANGAN_PENGHASILAN',
            'SURAT_KETERANGAN_AKTIF',
            'SURAT_TUGAS',
            'SURAT_REKOMENDASI',
            'SURAT_UNDANGAN',
            'SURAT_PENGUNDURAN_DIRI'
        ];
        return response()->json(['data' => $categories]);
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'category' => 'required|string',
                'letter_date' => 'required|date',
                'reason' => 'required|string|min:10', // Add validation for reason
            ]);

            $letterNumber = $this->generateLetterNumber(
                $validated['category'],
                $validated['letter_date']  // Pass letter_date to method
            );

            $letter = LetterRequest::create([
                'request_by' => auth()->id(),
                'letter_number' => $letterNumber,
                'category' => $validated['category'],
                'letter_date' => $validated['letter_date'],
                'reason' => $validated['reason'], // Add reason
                'status' => 'pending'
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Surat berhasil dibuat',
                'data' => $letter
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal membuat surat: ' . $e->getMessage()
            ], 500);
        }
    }
}
