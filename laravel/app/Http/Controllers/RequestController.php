<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LetterRequest;

class RequestController extends Controller
{
    public function index()
    {
        return view('letter-submission', [
            'title' => 'Letter Submission',
            'heading' => 'Pengajuan Surat',
            'requests' => LetterRequest::all()
        ]);
    }
}
