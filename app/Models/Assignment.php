<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Assignment extends Model
{
    use HasUuids, HasFactory;
    protected $fillable = [
        'user_id',
        'questions',
        'question_upload_id',
        'max_total',
    ];
}
