<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    protected $fillable = [
        'description',
        'causer_id',
        'object_id',
        'object_type',
        'previous_data',
    ];

    protected $casts = [
        'previous_data' => 'json',
    ];

    public function causer()
    {
        return $this->belongsTo(User::class, 'causer_id');
    }
}
