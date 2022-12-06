<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CurriculumCourse extends Model
{
    use HasFactory;
    use \Bkwld\Cloner\Cloneable;

    const NUMBERTOSTRINGORDINALS = [
        1 => 'First',
        2 => 'Second',
        3 => 'Third',
        4 => 'Fourth',
        5 => 'Fifth',
        6 => 'Sixth',
        7 => 'seventh',
        8 => 'Eighth',
        9 => 'Ninth',
        10 => 'Tenth',
    ];
    
    protected $fillable = [
        'curriculum_id',
        'course_id',
        'year',
        'semester',
    ];

    protected $attributes = [
        'year' => 1,
        'semester' => 1,
    ];

    // protected $casts = [
    //     'date_at'  => 'date:Y-m-d',
    // ];

    # attributes -------------------------------------------------------

    public function getYearStringAttribute()
    {
        $number_string_ordinals = self::NUMBERTOSTRINGORDINALS;
        return "{$number_string_ordinals[$this->year]} Year";
    }

    public function getSemesterStringAttribute()
    {
        $number_string_ordinals = self::NUMBERTOSTRINGORDINALS;
        return $this->semester==3? 'Summer': "{$number_string_ordinals[$this->semester]} Semester";
    }

    # relationships ----------------------------------------------------

    public function curriculum()
    {
        return $this->belongsTo(Curriculum::class, 'curriculum_id', 'id');
    }

    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id', 'id');
    }

    # scopes -----------------------------------------------------------



    # custom functions --------------------------------------------------


}