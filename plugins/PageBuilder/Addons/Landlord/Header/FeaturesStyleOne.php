<?php

namespace Plugins\PageBuilder\Addons\Landlord\Header;

use App\Facades\GlobalLanguage;
use App\Helpers\SanitizeInput;

use Plugins\PageBuilder\Fields\IconPicker;
use Plugins\PageBuilder\Fields\Image;
use Plugins\PageBuilder\Fields\Repeater;
use Plugins\PageBuilder\Fields\Slider;
use Plugins\PageBuilder\Fields\Text;
use Plugins\PageBuilder\Helpers\RepeaterField;
use Plugins\PageBuilder\Helpers\Traits\GlobalAdminFields;
use Plugins\PageBuilder\PageBuilderBase;

class FeaturesStyleOne extends PageBuilderBase
{

    public function preview_image()
    {
        return 'Landlord/common/features.png';
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
            'info' => __('To show the highlighted text, place your word between this code {h}YourText{/h]')
        ]);

        $output .= Image::get([
            'name' => 'title_line_shape',
            'label' => __('Title Text Line Shape'),
            'value' => $widget_saved_values['title_line_shape'] ?? null,
            'dimensions' => '~230x60 px'
        ]);

        $output .= Text::get([
            'name' => 'subtitle',
            'label' => __('Subtitle'),
            'value' => $widget_saved_values['subtitle'] ?? null,
        ]);

        $output .= Repeater::get([
            'multi_lang' => false,
            'settings' => $widget_saved_values,
            'id' => 'features_repeater',
            'fields' => [
                [
                    'type' => RepeaterField::IMAGE,
                    'name' => 'repeater_image',
                    'label' => __('Service Image'),
                    'info' => __('Upload same color SVG images'),
                    'dimensions' => '60x60 px or 1:1 ratio'
                ],
                [
                    'type' => RepeaterField::TEXT,
                    'name' => 'repeater_title',
                    'label' => __('Service Title')
                ],
                [
                    'type' => RepeaterField::TEXT,
                    'name' => 'repeater_description',
                    'label' => __('Description')
                ],
                [
                    'type' => RepeaterField::TEXT,
                    'name' => 'repeater_button_text',
                    'label' => __('Button Text')
                ],
                [
                    'type' => RepeaterField::TEXT,
                    'name' => 'repeater_button_link',
                    'label' => __('Button Link')
                ],
            ]
        ]);

        $output .= Image::get([
            'name' => 'background_shape',
            'label' => __('Background Shape Image'),
            'value' => $widget_saved_values['background_shape'] ?? null,
        ]);
        // add padding option


        $output .= $this->section_id_and_class_fields($widget_saved_values);
        $output .= $this->padding_fields($widget_saved_values);
        $output .= $this->admin_form_submit_button();
        $output .= $this->admin_form_end();
        $output .= $this->admin_form_after();

        return $output;
    }

    public function frontend_render()
    {
        $title = SanitizeInput::esc_html($this->setting_item('title')) ?? '';
        $subtitle = SanitizeInput::esc_html($this->setting_item('subtitle')) ?? '';

        $repeater_data = $this->setting_item('features_repeater');

        $title_line_shape = $this->setting_item('title_line_shape') ?? '';
        $bg_shape_image = $this->setting_item('background_shape') ?? '';

        $section_id = SanitizeInput::esc_html($this->setting_item('section_id')) ?? '';


        $padding_top = SanitizeInput::esc_html($this->setting_item('padding_top'));
        $padding_bottom = SanitizeInput::esc_html($this->setting_item('padding_bottom'));

        $data = [
            'title' => $title,
            'subtitle' => $subtitle,
            'repeater_data' => $repeater_data,

            'title_line_shape' => $title_line_shape,
            'bg_shape_image' => $bg_shape_image,

            'padding_top' => $padding_top,
            'padding_bottom' => $padding_bottom,
            'section_id' => $section_id,
        ];

        return self::renderView('landlord.addons.header.FeaturesOne', $data);

    }

    public function enable(): bool
    {
        return (bool)is_null(tenant());
    }

    public function addon_title()
    {
        return __('Features :01');
    }
}
