<?php

namespace Plugins\PageBuilder\Addons\Landlord\Common;

use App\Facades\GlobalLanguage;
use App\Helpers\LanguageHelper;
use App\Helpers\SanitizeInput;

use Plugins\PageBuilder\Fields\IconPicker;
use Plugins\PageBuilder\Fields\Image;
use Plugins\PageBuilder\Fields\Number;
use Plugins\PageBuilder\Fields\Repeater;
use Plugins\PageBuilder\Fields\Select;
use Plugins\PageBuilder\Fields\Slider;
use Plugins\PageBuilder\Fields\Text;
use Plugins\PageBuilder\Helpers\RepeaterField;
use Plugins\PageBuilder\PageBuilderBase;

class PricePlan extends PageBuilderBase
{

    public function preview_image()
    {
        return 'Landlord/common/price-plan.png';
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

        $output .= Select::get([
            'name' => 'order_by',
            'label' => __('Order By'),
            'options' => [
                'id' => __('ID'),
                'created_at' => __('Date'),
            ],
            'value' => $widget_saved_values['order_by'] ?? null,
            'info' => __('set order by')
        ]);
        $output .= Select::get([
            'name' => 'order',
            'label' => __('Order'),
            'options' => [
                'asc' => __('Accessing'),
                'desc' => __('Decreasing'),
            ],
            'value' => $widget_saved_values['order'] ?? null,
            'info' => __('set order')
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

        $order_by = SanitizeInput::esc_html($this->setting_item('order_by'));
        $order = SanitizeInput::esc_html($this->setting_item('order'));

        $all_price_plan = \App\Models\PricePlan::with('plan_features')->where('status',1)->orderBy($order_by ?? 'id',$order ?? 'asc')->get()->groupBy('type');
        $plan_types = \App\Models\PricePlan::where('status', 1)->orderBy('type', 'asc')->select('type')->distinct()->pluck('type');

        $section_id = SanitizeInput::esc_html($this->setting_item('section_id')) ?? '';

        $data = [
            'title'=> $title,
            'subtitle'=> $subtitle,
            'padding_top'=> $padding_top,
            'padding_bottom'=> $padding_bottom,
            'all_price_plan'=> $all_price_plan,
            'plan_types' => $plan_types,
            'section_id'=> $section_id,
        ];

        return self::renderView('landlord.addons.common.price-plan',$data);

    }

    public function enable(): bool
    {
        return (bool) is_null(tenant());
    }

    public function addon_title()
    {
        return __('Price Plan : 01');
    }
}
