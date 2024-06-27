<?php

namespace Plugins\WidgetBuilder\Widgets\Tenants\Bookpoint;

use App\Helpers\SanitizeInput;
use Plugins\PageBuilder\Fields\Repeater;
use Plugins\PageBuilder\Fields\Text;
use Plugins\PageBuilder\Helpers\RepeaterField;
use Plugins\WidgetBuilder\WidgetBase;
use function render_image_markup_by_attachment_id;
use function url;

class TenantImageWidget extends WidgetBase
{
    public function admin_render()
    {
        $output = $this->admin_form_before();
        $output .= $this->admin_form_start();
        $output .= $this->default_fields();
        $widget_saved_values = $this->get_settings();

        //repeater
        $output .= Repeater::get([
            'settings' => $widget_saved_values,
            'id' => 'image_widget',
            'fields' => [
                [
                    'type' => RepeaterField::IMAGE,
                    'name' => 'repeater_image',
                    'label' => __('Image')
                ],
                [
                    'type' => RepeaterField::TEXT,
                    'name' => 'repeater_image_url',
                    'label' => __('Image URL')
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
        $repeater_data = $widget_saved_values['image_widget'] ?? [];

        $markup = '<div class="col-lg-6 col-md-6 col-sm-6 mt-4">';
        $markup .= '<div class="footer-widget widget">';
        $markup .= '<div class="footer-inner">';

        $image_count = array_key_exists('repeater_image_', $repeater_data) ? count($repeater_data['repeater_image_']) : 0;
        if ($image_count > 1) {
            $markup .= $this->multipleImage($repeater_data);
        } else {
            $markup .= $this->singleImage($repeater_data);
        }

        $markup .= '</div>';
        $markup .= '</div>';
        $markup .= '</div>';

        return $markup;
    }

    private function singleImage($data)
    {
        $markup = '';
        foreach ($data['repeater_image_'] ?? [] as $key => $url) {
            $repeater_image_url = SanitizeInput::esc_url($data['repeater_image_url_'][$key] ?? '') ?? '';
            $image_markup = render_image_markup_by_attachment_id($data['repeater_image_'][$key] ?? 0);

            $markup .= '<div class="about_us_widget">
                            <a href="'.$repeater_image_url.'" class="footer-logo">
                                '.$image_markup.'
                            </a>
                        </div>';
        }

        return $markup;
    }

    private function multipleImage($data)
    {
        $markup = '<div class="footer-menu">';
        $markup .= '<ul class="payment-list">';
        foreach ($data['repeater_image_'] ?? [] as $key => $url) {
            $repeater_image_url = SanitizeInput::esc_url($data['repeater_image_url_'][$key] ?? '') ?? '';
            $image_markup = render_image_markup_by_attachment_id($data['repeater_image_'][$key] ?? 0);

            $markup .= '<li class="list">
                            <a href="'.$repeater_image_url.'">
                                '.$image_markup.'
                            </a>
                        </li>';
        }
        $markup .= '</ul>';
        $markup .= '</div>';

        return $markup;
    }

    public function enable(): bool
    {
        return !is_null(tenant()) ? true : false;
    }

    public function widget_title()
    {
        return __('Footer Image Widget : BookPoint');
    }

}
