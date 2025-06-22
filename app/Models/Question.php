<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasUuids, HasFactory;
    protected $fillable = [
        'user_id',
        'question_text',
        'question_upload_id',
        'answer_upload_id',
        'max_total',
        'difficulty',
        'course_code',
        'session',
        'semester',
        'level',
    ];

    public function uploads()
    {
        return $this->belongsTo(Upload::class, 'question_upload_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function answerUpload()
    {
        return $this->belongsTo(Upload::class, 'answer_upload_id');
    }
}
