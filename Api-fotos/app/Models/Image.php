<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\ActivityLog;

class Image extends Model
{
    use HasFactory, SoftDeletes;
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'title',
        'description',
        'type_id',
        'path',
        'disk',
    ];

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

    public function type()
    {
        return $this->belongsTo(Type::class);
    }

    public function collections()
    {
        return $this->belongsToMany(Collection::class, 'collection_images');
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
