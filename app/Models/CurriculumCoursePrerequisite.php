<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CurriculumCoursePrerequisite extends Model
{
    use HasFactory;

    protected $fillable = [
        'prerequisite_cc_id',
        'corequisite_cc_id',
    ];

    // protected $attributes = [
    //     '' => '',
    // ];

    // protected $casts = [
    //     'date_at'  => 'date:Y-m-d',
    // ];

    # attributes -------------------------------------------------------

    # relationships ----------------------------------------------------

    public function prerequisite_curriculum_course()
    {
        return $this->belongsTo(CurriculumCourse::class, 'prerequisite_cc_id', 'id');
    }

    public function corequisite_curriculum_course()
    {
        return $this->belongsTo(CurriculumCourse::class, 'corequisite_cc_id', 'id');
    }

    # scopes -----------------------------------------------------------

    # custom functions -------------------------------------------------

}
