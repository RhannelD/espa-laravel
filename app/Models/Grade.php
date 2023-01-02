<?php

namespace App\Models;

use App\Casts\Grade as GradeCast;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'course_id',
        'grade',
    ];

    protected $attributes = [
        'grade' => 5,
    ];

    protected $casts = [
        'grade'  => GradeCast::class,
    ];

    # attributes -------------------------------------------------------

    # relationships ----------------------------------------------------

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id', 'id');
    }

    # scopes -----------------------------------------------------------

    # custom functions --------------------------------------------------

}
