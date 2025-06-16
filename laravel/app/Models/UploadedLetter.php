<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;

class UploadedLetter extends Model
{
    use HasFactory;

    protected $fillable = [
        'request_id',
        'link_pdf'
    ];

    public function letterRequest(): BelongsTo
    {
        return $this->belongsTo(LetterRequest::class, 'request_id', 'request_id');
    }
}
