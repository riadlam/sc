<?php

namespace Plugins\PageBuilder\Addons\Tenants\Aromatic\Product;

use App\Helpers\SanitizeInput;
use Modules\Attributes\Entities\Category;
use Modules\Product\Entities\Product;
use Modules\Product\Entities\ProductCategory;
use Plugins\PageBuilder\Fields\Image;
use Plugins\PageBuilder\Fields\NiceSelect;
use Plugins\PageBuilder\Fields\Number;
use Plugins\PageBuilder\Fields\Select;
use Plugins\PageBuilder\Fields\Switcher;
use Plugins\PageBuilder\Fields\Text;
use Plugins\PageBuilder\PageBuilderBase;

class BestProduct extends PageBuilderBase
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
            'name' => 'price',
            'label' => __('Price'),
            'value' => $widget_saved_values['price'] ?? null,
        ]);

        $output .= Text::get([
            'name' => 'button_text',
            'label' => __('Button Text'),
            'value' => $widget_saved_values['button_text'] ?? null,
        ]);

        $output .= Text::get([
            'name' => 'button_url',
            'label' => __('Button URL'),
            'value' => $widget_saved_values['button_url'] ?? null,
        ]);

        $output .= Image::get([
            'name' => 'image',
            'label' => __('Image'),
            'value' => $widget_saved_values['image'] ?? null,
        ]);

        $output .= Text::get([
            'name' => 'image_url',
            'label' => __('Image URL'),
            'value' => $widget_saved_values['image_url'] ?? null,
        ]);

        $output .= '<hr>';

        $output .= Image::get([
            'name' => 'particle_image_one',
            'label' => __('Particle Image One'),
            'value' => $widget_saved_values['particle_image_one'] ?? null,
        ]);

        $output .= Image::get([
            'name' => 'particle_image_two',
            'label' => __('Particle Image Two'),
            'value' => $widget_saved_values['particle_image_two'] ?? null,
        ]);

        $output .= Image::get([
            'name' => 'particle_image_three',
            'label' => __('Particle Image Three'),
            'value' => $widget_saved_values['particle_image_three'] ?? null,
        ]);

        $output .= Image::get([
            'name' => 'particle_image_four',
            'label' => __('Particle Image Four'),
            'value' => $widget_saved_values['particle_image_four'] ?? null,
        ]);

        $output .= Image::get([
            'name' => 'particle_image_five',
            'label' => __('Particle Image Five'),
            'value' => $widget_saved_values['particle_image_five'] ?? null,
        ]);

        $output .= Image::get([
            'name' => 'particle_image_six',
            'label' => __('Particle Image Six'),
            'value' => $widget_saved_values['particle_image_six'] ?? null,
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
        $title = SanitizeInput::esc_html($this->setting_item('title') ?? '');
        $price = SanitizeInput::esc_html($this->setting_item('price') ?? '');
        $button_text = SanitizeInput::esc_html($this->setting_item('button_text') ?? '');
        $button_url = SanitizeInput::esc_url($this->setting_item('button_url') ?? '');
        $image = $this->setting_item('image');
        $image_url = SanitizeInput::esc_url($this->setting_item('image_url') ?? '');

        $particle_image_one = $this->setting_item('particle_image_one');
        $particle_image_two = $this->setting_item('particle_image_two');
        $particle_image_three = $this->setting_item('particle_image_three');
        $particle_image_four = $this->setting_item('particle_image_four');
        $particle_image_five = $this->setting_item('particle_image_five');
        $particle_image_six = $this->setting_item('particle_image_six');

        $padding_top = SanitizeInput::esc_html($this->setting_item('padding_top'));
        $padding_bottom = SanitizeInput::esc_html($this->setting_item('padding_bottom'));

        $data = [
            'padding_top'=> $padding_top,
            'padding_bottom'=> $padding_bottom,
            'title' => $title,
            'price' => $price,
            'button_text'=> $button_text,
            'button_url'=> $button_url,
            'image'=> $image,
            'image_url'=> $image_url,
            'particle_image_one'=> $particle_image_one,
            'particle_image_two'=> $particle_image_two,
            'particle_image_three'=> $particle_image_three,
            'particle_image_four'=> $particle_image_four,
            'particle_image_five'=> $particle_image_five,
            'particle_image_six'=> $particle_image_six,
        ];

        return self::renderView('tenant.aromatic.product.best_product', $data);
    }

    public function addon_title()
    {
        return __('Aromatic: Best Product');
    }
}
