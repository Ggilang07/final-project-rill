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
            'Izin_Tidak_Masuk' => 'IZ-TM',
            'Izin_Terlambat' => 'IZ-TB',
            'Izin_Pulang_Awal' => 'IZ-PA',
            'Izin_Sakit' => 'IZ-SK',
            'Cuti_Tahunan' => 'CT-TH',
            'Cuti_Melahirkan' => 'CT-ML',
            'Cuti_Menikah' => 'CT-MN',
            'Cuti_Kematian' => 'CT-KM',
            'Cuti_Ibadah' => 'CT-IB',
            'Cuti_Besar' => 'CT-BR',
            'Dinas_Luar' => 'DN-LR',
            'Work_From_Home' => 'WFH',
            'Surat_Keterangan_Kerja' => 'SK-KJ',
            'Surat_Keterangan_Penghasilan' => 'SK-PG',
            'Surat_Keterangan_Aktif' => 'SK-AK',
            'Surat_Tugas' => 'ST',
            'Surat_Rekomendasi' => 'SR',
            'Surat_Undangan' => 'UND',
            'Surat_Pengunduran_Diri' => 'SPD'
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
            'Izin_Tidak_Masuk',
            'Izin_Terlambat',
            'Izin_Pulang_Awal',
            'Izin_Sakit',
            'Cuti_Tahunan',
            'Cuti_Melahirkan',
            'Cuti_Menikah',
            'Cuti_Kematian',
            'Cuti_Ibadah',
            'Cuti_Besar',
            'Dinas_Luar',
            'Work_From_Home',
            'Surat_Keterangan_Kerja',
            'Surat_Keterangan_Penghasilan',
            'Surat_Keterangan_Aktif',
            'Surat_Tugas',
            'Surat_Rekomendasi',
            'Surat_Undangan',
            'Surat_Pengunduran_Diri'
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
