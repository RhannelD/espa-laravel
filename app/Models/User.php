<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'sr_code',
        'firstname',
        'lastname',
        'sex',
        'email',
        'password',
    ];

    protected $attributes = [
        'sex' => 'male',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    # attributes -------------------------------------------------------

    public function getFlnameAttribute()
    {
        return "{$this->firstname} {$this->lastname}";
    }

    public function getIsSuperAdminAttribute()
    {
        return $user->hasRole('Super Admin');
    }

    public function getIsStudentAttribute()
    {
        return !is_null($user->sr_code);
    }

    # relationships ----------------------------------------------------

    public function student()
    {
        return $this->hasOne(Student::class, 'user_id', 'id');
    }

    # scopes -----------------------------------------------------------

    public function scopeSearch($query, $search)
    {
        $query->where(function ($query) use ($search){
            $query->where(\DB::raw('CONCAT(firstname, " ", lastname)'), 'like', "%{$search}%")
            ->orWhere('email', 'like', "%{$search}%")
            ->orWhereHas('student', function($query) use ($search) {
                $query->where('sr_code', 'like', "%{$search}%");
            });
        });
    }

    public function scopeIsAdmin($query)
    {
        $query->where('usertype', 'admin');
    }

    public function scopeIsStudent($query)
    {
        $query->whereNotNull('sr_code');
    }

    # custom functions --------------------------------------------------


}
