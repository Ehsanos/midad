<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Product extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;

    protected $guarded = [];
    // protected $with = ['category_name'];
//    protected $appends = ['categoryname'];
//    protected $hidden = ['category_object'];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category', 'id');
    }

//    public function getCategorynameAttribute()
//    {
//        return $this->categoryObject->name;
//    }


    // admin dashboard - each product - how much order was created for
    // /**
    //  * Get all of the orders that are assigned this product.
    //  */
    // public function posts(): MorphToMany
    // {
    //     return $this->morphedByMany(Order::class, 'orders');
    // }
}
