<?php

namespace Modules\Attributes\Entities;

use App\Models\MediaUploader;
use App\Models\Status;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Product\Entities\Product;
use Modules\Product\Entities\ProductCategory;

class Category extends Model
{
    use HasFactory , SoftDeletes;

    protected $table = 'categories';
    protected $fillable = ["name","slug","description","image_id","status_id"];

    public function scopePublished()
    {
        return $this->where('status_id', 1);
    }

    public function image(): HasOne
    {
        return $this->hasOne(MediaUploader::class,"id","image_id");
    }

    public function subCategory(){
        return $this->hasMany(SubCategory::class, "category_id", "id");
    }

    public function status(): HasOne
    {
        return $this->hasOne(Status::class,"id","status_id");
    }

    public function product_categories(): HasMany
    {
        return $this->hasMany(ProductCategory::class);
    }

    public function product(): HasManyThrough
    {
        return $this->hasManyThrough(Product::class,ProductCategory::class,"category_id","id","id","product_id");
    }

    protected static function newFactory()
    {
        return \Modules\Attributes\Database\factories\CategoryFactory::new();
    }
}
