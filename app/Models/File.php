<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File as FileFacade;
use Illuminate\Support\Facades\Storage;

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

    public function getIfExistsAttribute()
    {
        return Storage::disk('files')->exists($this->filename);
    }

    public function getFileAttribute()
    {
        return $this->getIfExistsAttribute() ? Storage::disk('files')->get($this->filename) : null;
    }

    public function getFilepathAttribute()
    {
        return Storage::disk('files')->path($this->filename);
    }

    public function getDownloadAttribute()
    {
        return $this->getIfExistsAttribute() ? Storage::disk('files')->download($this->filename, $this->origname) : null;
    }

    public function getExtensionAttribute()
    {
        return FileFacade::extension($this->filename);
    }

    public function getFileUrlAttribute()
    {
        return route('file', ['file' => $this->id]);
    }

    # relationships ----------------------------------------------------

    public function fileable()
    {
        return $this->morphTo();
    }

    # scopes -----------------------------------------------------------

    # custom functions --------------------------------------------------

}
