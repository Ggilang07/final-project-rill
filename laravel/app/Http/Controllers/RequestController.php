<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use App\Models\LetterRequest;
use App\Models\UploadedLetter;
use Illuminate\Foundation\Validation\ValidatesRequests;

class RequestController extends Controller
{
    use ValidatesRequests;

    public function index(Request $request)
    {
        $query = LetterRequest::with('requestedBy'); // Changed from 'user' to 'requestedBy'

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('letter_number', 'like', "%$search%")
                    ->orWhereHas('requestedBy', function ($u) use ($search) { // Changed from 'user' to 'requestedBy'
                        $u->where('name', 'like', "%$search%");
                    })
                    ->orWhere('category', 'like', "%$search%");
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
            $rules = [
                'request_id' => 'required|exists:letter_requests,request_id',
                'status' => 'required|in:approved,rejected',
            ];

            if ($request->status === 'approved') {
                $rules['link_pdf'] = 'required|url';
            }

            $validated = $request->validate($rules);

            DB::beginTransaction();

            // Update juga is_validated menjadi true
            LetterRequest::where('request_id', $validated['request_id'])
                ->update([
                    'status' => $validated['status'],
                    'validated_by' => auth()->user()->user_id,
                    'is_validated' => true
                ]);

            if ($validated['status'] === 'approved' && isset($validated['link_pdf'])) {
                UploadedLetter::create([
                    'request_id' => $validated['request_id'],
                    'link_pdf' => $validated['link_pdf']
                ]);
            }

            DB::commit();
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }
    public function getDetail($id)
    {
        $letter = LetterRequest::with(['requestedBy', 'validator', 'uploadedLetter'])
            ->findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => [
                'letter_number' => $letter->letter_number,
                'letter_date' => $letter->formatted_date,
                'category' => str_replace('_', ' ', $letter->category),
                'reason' => $letter->reason,
                'status' => $letter->status,
                'is_validated' => $letter->is_validated,
                'requested_by' => $letter->requestedBy->name,
                'validated_by' => $letter->validator ? $letter->validator->name : '-',
                'link_pdf' => $letter->uploadedLetter ? $letter->uploadedLetter->link_pdf : '-'
            ]
        ]);
    }
}
