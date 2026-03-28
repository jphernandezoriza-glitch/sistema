<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Producto extends Model
{
    use HasFactory;

protected $fillable = ['nombre', 'descripcion', 'precio', 'stock', 'categoria_id', 'imagen'];

    public function scopeSearch($query, $term)
    {
        return $query->where('nombre', 'LIKE', "%$term%")
                     ->orWhere('descripcion', 'LIKE', "%$term%");
    }

    public function categoria(): BelongsTo
    {
        return $this->belongsTo(Categoria::class);
    }
}