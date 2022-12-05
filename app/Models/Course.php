<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'code',
        'course',
        'unit',
        'lecture',
        'laboratory',
    ];

    protected $attributes = [
        'unit' => 1,
    ];

    // protected $casts = [
    //     'date_at'  => 'date:Y-m-d',
    // ];

    # attributes -------------------------------------------------------



    # relationships ----------------------------------------------------



    # scopes -----------------------------------------------------------

    public function scopeSearch($query, $search)
    {
        $query->where(function($query) use ($search) {
            $query->where('code', 'like', "%{$search}%")
            ->orWhere('course', 'like', "%{$search}%");
        });
    }

    # custom functions --------------------------------------------------


}
