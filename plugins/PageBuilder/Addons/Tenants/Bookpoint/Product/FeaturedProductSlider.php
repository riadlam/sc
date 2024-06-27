<?php

namespace Plugins\PageBuilder\Addons\Tenants\Bookpoint\Product;

use App\Helpers\LanguageHelper;
use App\Helpers\SanitizeInput;
use Modules\Blog\Entities\BlogCategory;
use Modules\DigitalProduct\Entities\DigitalProduct;
use Modules\Product\Entities\Product;
use Plugins\PageBuilder\Fields\NiceSelect;
use Plugins\PageBuilder\Fields\Number;
use Plugins\PageBuilder\Fields\Select;
use Plugins\PageBuilder\Fields\Text;
use Plugins\PageBuilder\PageBuilderBase;
use Symfony\Component\Console\Input\Input;

class FeaturedProductSlider extends PageBuilderBase
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

        $products = DigitalProduct::where(['status_id' => 1])
            ->where('promotional_date', '>', now())
            ->where('promotional_price', '!=', null)
            ->get()->mapWithKeys(function ($item){
            return [$item->id => $item->name];
        })->toArray();

        $output .= NiceSelect::get([
            'multiple' => true,
            'name' => 'products',
            'label' => __('Select Products'),
            'options' => $products,
            'value' => $widget_saved_values['products'] ?? null,
            'info' => __('you can select your desired products or leave it empty')
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
        $title = SanitizeInput::esc_html($this->setting_item('title') ?? __('Featured Products'));
        $products_id = $this->setting_item('products');
        $item_show = SanitizeInput::esc_html($this->setting_item('item_show') ?? '');
        $padding_top = SanitizeInput::esc_html($this->setting_item('padding_top'));
        $padding_bottom = SanitizeInput::esc_html($this->setting_item('padding_bottom'));

        $products = DigitalProduct::where('status_id', 1);

        if (!empty($products_id))
        {
            $products->whereIn('id', $products_id);
        } else {
            $products->where('promotional_date', '>', now())->where('promotional_price', '!=', null);
        }

        if(!empty($item_show)){
            $products->take($item_show);
        }else{
            $products->take(4);
        }

        $products = $products->get();

        $data = [
            'title' => $title,
            'padding_top'=> $padding_top,
            'padding_bottom'=> $padding_bottom,
            'products'=> $products
        ];

        return self::renderView('tenant.bookpoint.product.featured_product_slider',$data);
    }

    public function addon_title()
    {
        return __('Theme Bookpoint: Featured Product Slider (Digital Product)');
    }
}
