<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    const SEARCHFILTERS = [
        'code',
        'course',
    ];

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

    public function curriculum_courses()
    {
        return $this->hasMany(CurriculumCourse::class, 'course_id', 'id');
    }

    public function grades()
    {
        return $this->hasMany(Grade::class, 'course_id', 'id');
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
