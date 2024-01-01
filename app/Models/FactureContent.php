<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FactureContent extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function facture(): BelongsTo
    {
        return $this->belongsTo(Facture::class);
    }
}
