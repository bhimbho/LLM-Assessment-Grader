<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Assessment extends Model
{
    use HasFactory, HasUuids;
    protected $fillable = [
        'question_id',
        'student_id',
        'score',
        'difficulty',
        'percentage',
        'status',
    ];

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($assessment) {
            $assessment->uploads()->delete();
        });
    }

    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id', 'student_id');
    }

    public function uploads()
    {
        return $this->belongsToMany(Upload::class);
    }
}
