<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\LetterRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class StatusController extends Controller
{
    public function index(Request $request)
    {
        try {
            $user = $request->user();
            if (!$user) {
                return response()->json(['message' => 'Unauthorized'], 401);
            }

            // Debug user
            Log::info('User data:', [
                'id' => $user->user_id,
                'email' => $user->email
            ]);

            // Get letters with debug
            try {
                $letters = LetterRequest::query()
                    ->with(['requestedBy', 'validator', 'uploadedLetter'])
                    ->where('request_by', $user->user_id)
                    ->get();

                Log::info('Letters query successful', [
                    'count' => $letters->count(),
                    'sql' => LetterRequest::query()
                        ->with(['requestedBy', 'validator', 'uploadedLetter'])
                        ->where('request_by', $user->user_id)
                        ->toSql()
                ]);
            } catch (\Exception $e) {
                Log::error('Query failed:', [
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString()
                ]);
                throw $e;
            }

            // Map data with debug
            try {
                $mappedData = $letters->map(function ($letter) {
                    Log::info('Processing letter:', [
                        'id' => $letter->request_id,
                        'validator' => $letter->validator ? $letter->validator->name : 'none',
                        'pdf' => $letter->uploadedLetter ? 'exists' : 'none'
                    ]);

                    return [
                        'request_id' => $letter->request_id,
                        'letter_number' => $letter->letter_number,
                        'category' => $letter->category,
                        'status' => $letter->status,
                        'created_at' => $letter->created_at,
                        'letter_date' => $letter->letter_date,
                        'validated_by' => $letter->validator ? $letter->validator->name : null,
                        'link_pdf' => $letter->uploadedLetter ? $letter->uploadedLetter->link_pdf : null
                    ];
                });
            } catch (\Exception $e) {
                Log::error('Mapping failed:', [
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString()
                ]);
                throw $e;
            }

            return response()->json(['data' => $mappedData]);
        } catch (\Exception $e) {
            Log::error('Status letters error:', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'message' => 'Error fetching letters: ' . $e->getMessage()
            ], 500);
        }
    }
}
