<?php

namespace App\Http\Controllers\Tenant\Frontend;

use App\Enums\ProductTypeEnum;
use App\Http\Controllers\Controller;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Modules\DigitalProduct\Entities\AdditionalField;
use Modules\DigitalProduct\Entities\DigitalAuthor;
use Modules\DigitalProduct\Entities\DigitalCategories;
use Modules\DigitalProduct\Entities\DigitalChildCategories;
use Modules\DigitalProduct\Entities\DigitalLanguage;
use Modules\DigitalProduct\Entities\DigitalProduct;
use Modules\DigitalProduct\Entities\DigitalProductCategories;
use Modules\DigitalProduct\Entities\DigitalProductChildCategories;
use Modules\DigitalProduct\Entities\DigitalProductReviews;
use Modules\DigitalProduct\Entities\DigitalProductSubCategories;
use Modules\DigitalProduct\Entities\DigitalProductTags;
use Modules\DigitalProduct\Entities\DigitalSubCategories;

class FrontendDigitalProductController extends Controller
{
    public function shop_page(Request $request)
    {
        $product_object = DigitalProduct::where('status_id', 1);

        if ($request->has('category')) {
            $category = $request->category;
            $product_object->whereHas('category', function ($query) use ($category) {
                return $query->where('slug', $category);
            });
        }

        if ($request->has('author')) {
            $author = $request->author;
            $product_object->whereHas('additionalFields.author', function ($query) use ($author) {
                return $query->where('slug', $author);
            });
        }

        if ($request->has('language')) {
            $language = $request->language;
            $product_object->whereHas('additionalFields.language', function ($query) use ($language) {
                return $query->where('slug', $language);
            });
        }

        if ($request->has('tag')) {
            $tag = $request->tag;
            $product_object->whereHas('tag', function ($query) use ($tag) {
                return $query->where('tag_name', 'LIKE', "%{$tag}%");
            });
        }

        if ($request->has('min_price') && $request->has('max_price')) {
            $min_price = $request->min_price;
            $max_price = $request->max_price;
            $product_object->whereBetween('regular_price', [$min_price, $max_price]);
        }

        if ($request->has('rating')) {
            $rating = $request->rating;

            $product_object->whereHas('reviews', function ($query) use ($rating) {
                $query->where('rating', $rating);
            });
        }

        if ($request->has('sort')) {

            $order = 'desc';
            switch ($request->sort) {
                case 1:
                    $order_by = 'name';
                    break;
                case 2:
                    $order_by = 'rating';
                    break;
                case 3:
                    $order_by = 'created_at';
                    break;
                case 4:
                    $order_by = 'sale_price';
                    $order = 'asc';
                    break;
                case 5:
                    $order_by = 'sale_price';
                    break;
                default:
                    $order_by = 'created_at';
            }

            $product_object->orderBy($order_by, $order);
        } else {
            $product_object->latest();
        }

        $product_object = $product_object->paginate(12)->withQueryString();

        $create_arr = $request->all();
        $create_url = http_build_query($create_arr);

        $product_object->url(route('tenant.digital.shop') . '?' . $create_url);

        $links = $product_object->getUrlRange(1, $product_object->lastPage());
        $current_page = $product_object->currentPage();

        $products = $product_object->items();

        $grid = themeView("digital-shop.partials.product-partials.grid-products", compact("products", "links", "current_page"))->render();

        return response()->json(["grid" => $grid, 'pagination' => $product_object]);
    }

    public function product_details($slug)
    {
        $product = DigitalProduct::with('category', 'tag', 'tax', 'additionalFields', 'additionalCustomFields', 'gallery_images', 'refund_policy', 'downloads')
            ->withCount('downloads')
            ->where('slug', $slug)
            ->where('status_id', 1)
            ->firstOrFail();

        // related products
        $product_category = $product?->category?->id;
        $product_id = $product->id;
        $related_products = DigitalProduct::where('status_id', 1)
            ->whereIn('id', function ($query) use ($product_id, $product_category) {
                $query->select('digital_product_categories.product_id')
                    ->from(with(new DigitalProductCategories())->getTable())
                    ->where('product_id', '!=', $product_id)
                    ->where('category_id', '=', $product_category)
                    ->get();
            })
            ->inRandomOrder()
            ->take(3)
            ->get();

        $reviews = DigitalProductReviews::where('product_id', $product->id)->orderBy('id', 'desc')->take(5)->get();

        return themeView('digital-shop.product_details.product-details', compact(
            'product',
            'related_products',
            'reviews'
        ));
    }

    public function product_review(Request $request)
    {
        $request->validate([
            'product_id' => 'required',
            'rating' => 'required',
            'review_text' => 'required|max:1000'
        ]);

        $user = \Auth::guard('web')->user();
        $existing_record = DigitalProductReviews::where(['user_id' => $user->id, 'product_id' => $request->product_id])->select('id')->first();

        if (!$existing_record) {
            $product_review = new DigitalProductReviews();
            $product_review->user_id = $user->id;
            $product_review->product_id = $request->product_id;
            $product_review->rating = $request->rating;
            $product_review->review_text = trim($request->review_text);
            $product_review->save();

            return response()->json(['type' => 'success', 'msg' => __('Your review is submitted')]);
        }

        return response()->json(['type' => 'danger', 'msg' => __('Your have already submitted review on this product')]);
    }

