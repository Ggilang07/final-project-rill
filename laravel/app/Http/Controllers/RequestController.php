<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LetterRequest;
use App\Models\UploadedLetter;
use Illuminate\Foundation\Validation\ValidatesRequests;

class RequestController extends Controller
{
    use ValidatesRequests; // ✅ Tambahkan ini

    public function index(Request $request)
    {
        $query = LetterRequest::with('user');

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('letter_number', 'like', "%$search%")
                  ->orWhereHas('user', function ($u) use ($search) {
                      $u->where('name', 'like', "%$search%");
                  })
                  ->orWhere('category', 'like', "%$search%")
                  ->orWhere('reason', 'like', "%$search%");
            });
        }

        // Filter category
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        // Filter status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Order
        $order = $request->get('order', 'desc');
        $query->orderBy('created_at', $order);

        // Ambil data untuk mobile dan desktop (misal 5 dan 10 per halaman)
        $requestsMobile = (clone $query)->paginate(5, ['*'], 'mobile_page');
        $requestsDesktop = (clone $query)->paginate(10, ['*'], 'desktop_page');

        // Ambil kategori unik untuk filter
        $categories = LetterRequest::select('category')->distinct()->pluck('category');

        return view('letter-submission', [
            'title' => 'Letter Submission',
            'heading' => 'Pengajuan Surat',
            'requestsMobile' => $requestsMobile,
            'requestsDesktop' => $requestsDesktop,
            'categories' => $categories,
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
