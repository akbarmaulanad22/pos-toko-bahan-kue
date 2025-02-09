<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $with = ['sizes', 'category'];

    /**
     * Scope a query to search products.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeSearch($query)
    {
        return $query->when(request()->query('search'), fn() => $query->where('name', 'like', '%' . request()->query('search') . '%'));
    }

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'sku';
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function sizes()
    {
        return $this->hasMany(ProductSize::class);
    }

    public function orders() {
        return $this->belongsToMany(Order::class)->withPivot(['size', 'price', 'quantity']);
    }

    public function stockflows()
    {
        return $this->hasMany(StockFlow::class);
    }
}
