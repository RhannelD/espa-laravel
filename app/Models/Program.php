<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    use HasFactory;

    const SEARCHFILTERS = [
        'program', 
        'abbreviation', 
    ];

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

    public function curricula()
    {
        return $this->hasMany(Curriculum::class, 'program_id', 'id');
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
