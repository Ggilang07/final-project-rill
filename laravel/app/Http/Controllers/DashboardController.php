<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LetterRequest;

class DashboardController extends Controller
{
    public function index()
    {
        return view('dashboard', [
            'title' => 'Dashboard',
            'heading' => 'Dashboard Admin',
            'total' => LetterRequest::count(),
            'hariIni' => LetterRequest::whereDate('created_at', now())->count(),
            'approved' => LetterRequest::where('status', 'approved')->count(),
            'pending' => LetterRequest::where('status', 'pending')->count(),
            'rejected' => LetterRequest::where('status', 'rejected')->count(),
            'cancelled' => LetterRequest::where('status', 'cancelled')->count(),
        ]);
    }
}
