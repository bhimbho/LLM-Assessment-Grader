<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Question;
class Upload extends Model
{
    use HasUuids, HasFactory;
    protected $fillable = ['url'];

    public function question()
    {
        return $this->hasMany(Question::class);
    }
}
