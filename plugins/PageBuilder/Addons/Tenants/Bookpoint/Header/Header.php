<?php

namespace Plugins\PageBuilder\Addons\Tenants\Bookpoint\Header;

use App\Facades\GlobalLanguage;
use App\Helpers\SanitizeInput;
use Plugins\PageBuilder\Fields\Image;
use Plugins\PageBuilder\Fields\Repeater;
use Plugins\PageBuilder\Fields\Text;
use Plugins\PageBuilder\Fields\Textarea;
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
            'name' => 'title',
            'label' => __('Title'),
            'value' => $widget_saved_values['title'] ?? null,
        ]);

        $output .= Textarea::get([
            'name' => 'description',
            'label' => __('Description'),
            'value' => $widget_saved_values['description'] ?? null,
        ]);

        $output .= Text::get([
            'name' => 'button_text',
            'label' => __('Button Text'),
            'value' => $widget_saved_values['button_text'] ?? null,
        ]);

        $output .= Text::get([
            'name' => 'button_url',
            'label' => __('Button URL'),
            'value' => $widget_saved_values['button_url'] ?? '#',
        ]);

        $output .= Image::get([
            'name' => 'background_image',
            'label' => __('Background Image'),
            'value' => $widget_saved_values['background_image'] ?? null,
        ]);

        $output .= Image::get([
            'name' => 'image_one',
            'label' => __('foreground Top Image'),
            'value' => $widget_saved_values['image_one'] ?? null,
        ]);

        $output .= Image::get([
            'name' => 'image_two',
            'label' => __('foreground Middle Image'),
            'value' => $widget_saved_values['image_two'] ?? null,
        ]);

        $output .= Image::get([
            'name' => 'image_three',
            'label' => __('foreground Bottom Image'),
            'value' => $widget_saved_values['image_three'] ?? null,
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
        $title = SanitizeInput::esc_html($this->setting_item('title'));
        $description = SanitizeInput::esc_html($this->setting_item('description'));
        $button_text = SanitizeInput::esc_html($this->setting_item('button_text'));
        $button_url = SanitizeInput::esc_url($this->setting_item('button_url'));
        $bg_image = $this->setting_item('background_image');
        $fg_image_top = $this->setting_item('image_one');
        $fg_image_middle = $this->setting_item('image_two');
        $fg_image_bottom = $this->setting_item('image_three');
        $padding_top = SanitizeInput::esc_html($this->setting_item('padding_top'));
        $padding_bottom = SanitizeInput::esc_html($this->setting_item('padding_bottom'));

        $data = [
            'title' => $title,
            'description' => $description,
            'button_text' => $button_text,
            'button_url' => $button_url,
            'background_image' => $bg_image,
            'foreground_image_top' => $fg_image_top,
            'foreground_image_middle' => $fg_image_middle,
            'foreground_image_bottom' => $fg_image_bottom,
            'padding_top' => $padding_top,
            'padding_bottom' => $padding_bottom
        ];

        return self::renderView('tenant.bookpoint.header.header', $data);

    }

    public function enable(): bool
    {
        return !is_null(tenant());
    }

    public function addon_title()
    {
        return __('Theme Bookpoint: Header(01)');
    }
}
