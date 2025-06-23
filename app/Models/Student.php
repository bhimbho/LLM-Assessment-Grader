<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory, HasUuids;
    
    protected $fillable = [
        'firstname',
        'lastname',
        'othername',
        'student_id',
        'email',
    ];

    public function assessments()
    {
        return $this->hasMany(Assessment::class, 'student_id', 'student_id');
    }

    public function getFullNameAttribute()
    {
        $name = $this->firstname . ' ' . $this->lastname;
        if ($this->othername) {
            $name .= ' ' . $this->othername;
        }
        return $name;
    }
}
