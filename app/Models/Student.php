<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'curriculum_id',
    ];

    // protected $attributes = [
    //     '' => '',
    // ];

    // protected $casts = [
    //     'date_at'  => 'date:Y-m-d',
    // ];

    # attributes -------------------------------------------------------

    # relationships ----------------------------------------------------

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function curriculum()
    {
        return $this->belongsTo(Curriculum::class, 'curriculum_id', 'id');
    }

    # scopes -----------------------------------------------------------

    # custom functions --------------------------------------------------

}
