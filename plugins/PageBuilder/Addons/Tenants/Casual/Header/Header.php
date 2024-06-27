<?php

namespace Plugins\PageBuilder\Addons\Tenants\Casual\Header;

use App\Enums\StatusEnums;
use App\Facades\GlobalLanguage;
use App\Helpers\SanitizeInput;
use Modules\Attributes\Entities\Category;
use Modules\Product\Entities\Product;
use Plugins\PageBuilder\Fields\ColorPicker;
use Plugins\PageBuilder\Fields\Image;
use Plugins\PageBuilder\Fields\NiceSelect;
use Plugins\PageBuilder\Fields\Number;
use Plugins\PageBuilder\Fields\Repeater;
use Plugins\PageBuilder\Fields\Switcher;
use Plugins\PageBuilder\Fields\Text;
use Plugins\PageBuilder\Helpers\RepeaterField;
use Plugins\PageBuilder\PageBuilderBase;

class Header extends PageBuilderBase
{
    public function preview_image()
    {
        return 'Tenant/Home/home-01-header-01.png';
    }

    public function admin_render()
    {
        $output = $this->admin_form_before();
        $output .= $this->admin_form_start();
        $output .= $this->default_fields();

        $widget_saved_values = $this->get_settings();

        $output .= Text::get([
            'name' => 'pre_title',
            'label' => __('Pre Title'),
            'value' => $widget_saved_values['pre_title'] ?? null,
        ]);

        $output .= Text::get([
            'name' => 'title',
            'label' => __('Title'),
            'value' => $widget_saved_values['title'] ?? null,
        ]);

        $output .= Text::get([
            'name' => 'button_text',
            'label' => __('Button Text'),
            'value' => $widget_saved_values['button_text'] ?? null,
        ]);

        $output .= Text::get([
            'name' => 'button_url',
            'label' => __('Button URl'),
            'value' => $widget_saved_values['button_url'] ?? null,
        ]);

        $output .= ColorPicker::get([
            'name' => 'background_color',
            'label' => __('Background Color'),
            'value' => $widget_saved_values['background_color'] ?? null,
            'info' => '<div class="text-primary mt-1">' . __('Keep empty if you want to keep theme default colors') . '</div>'
        ]);

        $output .= Repeater::get([
            'multi_lang' => false,
            'settings' => $widget_saved_values,
            'id' => 'social_repeater',
            'fields' => [
                [
                    'type' => RepeaterField::TEXT,
                    'label' => __('Social Media Name'),
                    'name' => 'name',
                ],
                [
                    'type' => RepeaterField::TEXT,
                    'label' => __('Social Media URL'),
                    'name' => 'url',
                ]
            ]
        ]);

        $output .= Switcher::get([
            'name' => 'new_tab',
            'label' => __('Open Social Media in a new Tab'),
            'value' => $widget_saved_values['new_tab'] ?? false,
        ]);

        $products = Product::where('status_id', StatusEnums::PUBLISH)->pluck('name', 'id')->toArray();
        $output .= NiceSelect::get([
            'multiple' => true,
            'name' => 'products',
            'label' => __('Select Products'),
            'options' => $products,
            'value' => $widget_saved_values['products'] ?? '',
            'info' => __('Leave empty if you do not want to show any product')
        ]);

        $output .= Image::get([
            'name' => 'primary_image',
            'label' => __('Primary Image'),
            'value' => $widget_saved_values['primary_image'] ?? null,
            'dimensions' => __('775x557 | 770x550 px')
        ]);

        $output .= Image::get([
            'name' => 'floating_particle_one',
            'label' => __('Floating Particle Image One'),
            'value' => $widget_saved_values['floating_particle_one'] ?? null,
            'dimensions' => '1:1'
        ]);

        $output .= Image::get([
            'name' => 'floating_particle_two',
            'label' => __('Floating Particle Image Two'),
            'value' => $widget_saved_values['floating_particle_two'] ?? null,
            'dimensions' => '1:1'
        ]);

        $output .= Image::get([
            'name' => 'floating_particle_three',
            'label' => __('Floating Particle Image Three'),
            'value' => $widget_saved_values['floating_particle_three'] ?? null,
            'dimensions' => '1:1'
        ]);

        $output .= Image::get([
            'name' => 'floating_particle_four',
            'label' => __('Floating Particle Image Four'),
            'value' => $widget_saved_values['floating_particle_four'] ?? null,
            'dimensions' => '1:1'
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
        $pre_title = SanitizeInput::esc_html($this->setting_item('pre_title'));
        $title = SanitizeInput::esc_html($this->setting_item('title'));
        $button_text = SanitizeInput::esc_html($this->setting_item('button_text'));
        $button_url = SanitizeInput::esc_url($this->setting_item('button_url'));
        $background_color = $this->setting_item('background_color');

        $social_repeater = $this->setting_item('social_repeater');
        $new_tab = $this->setting_item('new_tab');

        $products_id = $this->setting_item('products');
        $products = [];
        if (!empty($products_id)){
            $products = Product::whereIn('id', $products_id)->orderBy('id', 'desc')->get();
        }

        $primary_image = $this->setting_item('primary_image');
        $particle_image_one = $this->setting_item('floating_particle_one');
        $particle_image_two = $this->setting_item('floating_particle_two');
        $particle_image_three = $this->setting_item('floating_particle_three');
        $particle_image_four = $this->setting_item('floating_particle_four');;

        $padding_top = SanitizeInput::esc_html($this->setting_item('padding_top'));
        $padding_bottom = SanitizeInput::esc_html($this->setting_item('padding_bottom'));

        $data = [
            'pre_title' => $pre_title,
            'title' => $title,
            'button_text' => $button_text,
            'button_url' => $button_url,
            'background_color' => $background_color,
            'social_repeater' => $social_repeater,
            'new_tab' => $new_tab,
            'products' => $products,
            'primary_image' => $primary_image,
            'particle_image_one' => $particle_image_one,
            'particle_image_two' => $particle_image_two,
            'particle_image_three' => $particle_image_three,
            'particle_image_four' => $particle_image_four,
            'padding_top' => $padding_top,
            'padding_bottom' => $padding_bottom
        ];

        return self::renderView('tenant.casual.header.header', $data);
    }

    public function enable(): bool
    {
        return !is_null(tenant());
    }

    public function addon_title()
    {
        return __('Casual: Header');
    }
}
