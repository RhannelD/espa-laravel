<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Request extends Model
{
    use HasFactory;

    const SEARCHFILTERS = [
        'message',
    ];

    protected $fillable = [
        'user_id',
        'program_id',
        'message',
    ];

    protected $attributes = [
        'message' => '',
    ];

    // protected $casts = [
    //     'date_at'  => 'date:Y-m-d',
    // ];

    # attributes -------------------------------------------------------

    # relationships ----------------------------------------------------

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function program()
    {
        return $this->belongsTo(Program::class, 'program_id', 'id');
    }

    public function files()
    {
        return $this->morphMany(File::class, 'fileable');
    }

    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
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
