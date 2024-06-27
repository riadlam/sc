<?php

namespace Plugins\WidgetBuilder\Widgets\Tenants\Casual;

use Plugins\PageBuilder\Fields\Repeater;
use Plugins\PageBuilder\Fields\Text;
use Plugins\PageBuilder\Helpers\RepeaterField;
use Plugins\WidgetBuilder\WidgetBase;
use function __;

class TenantAboutUsWidgetThree extends WidgetBase
{
    public function admin_render()
    {
        $output = $this->admin_form_before();
        $output .= $this->admin_form_start();
        $output .= $this->default_fields();
        $widget_saved_values = $this->get_settings();

        $output .= Text::get([
            'name' => 'title',
            'label' => __('Widget Title'),
            'value' => $widget_saved_values['title'] ?? null,
        ]);

        //repeater
        $output .= Repeater::get([
            'settings' => $widget_saved_values,
            'id' => 'about_us_two_widget',
            'fields' => [
                [
                    'type' => RepeaterField::TEXT,
                    'name' => 'repeater_text',
                    'label' => __('Text')
                ],
                [
                    'type' => RepeaterField::TEXT,
                    'name' => 'repeater_icon_url',
                    'label' => __('Icon URL')
                ],
                [
                    'type' => RepeaterField::ICON_PICKER,
                    'name' => 'repeater_icon',
                    'label' => __('Icon')
                ],
            ]
        ]);

        $output .= $this->admin_form_submit_button();
        $output .= $this->admin_form_end();
        $output .= $this->admin_form_after();

        return $output;
    }

    public function frontend_render()
    {
        $widget_saved_values = $this->get_settings();
        $widget_title = esc_html($widget_saved_values['title'] ?? '');
        $repeater_data = $widget_saved_values['about_us_two_widget'] ?? [];

        $social_markup = '';
        foreach ($repeater_data['repeater_icon_url_'] as $key => $url){
            $repeater_url = esc_url($url) ?? '';
            $repeater_text = esc_html($repeater_data['repeater_text_'][$key]) ?? '';
            $repeater_icon = $repeater_data['repeater_icon_'][$key] ?? '';

      $social_markup .= '<li class="list">
                            <span class="address">
                                <a href="'.$repeater_url.'">
                                    <i class="'.$repeater_icon.'"></i>
                                    '.$repeater_text.'
                                </a>
                            </span>
                         </li>';
    }

        $output = $this->widget_before(); //render widget before content
        $output .= '<h6 class="widget-title">'.$widget_title.'</h6>
                    <div class="footer-inner margin-top-30">
                         <ul class="footer-link-address">
                             '.$social_markup.'
                         </ul>
                    </div>';
        $output .= $this->widget_after(); // render widget after content

        return $output;
}

    public function enable(): bool
    {
        return !is_null(tenant()) ? true : false;
    }

    public function widget_title(){
        return __('Tenant About Us : Casual');
    }

}
