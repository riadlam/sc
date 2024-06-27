<?php

namespace Modules\Product\Services\Web;

use Modules\Attributes\Entities\Brand;
use Modules\Attributes\Entities\Category;
use Modules\Attributes\Entities\Color;
use Modules\Attributes\Entities\Size;
use Modules\Attributes\Entities\Unit;
use Modules\MobileApp\Http\Resources\Api\CategoryResource;
use Modules\MobileApp\Http\Resources\BrandResource;
use Modules\Product\Entities\Product;
use Modules\Product\Http\Traits\ProductGlobalTrait;

class FrontendProductServices
{
    use ProductGlobalTrait;

    public static function shopPageSearchContent(): array
    {
        return [
            "all_category" => CategoryResource::collection(Category::with("image","subcategory","subcategory.image","subcategory.childcategory","subcategory.childcategory.image")->get()),
            "all_units" => Unit::all(),
            "all_colors" => Color::whereHas("product_colors")->get(),
            "all_sizes" => Size::whereHas("product_sizes")->get(),
            "max_price" => Product::query()->max('price'),
            "min_price" => Product::query()->min('sale_price'),
            "item_style" =>['grid','list'],
        ];
    }
}
