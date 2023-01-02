<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    const SEARCHFILTERS = [
        'sr_code',
        'firstname',
        'lastname',
        'email',
    ];

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
        return $this->hasRole('Super Admin');
    }

    public function getIsStudentAttribute()
    {
        return !is_null($this->sr_code);
    }

    # relationships ----------------------------------------------------

    public function student()
    {
        return $this->hasOne(Student::class, 'user_id', 'id');
    }

    public function curriculum()
    {
        return $this->hasOneThrough(Curriculum::class, Student::class, 'user_id', 'id', 'id', 'curriculum_id');
    }

    public function grades()
    {
        return $this->hasMany(Grade::class, 'user_id', 'id');
    }

    # scopes -----------------------------------------------------------

    public function scopeSearch($query, $search, $filter = self::SEARCHFILTERS)
    {
        $query->where(function ($query) use ($search, $filter) {
            $query_flname = count(array_intersect(['firstname', 'lastname'], $filter)) == 2;
            $filter = $query_flname ? array_diff($filter, ['firstname', 'lastname']) : $filter;
            $query->when($query_flname, function ($query) use ($search, $filter) {
                $query->where(\DB::raw('CONCAT(firstname, " ", lastname)'), 'like', "%{$search}%");
            });

            foreach ($filter as $key => $filter_item) {
                if (is_array($filter_item)) {
                    $query->orWhereHas($key, function ($query) use ($search, $filter_item) {
                        $query->search($search, $filter_item);
                    });
                } else {
                    $query->orWhere($filter_item, 'like', "%{$search}%");
                }
            }
        });
    }

    public function scopeIsOfficer($query)
    {
        $query->whereNull('sr_code');
    }

    public function scopeIsStudent($query)
    {
        $query->whereNotNull('sr_code');
    }

    # custom functions --------------------------------------------------

}
