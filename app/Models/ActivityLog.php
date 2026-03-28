<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ActivityLog extends Model
{
    protected $fillable = [
        'accion',
        'modelo',
        'modelo_id',
        'descripcion',
        'user_id'
    ];

    
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}