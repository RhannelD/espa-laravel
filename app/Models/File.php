<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    use HasFactory;

    protected $fillable = [
        'origname',
        'filename',
        'fileable_id',
        'fileable_type',
    ];

    // protected $attributes = [
    //     '' => '',
    // ];

    // protected $casts = [
    //     'date_at'  => 'date:Y-m-d',
    // ];

    # attributes -------------------------------------------------------

    # relationships ----------------------------------------------------

    public function fileable()
    {
        return $this->morphTo();
    }

    # scopes -----------------------------------------------------------

    # custom functions --------------------------------------------------

}
