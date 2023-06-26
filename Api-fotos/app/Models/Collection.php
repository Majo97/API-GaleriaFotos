<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Collection extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'timestamp'
    ];

    public function images()
    {
        return $this->belongsToMany(Image::class, 'collection_images', 'collection_id', 'image_id')->withPivot('type_id');
    }
}
