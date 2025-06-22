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

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($question) {
            $question->assessments()->each(function ($assessment) {
                $assessment->uploads()->delete();
                $assessment->delete();
            });

            if ($question->question_upload_id) {
                $question->questionUpload()->delete();
            }
            if ($question->answer_upload_id) {
                $question->answerUpload()->delete();
            }
        });
    }

    public function questionUpload()
    {
        return $this->belongsTo(Upload::class, 'question_upload_id');
    }

    public function answerUpload()
    {
        return $this->belongsTo(Upload::class, 'answer_upload_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function assessments()
    {
        return $this->hasMany(Assessment::class);
    }
}
