<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Helpers\ImageUploaderTrait;

class File extends Model
{
    use HasFactory, ImageUploaderTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public $fillable = [
        'fileable_id',
        'fileable_type',
        'file'
    ];

    /**
     * Get all of the owning fileable models.
    */
    public function fileable()
    {
        return $this->morphTo();
    }

    /**
     * Mutator to upload image/images.
    */
    public function setFileAttribute($file)
    {
        if ($file)
        {
            if(is_array($file))
            {
                foreach( $file as $f )
                {
                    $fileName = $this->createFileName($f);

                    $this->originalImage($f, $fileName);

                    $this->thumbImage($f, $fileName);

                    $this->attributes['file'] = $fileName;
                }
            }
            else{
                $fileName = $this->createFileName($file);

                $this->originalImage($file, $fileName);

                $this->thumbImage($file, $fileName);

                $this->attributes['file'] = $fileName;
            }
        }
    }
}
