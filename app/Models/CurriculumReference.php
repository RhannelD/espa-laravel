<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CurriculumReference extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'curriculum_id',
        'reference',
    ];

    protected $attributes = [
        'reference' => '',
    ];

    // protected $casts = [
    //     'date_at'  => 'date:Y-m-d',
    // ];

    # attributes -------------------------------------------------------



    # relationships ----------------------------------------------------

    public function curriculum()
    {
        return $this->belongsTo(Curriculum::class, 'curriculum_id', 'id');
    }

    # scopes -----------------------------------------------------------



    # custom functions --------------------------------------------------


}
