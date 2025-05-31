<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LetterRequest extends Model
{
    use HasFactory;

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'request_by', 'user_id');
    }
    public function template(): BelongsTo
    {
        return $this->belongsTo(LetterTemplate::class, 'template_id', 'template_id');
    }
}
