<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LetterRequest;
use App\Models\UploadedLetter;
use Illuminate\Foundation\Validation\ValidatesRequests;

class RequestController extends Controller
{
    use ValidatesRequests; // ✅ Tambahkan ini

    public function index()
    {
        return view('letter-submission', [
            'title' => 'Letter Submission',
            'heading' => 'Pengajuan Surat',
            'requests' => LetterRequest::all()
        ]);
    }

    public function validateRequest(Request $request)
    {
        try {
            $validated = $request->validate([
                'request_id' => 'required|exists:letter_requests,request_id',
                'status' => 'required|in:approved,rejected',
                'link_pdf' => 'nullable|url'
            ]);

            if ($validated['status'] === 'approved' && !$validated['link_pdf']) {
                return response()->json([
                    'success' => false,
                    'message' => 'Link surat harus diisi.'
                ]);
            }

            if ($validated['status'] === 'approved') {
                UploadedLetter::create([
                    'request_id' => $validated['request_id'],
                    'link_pdf' => $validated['link_pdf'],
                    'validated_by' => auth()->id()
                ]);
            }

            LetterRequest::where('request_id', $validated['request_id'])
                ->update(['status' => $validated['status']]);

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }
}
