<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Curriculum extends Model
{
    use HasFactory;
    use \Bkwld\Cloner\Cloneable;

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

    protected $cloneable_relations = ['references', 'courses'];

    // protected $casts = [
    //     'academic_year' => 'date:Y',
    // ];

    # attributes -------------------------------------------------------

    public function getTitleAttribute()
    {
        return trim("{$this->program->program} {$this->track}");
    }

    public function getAcademicYearsAttribute()
    {
        return $this->academic_year . " - " . ($this->academic_year + 1);
    }

    # relationships ----------------------------------------------------

    public function program()
    {
        return $this->belongsTo(Program::class, 'program_id', 'id');
    }

    public function references()
    {
        return $this->hasMany(CurriculumReference::class, 'curriculum_id', 'id');
    }

    public function courses()
    {
        return $this->hasMany(CurriculumCourse::class, 'curriculum_id', 'id');
    }

    public function students()
    {
        return $this->hasMany(Student::class, 'curriculum_id', 'id');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'students', 'curriculum_id', 'user_id');
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
