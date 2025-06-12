<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Assessment extends Model
{
    protected $fillable = [
        'assignment_id',
        'answer_upload_id',
        'score',
        'percentage',
        'status',
    ];

    public function assignment()
    {
        return $this->belongsTo(Assignment::class);
    }
}
