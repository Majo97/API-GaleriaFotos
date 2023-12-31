<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;



class CollectionImage extends Model
{
    use HasFactory;
    protected $primaryKey = 'id';
    public $incrementing = true;
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
