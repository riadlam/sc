<?php

namespace Plugins\WidgetBuilder\Widgets\Tenants\Bookpoint;


use App\Helpers\SanitizeInput;
use Plugins\PageBuilder\Fields\Repeater;
use Plugins\PageBuilder\Fields\Text;
use Plugins\PageBuilder\Helpers\RepeaterField;
use Plugins\WidgetBuilder\Traits\LanguageFallbackForWidgetBuilder;
use Plugins\WidgetBuilder\WidgetBase;
use function __;

class NewsletterBookpoint extends WidgetBase
{
    use LanguageFallbackForWidgetBuilder;

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
            'id' => 'tenant_social_repeater',
            'fields' => [
                [
                    'type' => RepeaterField::ICON_PICKER,
                    'name' => 'repeater_icon',
                    'label' => __('Icon')
                ],
                [
                    'type' => RepeaterField::TEXT,
                    'name' => 'repeater_url',
                    'label' => __('Icon URL')
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
        $settings = $this->get_settings();
        $widget_title = SanitizeInput::esc_html($settings['title'] ?? '');
        $widget_subtitle = SanitizeInput::esc_html( $settings['subtitle'] ?? '');
        $repeater_data =  $settings['tenant_social_repeater'] ?? [];
        $form_action = '#';

        $social_markup = '';
        foreach ($repeater_data['repeater_icon_'] ?? [] as $key => $data){
            $social_markup .= '<li class="lists">
                                   <a class="facebook" href="'.($repeater_data['repeater_url_'][$key] ?? '').'">
                                        <i class="'.($repeater_data['repeater_icon_'][$key] ?? '').'"></i>
                                   </a>
                               </li>';
        }

        return '<div class="col-lg-3 col-sm-6">
                    <div class="footer-widget widget">
                            <h6 class="widget-title"> '.$widget_title.' </h6>
                            <div class="footer-inner mt-4">
                                <p class="subscribe-para"> '.$widget_subtitle.' </p>

                                <div class="subscribe-form">
                                    <form action="'.$form_action.'" method="POST">
                                    <div class="form-message-show"></div>
                                        <div class="widget-form-single">
                                            <input type="text" name="email" class="email form--control" placeholder="'.__('Your Mail Here').'">
                                            <button type="submit" class="newsletter-submit-btn"> <i class="lar la-paper-plane"></i> </button>
                                        </div>
                                    </form>
                                </div>
                                <ul class="footer-social-list mt-4">'.$social_markup.'</ul>
                            </div>
                        </div>
                    </div>';
    }

    public function enable(): bool
    {
        return !is_null(tenant()) ? true : false;
    }

    public function widget_title(){
        return __('Tenant Newsletter: BookPoint');
    }
}
