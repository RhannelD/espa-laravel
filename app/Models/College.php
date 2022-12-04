<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class College extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'college',
        'abbreviation',
    ];

    protected $attributes = [
        'college' => '',
        'abbreviation' => '',
    ];

    // protected $casts = [
    //     'date_at'  => 'date:Y-m-d',
    // ];

    # attributes -------------------------------------------------------



    # relationships ----------------------------------------------------

    public function programs()
    {
        return $this->hasMany(Program::class, 'college_id', 'id');
    }

    # scopes -----------------------------------------------------------

    public function scopeSearch($query, $search)
    {
        $query->where(function($query) use ($search) {
            $query->where('college', 'like', "%{$search}%")
            ->orWhere('abbreviation', 'like', "%{$search}%");
        });
    }

    # custom functions --------------------------------------------------


}
