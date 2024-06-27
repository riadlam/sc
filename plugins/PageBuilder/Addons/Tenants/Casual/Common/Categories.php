<?php

namespace Plugins\PageBuilder\Addons\Tenants\Casual\Common;

use App\Helpers\SanitizeInput;
use Modules\Attributes\Entities\Category;
use Plugins\PageBuilder\Fields\Image;
use Plugins\PageBuilder\Fields\NiceSelect;
use Plugins\PageBuilder\Fields\Switcher;
use Plugins\PageBuilder\Fields\Text;
use Plugins\PageBuilder\PageBuilderBase;
use function __;

class Categories extends PageBuilderBase
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

        $categories = Category::published()->withCount('product')->pluck('name', 'id')->toArray();

        $output .= NiceSelect::get([
            'multiple' => true,
            'name' => 'categories',
            'label' => __('Select Categories'),
            'options' => $categories,
            'value' => $widget_saved_values['categories'] ?? '',
        ]);

        $output .= Switcher::get([
            'name' => 'product_count',
            'label' => __('Show Product Count'),
            'value' => $widget_saved_values['product_count'] ?? true,
            'info' => __('Enable this if you want to show product count under the category')
        ]);

        $output .= Text::get([
            'name' => 'read_more_button_text',
            'label' => __('Product Read More Button Text'),
            'value' => $widget_saved_values['read_more_button_text'] ?? ''
        ]);

        $output .= Image::get([
            'name' => 'product_background_image',
            'label' => __('Product Background Image'),
            'value' => $widget_saved_values['product_background_image'] ?? ''
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
        $product_count = $this->setting_item('product_count');
        $categories = $this->setting_item('categories') ?? '';

        $title = esc_html($this->setting_item('section_title'));
        $button_text = esc_html($this->setting_item('see_all_text'));
        $button_url = esc_url($this->setting_item('see_all_url'));

        $categories_info = Category::whereIn('id', !empty($categories) ? $categories : [])->select('id', 'name', 'slug', 'image_id')->get();

        $read_more_button_text = esc_html($this->setting_item('read_more_button_text'));
        $product_background_image = esc_html($this->setting_item('product_background_image'));

        $padding_top = SanitizeInput::esc_html($this->setting_item('padding_top'));
        $padding_bottom = SanitizeInput::esc_html($this->setting_item('padding_bottom'));

        $data = [
            'categories_info'=> $categories_info,
            'product_count'=> $product_count,
            'title' => $title,
            'button_text' => $button_text,
            'button_url' => $button_url,
            'read_more_button_text' => $read_more_button_text,
            'product_background_image' => $product_background_image,
            'padding_top'=> $padding_top,
            'padding_bottom'=> $padding_bottom,
        ];

        return self::renderView('tenant.casual.common.categories',$data);

    }

    public function enable(): bool
    {
        return (bool) !is_null(tenant());
    }

    public function addon_title()
    {
        return __('Casual: Product Categories');
    }
}
