<?php

namespace Plugins\PageBuilder\Addons\Landlord\Common;

use App\Facades\GlobalLanguage;
use App\Helpers\SanitizeInput;

use App\Models\Testimonial;
use Plugins\PageBuilder\Fields\Image;
use Plugins\PageBuilder\Fields\Number;
use Plugins\PageBuilder\Fields\Select;
use Plugins\PageBuilder\Fields\Text;
use Plugins\PageBuilder\PageBuilderBase;

class Newsletter extends PageBuilderBase
{

    public function preview_image()
    {
        return 'Landlord/common/feedback.png';
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

        $output .= Text::get([
            'name' => 'button_text',
            'label' => __('Button Text'),
            'value' => $widget_saved_values['button_text'] ?? null,
        ]);

        $output .= Text::get([
            'name' => 'input_text',
            'label' => __('Input Text'),
            'value' => $widget_saved_values['input_text'] ?? null,
        ]);

        $output .= Image::get([
            'name' => 'bg_shape',
            'label' => __('Background Shape Image'),
            'value' => $widget_saved_values['bg_shape'] ?? null,
            'dimensions' => '1296x447 | 1290x450 px'
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

        $button_text = SanitizeInput::esc_html($this->setting_item('button_text')) ?? '';
        $input_text = SanitizeInput::esc_html($this->setting_item('input_text')) ?? '';

        $bg_image = $this->setting_item('bg_shape') ?? '';

        $padding_top = SanitizeInput::esc_html($this->setting_item('padding_top'));
        $padding_bottom = SanitizeInput::esc_html($this->setting_item('padding_bottom'));

        $section_id = SanitizeInput::esc_html($this->setting_item('section_id')) ?? '';

        $data = [
            'title' => $title,
            'subtitle' => $subtitle,
            'button_text' => $button_text,
            'input_text' => $input_text,
            'bg_image' => $bg_image,
            'padding_top' => $padding_top,
            'padding_bottom' => $padding_bottom,
            'section_id' => $section_id,
        ];

        return self::renderView('landlord.addons.common.newsletter', $data);

    }

    public function enable(): bool
    {
        return (bool)is_null(tenant());
    }

    public function addon_title()
    {
        return __('Newsletter');
    }
}
