<?php

namespace Plugins\PageBuilder\Addons\Tenants\Bookpoint\Common;

use App\Facades\GlobalLanguage;
use App\Helpers\SanitizeInput;
use Plugins\PageBuilder\Fields\Number;
use Plugins\PageBuilder\Fields\Repeater;
use Plugins\PageBuilder\Fields\Select;
use Plugins\PageBuilder\Fields\Text;
use Plugins\PageBuilder\Helpers\RepeaterField;
use Plugins\PageBuilder\PageBuilderBase;
use function __;

class CollectionCard extends PageBuilderBase
{
    public function preview_image()
    {
        return 'Tenant/common/testimonial-01.png';
    }

    public function admin_render()
    {
        $output = $this->admin_form_before();
        $output .= $this->admin_form_start();
        $output .= $this->default_fields();

        $widget_saved_values = $this->get_settings();

        //repeater
        $output .= Repeater::get([
            'multi_lang' => false,
            'settings' => $widget_saved_values,
            'id' => 'repeater_data',
            'fields' => [
                [
                    'type' => RepeaterField::TEXT,
                    'name' => 'repeater_title',
                    'label' => __('Title')
                ],
                [
                    'type' => RepeaterField::TEXT,
                    'name' => 'repeater_subtitle',
                    'label' => __('Subtitle')
                ],
                [
                    'type' => RepeaterField::TEXT,
                    'name' => 'repeater_button_text',
                    'label' => __('Button Text')
                ],
                [
                    'type' => RepeaterField::TEXT,
                    'name' => 'repeater_button_url',
                    'label' => __('Button URL')
                ],
                [
                    'type' => RepeaterField::SWITCHER,
                    'name' => 'repeater_button_target',
                    'label' => __('Button Target'),
                    'info' => __('keep on if you want to open the link in a different tab')
                ],
                [
                    'type' => RepeaterField::COLOR_PICKER,
                    'name' => 'repeater_button_color',
                    'label' => __('Button Color')
                ],
                [
                    'type' => RepeaterField::IMAGE,
                    'name' => 'repeater_image',
                    'label' => __('Image'),
                    'dimensions'=> '320x287 | 320x290 px'
                ],
                [
                    'type' => RepeaterField::COLOR_PICKER,
                    'name' => 'repeater_background_color',
                    'label' => __('Background Color')
                ],
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
        $padding_top = SanitizeInput::esc_html($this->setting_item('padding_top'));
        $padding_bottom = SanitizeInput::esc_html($this->setting_item('padding_bottom'));

        $repeater = $this->setting_item('repeater_data') ?? '';

        $data = [
            'padding_top' => $padding_top,
            'padding_bottom' => $padding_bottom,
            'repeater' => $repeater,
        ];

        return self::renderView('tenant.bookpoint.common.collection-card', $data);
    }

    public function enable(): bool
    {
        return (bool)!is_null(tenant());
    }

    public function addon_title()
    {
        return __('Theme Bookpoint: Collection Card (01)');
    }
}
