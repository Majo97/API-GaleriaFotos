<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class CollectionImage extends Model
{
    use HasFactory;

  
    protected $fillable = [
        'image_id',
        'collection_id',
    ];

    public function image()
    {
        return $this->belongsTo(Image::class);
    }

    public function collection()
    {
        return $this->belongsTo(Collection::class);
    }
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->id = Str::uuid()->toString();
            $model->createActivityLog('created');
        });

        static::updating(function ($model) {
            $model->createActivityLog('updated');
        });

        static::deleting(function ($model) {
            $model->createActivityLog('deleted');
        });
    }

    
    public function createActivityLog($action)
    {
        $activityLog = new ActivityLog();
        $activityLog->description = "Image {$action}: {$this->title}";
        $activityLog->causer_id = auth()->id(); 
        $activityLog->object_id = $this->id;
        $activityLog->object_type = Image::class;
        $activityLog->previous_data = $this->getOriginal(); 
        $activityLog->save();
    }
}
