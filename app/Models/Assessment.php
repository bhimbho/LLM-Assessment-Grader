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
        'score',
        'difficulty',
        'percentage',
        'status',
    ];

    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    public function uploads()
    {
        return $this->belongsToMany(Upload::class);
    }
}
