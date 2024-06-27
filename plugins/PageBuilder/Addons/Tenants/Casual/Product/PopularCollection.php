<?php

namespace Plugins\PageBuilder\Addons\Tenants\Casual\Product;

use App\Helpers\LanguageHelper;
use App\Helpers\SanitizeInput;
use App\Models\OrderProducts;
use Modules\Blog\Entities\BlogCategory;
use Modules\Product\Entities\Product;
use Plugins\PageBuilder\Fields\NiceSelect;
use Plugins\PageBuilder\Fields\Number;
use Plugins\PageBuilder\Fields\Text;
use Plugins\PageBuilder\PageBuilderBase;
use Symfony\Component\Console\Input\Input;

class PopularCollection extends PageBuilderBase
{
    public function preview_image()
    {
        return 'Tenant/common/brand-01.png';
    }

    public function admin_render()
    {
        $output = $this->admin_form_before();
        $output .= $this->admin_form_start();
        $output .= $this->default_fields();
        $widget_saved_values = $this->get_settings();

        $output .= Text::get([
            'name' => 'title',
            'label' => __('Section Title'),
            'value' => $widget_saved_values['title'] ?? null,
        ]);

        $output .= Text::get([
            'name' => 'see_all_text',
            'label' => __('See All Button Text'),
            'value' => $widget_saved_values['see_all_text'] ?? ''
        ]);

        $output .= Text::get([
            'name' => 'see_all_url',
            'label' => __('See All Button Link'),
            'value' => $widget_saved_values['see_all_url'] ?? ''
        ]);

        $products_id = OrderProducts::query()->distinct('product_id')->orderBy('product_id', 'desc')->pluck('product_id')->toArray();

        $products = [];
        if (!empty($products_id))
        {
            $products = Product::published()->whereIn('id', $products_id)->get()->mapWithKeys(function ($item){
                return [$item->id => $item->name];
            })->toArray();
        }


        $output .= NiceSelect::get([
            'multiple' => true,
            'name' => 'products',
            'label' => __('Select Products'),
            'options' => $products,
            'value' => $widget_saved_values['products'] ?? null,
            'info' => __('You can select your desired popular products based on sale or leave it empty to randomize')
        ]);

        $output .= Number::get([
            'name' => 'item_show',
            'label' => __('Item Show'),
            'value' => $widget_saved_values['item_show'] ?? null,
        ]);

        // add padding option
        $output .= $this->padding_fields($widget_saved_values);
        $output .= $this->admin_form_submit_button();
        $output .= $this->admin_form_end();
        $output .= $this->admin_form_after();

        return $output;
    }

    public function frontend_render()
    {
        $title = esc_html($this->setting_item('title') ?? __('POPULAR COLLECTION'));
        $products_id = $this->setting_item('products');
        $item_show = esc_html($this->setting_item('item_show') ?? '');
        $see_all_text = esc_html($this->setting_item('see_all_text') ?? '');
        $see_all_url = esc_html($this->setting_item('see_all_url') ?? '');

        $padding_top = esc_html($this->setting_item('padding_top'));
        $padding_bottom = esc_html($this->setting_item('padding_bottom'));

        $products = Product::where('status_id',1);

        if (!empty($products_id))
        {
            $products->whereIn('id', $products_id);
        }

        $products = $products->take($item_show ?? 4)->get();

        $data = [
            'title' => $title,
            'see_all_text' => $see_all_text,
            'see_all_url' => $see_all_url,
            'padding_top'=> $padding_top,
            'padding_bottom'=> $padding_bottom,
            'products'=> $products
        ];

        return self::renderView('tenant.casual.product.popular_collection',$data);
    }

    public function addon_title()
    {
        return __('Casual : Popular Collection');
    }
}
