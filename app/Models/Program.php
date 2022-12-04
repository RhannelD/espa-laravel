<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'college_id',
        'program',
        'abbreviation',
    ];

    protected $attributes = [
        'program' => '',
        'abbreviation' => '',
    ];

    // protected $casts = [
    //     'date_at'  => 'date:Y-m-d',
    // ];

    # attributes -------------------------------------------------------



    # relationships ----------------------------------------------------

    public function college()
    {
        return $this->belongsTo(College::class, 'college_id', 'id');
    }

    # scopes -----------------------------------------------------------

    public function scopeSearch($query, $search)
    {
        $query->where(function($query) use ($search) {
            $query->where('program', 'like', "%{$search}%")
            ->orWhere('abbreviation', 'like', "%{$search}%");
        });
    }

    # custom functions --------------------------------------------------


}
