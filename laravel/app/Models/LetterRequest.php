<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\UploadedLetter;
use Carbon\Carbon;

class LetterRequest extends Model
{
    use HasFactory;

    protected $primaryKey = 'request_id';

    protected $fillable = [
        'request_by',
        'validated_by',
        'letter_number',
        'reason',
        'category',
        'status',
        'letter_date'
    ];

    protected $dates = ['letter_date'];

    /**
     * Get the user who requested this letter
     */
    public function requestedBy()
    {
        return $this->belongsTo(User::class, 'request_by', 'user_id')->withTrashed();
    }

    /**
     * Get the uploaded letter associated with the request
     */
    public function uploadedLetter()
    {
        return $this->hasOne(UploadedLetter::class, 'request_id', 'request_id');
    }

    /**
     * Get the user who validated this request
     */
    public function validator()
    {
        return $this->belongsTo(User::class, 'validated_by', 'user_id')->withTrashed();
    }

    /**
     * Get formatted category name
     */
    public function getFormattedCategoryAttribute()
    {
        return str_replace('_', ' ', $this->category);
    }

    /**
     * Get the formatted date
     */
    public function getFormattedDateAttribute()
    {
        return Carbon::parse($this->letter_date)->translatedFormat('j F Y');
    }
}
