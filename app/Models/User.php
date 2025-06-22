<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasUuids;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'staff_id',
        'firstname',
        'lastname',
        'othername',
        'email',
        'role',
        'password',
        'is_banned',
        'upload_id',
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
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_banned' => 'boolean',
        ];
    }

    public function getFullNameAttribute()
    {
        $name = $this->firstname . ' ' . $this->lastname;
        if ($this->othername) {
            $name .= ' ' . $this->othername;
        }
        return $name;
    }

    public function isBanned()
    {
        return $this->is_banned;
    }

    public function ban()
    {
        $this->update(['is_banned' => true]);
    }

    public function unban()
    {
        $this->update(['is_banned' => false]);
    }

    public function upload()
    {
        return $this->belongsTo(Upload::class);
    }

    public function getProfileImageUrlAttribute()
    {
        if ($this->upload_id && $this->upload) {
            return asset('storage/' . $this->upload->url);
        }
        return asset('demo/users/use.jpg'); // Default profile image
    }
}
