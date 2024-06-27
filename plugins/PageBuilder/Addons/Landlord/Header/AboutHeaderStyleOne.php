<?php

namespace Plugins\PageBuilder\Addons\Landlord\Header;

use App\Facades\GlobalLanguage;
use App\Helpers\LanguageHelper;
use App\Helpers\SanitizeInput;

use Plugins\PageBuilder\Fields\IconPicker;
use Plugins\PageBuilder\Fields\Image;
use Plugins\PageBuilder\Fields\Slider;
use Plugins\PageBuilder\Fields\Text;
use Plugins\PageBuilder\Fields\Textarea;
use Plugins\PageBuilder\Helpers\Traits\GlobalAdminFields;
use Plugins\PageBuilder\PageBuilderBase;

class AboutHeaderStyleOne extends PageBuilderBase
{

    public function preview_image()
    {
       return 'Landlord/header/header-01.png';
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

            $output .= Textarea::get([
                'name' => 'description',
                'label' => __('Description'),
                'value' => $widget_saved_values['description'] ?? null,
            ]);


        $output .= Image::get([
            'name' => 'image',
            'label' => __('Image'),
            'value' => $widget_saved_values['image'] ?? null,
            'dimensions' => '1076x587 | 1080x560 px'
        ]);


        // add padding option

        $output.= $this->section_id_and_class_fields($widget_saved_values);
        $output .= $this->padding_fields($widget_saved_values);
        $output .= $this->admin_form_submit_button();
        $output .= $this->admin_form_end();
        $output .= $this->admin_form_after();

        return $output;
    }

    public function frontend_render()
    {
        $title = SanitizeInput::esc_html($this->setting_item('title')) ?? '';
        $description = SanitizeInput::esc_html($this->setting_item('description')) ?? '';

        $image = $this->setting_item('image') ?? '';

        $section_id = SanitizeInput::esc_html($this->setting_item('section_id')) ?? '';


        $padding_top = SanitizeInput::esc_html($this->setting_item('padding_top'));
        $padding_bottom = SanitizeInput::esc_html($this->setting_item('padding_bottom'));

        $data = [
            'title'=> $title,
            'description'=> $description,

            'image' => $image,

            'padding_top'=> $padding_top,
            'padding_bottom'=> $padding_bottom,
            'section_id'=> $section_id,
        ];

        return self::renderView('landlord.addons.header.AboutHeaderOne',$data);
    }

    public function enable(): bool
    {
        return (bool) is_null(tenant());
    }

    public function addon_title()
    {
        return __('About Header :01');
    }
}
