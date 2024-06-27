<?php

namespace Plugins\PageBuilder\Addons\Tenants\Aromatic\Header;

use App\Facades\GlobalLanguage;
use App\Helpers\SanitizeInput;
use Plugins\PageBuilder\Fields\ColorPicker;
use Plugins\PageBuilder\Fields\Image;
use Plugins\PageBuilder\Fields\Number;
use Plugins\PageBuilder\Fields\Repeater;
use Plugins\PageBuilder\Fields\Text;
use Plugins\PageBuilder\Helpers\RepeaterField;
use Plugins\PageBuilder\PageBuilderBase;

class HeaderOne extends PageBuilderBase
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

        $output .= Image::get([
            'name' => 'floating_particle_five',
            'label' => __('Floating Particle Image Five'),
            'value' => $widget_saved_values['floating_particle_five'] ?? null,
            'dimensions' => '1:1'
        ]);

        $output .= Image::get([
            'name' => 'floating_particle_six',
            'label' => __('Floating Particle Image Six'),
            'value' => $widget_saved_values['floating_particle_six'] ?? null,
            'dimensions' => '1:1'
        ]);

        $output .= Image::get([
            'name' => 'background_shape',
            'label' => __('Background Shape'),
            'value' => $widget_saved_values['background_shape'] ?? null,
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

        $primary_image = $this->setting_item('primary_image');
        $particle_image_one = $this->setting_item('floating_particle_one');
        $particle_image_two = $this->setting_item('floating_particle_two');
        $particle_image_three = $this->setting_item('floating_particle_three');
        $particle_image_four = $this->setting_item('floating_particle_four');
        $particle_image_five = $this->setting_item('floating_particle_five');
        $particle_image_six = $this->setting_item('floating_particle_six');
        $background_shape = $this->setting_item('background_shape');

        $repeater_data = $this->setting_item('header_repeater');
        $padding_top = SanitizeInput::esc_html($this->setting_item('padding_top'));
        $padding_bottom = SanitizeInput::esc_html($this->setting_item('padding_bottom'));

        $data = [
            'pre_title' => $pre_title,
            'title' => $title,
            'button_text' => $button_text,
            'button_url' => $button_url,
            'background_color' => $background_color,
            'primary_image' => $primary_image,
            'particle_image_one' => $particle_image_one,
            'particle_image_two' => $particle_image_two,
            'particle_image_three' => $particle_image_three,
            'particle_image_four' => $particle_image_four,
            'particle_image_five' => $particle_image_five,
            'particle_image_six' => $particle_image_six,
            'background_shape' => $background_shape,
            'repeater_data' => $repeater_data,
            'padding_top' => $padding_top,
            'padding_bottom' => $padding_bottom
        ];

        return self::renderView('tenant.aromatic.header.header-one', $data);

    }

    public function enable(): bool
    {
        return !is_null(tenant());
    }

    public function addon_title()
    {
        return __('Aromatic: Header(01)');
    }
}