    public function render_reviews(Request $request)
    {
        $reviews = ProductReviews::with('user')->where('product_id', $request->product_id)->orderBy('created_at', 'desc')->take($request->items)->get();
        $review_markup = themeView('tenant.frontend.shop.product_details.markup_for_controller.product_reviews', compact('reviews'))->render();

        return response()->json([
            'type' => 'success',
            'markup' => $review_markup
        ]);
    }

    const QUANTITY = 1;

    public function add_to_cart(Request $request): JsonResponse
    {
        if (!auth('web')->user())
        {
            return response()->json([
                'type' => 'warning',
                'quantity_msg' => __('Please login first to cart a digital product')
            ]);
        }

        $request->validate([
            'product_id' => 'required'
        ]);
        $cart_data = $request->all();

        // check if the same product is added to cart before
        $oldCart = Cart::content('default')->where('options.type', ProductTypeEnum::DIGITAL)->where('id', $cart_data['product_id']);
        if (count($oldCart) > 0)
        {
            return response()->json([
                'type' => 'warning',
                'quantity_msg' => __('You have already added this product in the cart before!')
            ]);
        }

        $product = DigitalProduct::findOrFail($cart_data['product_id']);

        // check if the product has quantity attribute and quantity amount
        if (!is_null($product->quantity)) {
            $product_left = $product->quantity;
            if ($product_left <= 1) {
                return response()->json([
                    'type' => 'warning',
                    'quantity_msg' => __('Requested amount can not be cart. The product stock limit is over!')
                ]);
            }
        }

        try {
            $regular_price = $product->regular_price;
            $sale_price = $product->sale_price;

            if (!is_null($product->promotional_date) && !is_null($product->promotional_price)) {
                if ($product->promotional_date >= now()) {
                    $sale_price = $product->promotional_price;
                }
            }

            $price = $regular_price;
            if (!is_null($sale_price) && $sale_price > 0) {
                $price = $sale_price;
            }

            $final_price = $price;

            $category = $product?->category?->id;
            $subcategory = $product?->subCategory?->id ?? null;

            $options['used_categories'] = [
                'category' => $category,
                'subcategory' => $subcategory
            ];
            $options['type'] = ProductTypeEnum::DIGITAL;
            $options['image'] = $product->image_id;

            Cart::instance("default")->add(['id' => $cart_data['product_id'], 'name' => $product->name, 'qty' => self::QUANTITY, 'price' => $final_price, 'weight' => '0', 'options' => $options]);

            return response()->json([
                'type' => 'success',
                'msg' => __('Item added to cart')
            ]);
        } catch (\Exception $exception) {

            return response()->json([
                'type' => 'error',
                'error_msg' => __('Something went wrong!'),
            ]);
        }
    }

    public function category_products($slug, $category_type = null)
    {
        $type = ['author', 'language', 'category', 'subcategory', 'child-category', 'tag'];
        abort_if(!in_array($category_type, $type), 404);

        if ($category_type == 'author') {
            $category = DigitalAuthor::where('slug', $slug)->select('id', 'name')->firstOrFail();
            $products_id = AdditionalField::where('author_id', $category->id)->select('product_id')->pluck('product_id');
        } elseif ($category_type == 'language') {
            $category = DigitalLanguage::where('slug', $slug)->select('id', 'name')->firstOrFail();
            $products_id = AdditionalField::where('language', $category->id)->select('product_id')->pluck('product_id');
        } elseif ($category_type == 'category') {
            $category = DigitalCategories::where('slug', $slug)->select('id', 'name')->firstOrFail();
            $products_id = DigitalProductCategories::where('category_id', $category->id)->select('product_id')->pluck('product_id');
        } elseif ($category_type == 'subcategory') {
            $category = DigitalSubCategories::where('slug', $slug)->select('id', 'name')->firstOrFail();
            $products_id = DigitalProductSubCategories::where('sub_category_id', $category->id)->select('product_id')->pluck('product_id');
        } elseif($category_type == 'child-category') {
            $category = DigitalChildCategories::where('slug', $slug)->select('id', 'name')->firstOrFail();
            $products_id = DigitalProductChildCategories::where('child_category_id', $category->id)->select('product_id')->pluck('product_id');
        } else {
            $category = DigitalProductTags::where('tag_name', $slug)->select('id', 'tag_name as name')->firstOrFail();
            $products_id = DigitalProductTags::where('tag_name', $slug)->select('product_id')->pluck('product_id');
        }

        $products = DigitalProduct::whereIn('id', $products_id)->paginate(12);

        abort_if(empty($products), 403);

        return themeView('digital-shop.single_pages.category', ['category' => $category, 'products' => $products, 'type' => $category_type]);
    }
}
