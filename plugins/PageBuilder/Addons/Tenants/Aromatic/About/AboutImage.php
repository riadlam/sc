<?php

namespace Plugins\PageBuilder\Addons\Tenants\Aromatic\About;

use App\Facades\GlobalLanguage;
use App\Helpers\LanguageHelper;
use App\Helpers\SanitizeInput;

use App\Models\Testimonial;
use Plugins\PageBuilder\Fields\IconPicker;
use Plugins\PageBuilder\Fields\Image;
use Plugins\PageBuilder\Fields\Number;
use Plugins\PageBuilder\Fields\Repeater;
use Plugins\PageBuilder\Fields\Slider;
use Plugins\PageBuilder\Fields\Summernote;
use Plugins\PageBuilder\Fields\Text;
use Plugins\PageBuilder\Fields\Textarea;
use Plugins\PageBuilder\Helpers\RepeaterField;
use Plugins\PageBuilder\PageBuilderBase;

class AboutImage extends PageBuilderBase
{

    public function preview_image()
    {
        return 'Landlord/common/brand.png';
    }

    public function admin_render()
    {
        $output = $this->admin_form_before();
        $output .= $this->admin_form_start();
        $output .= $this->default_fields();
        $widget_saved_values = $this->get_settings();

        $output .= Repeater::get([
            'multi_lang' => false,
            'settings' => $widget_saved_values,
            'id' => 'about_repeater',
            'fields' => [
                [
                    'type' => RepeaterField::IMAGE,
                    'name' => 'repeater_image',
                    'label' => __('Image')
                ]
            ]
        ]);

        $output .= Text::get([
            'name' => 'primary_title',
            'label' => __('Primary Title'),
            'value' => $widget_saved_values['primary_title'] ?? null,
        ]);

        $output .= Textarea::get([
            'name' => 'description',
            'label' => __('Description'),
            'value' => $widget_saved_values['description'] ?? null,
        ]);

        $output .= '<hr>';

        $output .= Text::get([
            'name' => 'secondary_title',
            'label' => __('Secondary Title'),
            'value' => $widget_saved_values['secondary_title'] ?? null,
        ]);

        $output .= Textarea::get([
            'name' => 'secondary_description',
            'label' => __('Secondary Description'),
            'value' => $widget_saved_values['secondary_description'] ?? null,
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
        $padding_top = SanitizeInput::esc_html($this->setting_item('padding_top'));
        $padding_bottom = SanitizeInput::esc_html($this->setting_item('padding_bottom'));

        $repeater_data = $this->setting_item('about_repeater');

        $primary_title = esc_html($this->setting_item('primary_title'));
        $primary_description = esc_html($this->setting_item('description'));

        $secondary_title = esc_html($this->setting_item('secondary_title'));
        $secondary_description = esc_html($this->setting_item('secondary_description'));

        $section_id = SanitizeInput::esc_html($this->setting_item('section_id')) ?? '';
        $section_class = SanitizeInput::esc_html($this->setting_item('section_class')) ?? '';
        $data = [
            'padding_top'=> $padding_top,
            'padding_bottom'=> $padding_bottom,
            'repeater_data' => $repeater_data,
            'primary_title' => $primary_title,
            'primary_description' => $primary_description,
            'secondary_title' => $secondary_title,
            'secondary_description' => $secondary_description,
            'section_id'=> $section_id,
            'section_class'=> $section_class,
        ];

        return self::renderView('tenant.aromatic.about.about_image', $data);
    }

    public function addon_title()
    {
        return __('Aromatic: About Section');
    }
}
