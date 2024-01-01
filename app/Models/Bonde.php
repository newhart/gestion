<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Bonde extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected  $fillable = ['num' , 'status' , 'created_at' , 'type'];

    public function entries() : HasMany
    {
        return $this->hasMany(Entry::class) ;
    }

    public function sorties() : HasMany
    {
        return $this->hasMany(Sorty::class);
    }
}
