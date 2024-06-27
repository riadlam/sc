<?php

namespace Plugins\PageBuilder\Addons\Tenants\Medicom\Product;

use App\Helpers\LanguageHelper;
use App\Helpers\SanitizeInput;
use Modules\Attributes\Entities\Category;
use Modules\Campaign\Entities\Campaign;
use Modules\Product\Entities\ProductCategory;
use Plugins\PageBuilder\Fields\Image;
use Plugins\PageBuilder\Fields\NiceSelect;
use Plugins\PageBuilder\Fields\Number;
use Plugins\PageBuilder\Fields\Select;
use Plugins\PageBuilder\Fields\Switcher;
use Plugins\PageBuilder\Fields\Text;
use Plugins\PageBuilder\Fields\Textarea;
use Plugins\PageBuilder\PageBuilderBase;
use function __;

class CategoriesSlider extends PageBuilderBase
{

    public function preview_image()
    {
        return 'Tenant/common/hardwork-area.png';
    }

    public function admin_render()
    {
        $output = $this->admin_form_before();
        $output .= $this->admin_form_start();
        $output .= $this->default_fields();

        $widget_saved_values = $this->get_settings();

        $output .= Text::get([
            'name' => 'section_title',
            'label' => __('Section Title'),
            'value' => $widget_saved_values['section_title'] ?? ''
        ]);

        $campaigns = Category::where('status_id', '1')->pluck('name', 'id')->toArray();
        $output .= NiceSelect::get([
            'multiple' => true,
            'name' => 'categories',
            'label' => __('Select Categories'),
            'options' => $campaigns,
            'value' => $widget_saved_values['categories'] ?? '',
        ]);

        $output .= Switcher::get([
            'name' => 'product_count',
            'label' => __('Show Product Count'),
            'value' => $widget_saved_values['product_count'] ?? false,
            'info' => 'Enable this if you want to show product count under the category'
        ]);

        $output .= Number::get([
            'name' => 'category_limit',
            'label' => __('Category Limit'),
            'value' => $widget_saved_values['category_limit'] ?? ''
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
        $section_title = SanitizeInput::esc_html($this->setting_item('section_title'));
        $product_count = $this->setting_item('product_count');
        $categories = $this->setting_item('categories') ?? '';
        $category_limit = $this->setting_item('category_limit') ?? '';

        $categories_info = Category::query();
        if (!empty($product_count))
        {
            $categories_info = $categories_info->withCount('product');
        }

        if (!empty($categories))
        {
            $categories_info = $categories_info->whereIn('id', $categories);
        }

        $categories_info = $categories_info->limit($category_limit ?? 8)->get();

        $padding_top = SanitizeInput::esc_html($this->setting_item('padding_top'));
        $padding_bottom = SanitizeInput::esc_html($this->setting_item('padding_bottom'));

        $data = [
            'section_title'=> $section_title,
            'categories_info'=> $categories_info,
            'product_count'=> $product_count,
            'padding_top'=> $padding_top,
            'padding_bottom'=> $padding_bottom,
        ];

        return self::renderView('tenant.medicom.product.categories-slider',$data);

    }

    public function enable(): bool
    {
        return (bool) !is_null(tenant());
    }

    public function addon_title()
    {
        return __('Theme Medicom: Categories Slider');
    }
}
