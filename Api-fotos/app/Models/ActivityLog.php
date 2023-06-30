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
    protected $attributes = [
        'causer_id' => 0, // Valor predeterminado cuando no hay usuario autenticado
    ];

    public function causer()
    {
        return $this->belongsTo(User::class, 'causer_id');
    }
}
