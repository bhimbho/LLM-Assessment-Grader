<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Student extends Authenticatable
{
    use HasFactory, HasUuids, Notifiable;
    
    protected $fillable = [
        'firstname',
        'lastname',
        'othername',
        'student_id',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }

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
