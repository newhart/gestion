<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description' , 'category_id'];

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    public function childrenCategories(): BelongsTo
    {
        return $this->belongsTo(Category::class , 'category_id')->with('categories');
    }

    public function categories(): HasMany
    {
        return $this->hasMany(Category::class , 'category_id')->whereNull('category_id');
    }

    public function sorties(): HasMany
    {
        return $this->hasMany(Sorty::class);
    }
}
