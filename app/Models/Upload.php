<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use App\Models\Question;
use App\Models\User;

class Upload extends Model
{
    use HasUuids, HasFactory;
    
    protected $fillable = ['url'];

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($upload) {
            if ($upload->url && Storage::disk('public')->exists($upload->url)) {
                Storage::disk('public')->delete($upload->url);
            }
        });
    }

    public function question()
    {
        return $this->hasMany(Question::class);
    }

    public function user()
    {
        return $this->hasOne(User::class);
    }
}
