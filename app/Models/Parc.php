<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Parc extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'typeparc_id',
    ];

    public function typeparc(): BelongsTo
    {
        return $this->belongsTo(Typeparc::class);
    }

    public function engins(): HasMany
    {
        return $this->hasMany(Engin::class);
    }
}