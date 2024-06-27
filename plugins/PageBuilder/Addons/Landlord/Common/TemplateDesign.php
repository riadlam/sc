<?php

namespace Plugins\PageBuilder\Addons\Landlord\Common;

use App\Facades\GlobalLanguage;
use App\Helpers\LanguageHelper;
use App\Helpers\SanitizeInput;

use Plugins\PageBuilder\Fields\IconPicker;
use Plugins\PageBuilder\Fields\Image;
use Plugins\PageBuilder\Fields\Repeater;
use Plugins\PageBuilder\Fields\Slider;
use Plugins\PageBuilder\Fields\Text;
use Plugins\PageBuilder\Helpers\RepeaterField;
use Plugins\PageBuilder\PageBuilderBase;

class TemplateDesign extends PageBuilderBase
{

    public function preview_image()
    {
        return 'Landlord/common/design-template.png';
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

        $output .= Text::get([
            'name' => 'subtitle',
            'label' => __('Subtitle'),
            'value' => $widget_saved_values['subtitle'] ?? null,
        ]);

        //repeater
        $output .= Repeater::get([
            'settings' => $widget_saved_values,
            'id' => 'template_design_repeater',
            'fields' => [
                [
                    'type' => RepeaterField::TEXT,
                    'name' => 'repeater_image_url',
                    'label' => __('Image URL')
                ],
                [
                    'type' => RepeaterField::IMAGE,
                    'name' => 'repeater_image',
                    'label' => __('Image'),
                ],
            ]
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
        $padding_top = SanitizeInput::esc_html($this->setting_item('padding_top'));
        $padding_bottom = SanitizeInput::esc_html($this->setting_item('padding_bottom'));

        $repeater_data = $this->setting_item('template_design_repeater');
        $section_id = SanitizeInput::esc_html($this->setting_item('section_id')) ?? '';

        $data = [
            'title' => $title,
            'subtitle' => $subtitle,
            'padding_top' => $padding_top,
            'padding_bottom' => $padding_bottom,
            'repeater_data' => $repeater_data,
            'section_id' => $section_id,
        ];

        return self::renderView('landlord.addons.common.template-design', $data);

    }

    public function enable(): bool
    {
        return (bool)is_null(tenant());
    }

    public function addon_title()
    {
        return __('Template Design');
    }
}
