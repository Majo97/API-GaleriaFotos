<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CollectionImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'image_id',
        'type_id',
        'collection_id',
    ];

    public function image()
    {
        return $this->belongsTo(Image::class);
    }

    public function type()
    {
        return $this->belongsTo(Type::class);
    }

    public function collection()
    {
        return $this->belongsTo(Collection::class);
    }
}
