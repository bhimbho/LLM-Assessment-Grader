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
        'max_total',
    ];

    public function uploads()
    {
        return $this->belongsTo(Upload::class, 'question_upload_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
