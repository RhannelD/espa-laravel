<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class College extends Model
{
    use HasFactory;

    const SEARCHFILTERS = [
        'college', 
        'abbreviation',
    ];

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
