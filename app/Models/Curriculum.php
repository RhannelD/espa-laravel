<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Curriculum extends Model
{
    use HasFactory;

    const SEARCHFILTERS = [
        'track', 
        'academic_year', 
    ];

    protected $fillable = [
        'program_id',
        'track',
        'academic_year',
    ];

    protected $attributes = [
        'track' => '',
    ];

    // protected $casts = [
    //     'academic_year' => 'date:Y',
    // ];

    # attributes -------------------------------------------------------

    # relationships ----------------------------------------------------

    public function program()
    {
        return $this->belongsTo(Program::class, 'program_id', 'id');
    }

    # scopes -----------------------------------------------------------

    public function scopeSearch($query, $search, $filter = self::SEARCHFILTERS)
    {
        $query->where(function ($query) use ($search, $filter) {
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

    # custom functions --------------------------------------------------

}
