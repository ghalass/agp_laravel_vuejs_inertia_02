<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Engin extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'parc_id',
        'site_id',
    ];

    public function parc(): BelongsTo
    {
        return $this->belongsTo(Parc::class)->with('typeparc');
    }

    public function site(): BelongsTo
    {
        return $this->belongsTo(Site::class);
    }
}