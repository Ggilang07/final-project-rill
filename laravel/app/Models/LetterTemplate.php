<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LetterTemplate extends Model
{
    use HasFactory;

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by', 'user_id');
    }
    public function letterRequests(): HasMany
    {
        return $this->hasMany(LetterRequest::class, 'template_id', 'template_id');
    }
}
