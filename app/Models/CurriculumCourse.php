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
        'requisite_standing',
    ];

    protected $attributes = [
        'year' => 1,
        'semester' => 1,
        'requisite_standing' => '',
    ];

    // protected $casts = [
    //     'date_at'  => 'date:Y-m-d',
    // ];
    
    protected $cloneable_relations = [
        'curriculum_course_prerequisites'
    ];

    # attributes -------------------------------------------------------

    public function getYearStringAttribute()
    {
        return $this->getYearString($this->year);
    }

    public function getSemesterStringAttribute()
    {
        return $this->getSemesterString($this->semester);
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

    public function corequisite_curriculum_courses()
    {
        return $this->belongsToMany(CurriculumCourse::class, 'curriculum_course_prerequisites', 'prerequisite_cc_id', 'corequisite_cc_id');
    }

    public function prerequisite_curriculum_courses()
    {
        return $this->belongsToMany(CurriculumCourse::class, 'curriculum_course_prerequisites', 'corequisite_cc_id', 'prerequisite_cc_id');
    }

    public function curriculum_course_corequisites()
    {
        return $this->hasMany(CurriculumCoursePrerequisite::class, 'prerequisite_cc_id', 'id');
    }

    public function curriculum_course_prerequisites()
    {
        return $this->hasMany(CurriculumCoursePrerequisite::class, 'corequisite_cc_id', 'id');
    }

    # scopes -----------------------------------------------------------

    # custom functions --------------------------------------------------

    public static function getYearString($year)
    {
        $number_string_ordinals = self::NUMBERTOSTRINGORDINALS;
        return "{$number_string_ordinals[$year]} Year";
    }

    public static function getSemesterString($semester)
    {
        $number_string_ordinals = self::NUMBERTOSTRINGORDINALS;
        return $semester == 3 ? 'Summer' : "{$number_string_ordinals[$semester]} Semester";
    }
}
