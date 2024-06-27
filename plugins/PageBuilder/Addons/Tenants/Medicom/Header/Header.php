<?php

namespace Plugins\PageBuilder\Addons\Tenants\Medicom\Header;

use App\Facades\GlobalLanguage;
use App\Helpers\SanitizeInput;
use Plugins\PageBuilder\Fields\Image;
use Plugins\PageBuilder\Fields\Repeater;
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

        $output .= Repeater::get([
            'multi_lang' => false,
            'settings' => $widget_saved_values,
            'id' => 'header_repeater',
            'fields' => [
                [
                    'type' => RepeaterField::TEXT,
                    'label' => 'Title',
                    'name' => 'title',
                    'info' => __('To show the highlighted text, place your word between this code {h}YourText{/h]')
                ],
                [
                    'type' => RepeaterField::TEXT,
                    'label' => 'Subtitle',
                    'name' => 'subtitle',
                ],
                [
                    'type' => RepeaterField::TEXT,
                    'label' => 'Shop Button Text',
                    'name' => 'shop_button_text',
                ],
                [
                    'type' => RepeaterField::TEXT,
                    'label' => 'Shop Button URL',
                    'name' => 'shop_button_url',
                ],
                [
                    'type' => RepeaterField::IMAGE,
                    'label' => 'Figure Image',
                    'name' => 'figure_image',
                ]
            ]
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
        $repeater_data = $this->setting_item('header_repeater');
        $padding_top = SanitizeInput::esc_html($this->setting_item('padding_top'));
        $padding_bottom = SanitizeInput::esc_html($this->setting_item('padding_bottom'));

        $data = [
                 'repeater_data' => $repeater_data,
                 'padding_top' => $padding_top,
                 'padding_bottom'=> $padding_bottom
            ];

        return self::renderView('tenant.medicom.header.header',$data);

    }

    public function enable(): bool
    {
        return !is_null(tenant());
    }

    public function addon_title()
    {
        return __('Theme medicom: Header(01)');
    }
}
