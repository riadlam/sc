<?php

namespace Plugins\PageBuilder\Addons\Tenants\Aromatic\Common;

use App\Helpers\InstagramFeedHelper;
use App\Helpers\LanguageHelper;
use App\Helpers\SanitizeInput;
use Illuminate\Support\Facades\Cache;
use Modules\Campaign\Entities\Campaign;
use Plugins\PageBuilder\Fields\NiceSelect;
use Plugins\PageBuilder\Fields\Number;
use Plugins\PageBuilder\Fields\Select;
use Plugins\PageBuilder\Fields\Switcher;
use Plugins\PageBuilder\Fields\Text;
use Plugins\PageBuilder\PageBuilderBase;

class InstagramWidget extends PageBuilderBase
{

    public function preview_image()
    {
        return 'Tenant/common/brand-01.png';
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

        $output .= Number::get([
            'name' => 'post_items',
            'label' => __('Post Item'),
            'value' => $widget_saved_values['post_items'] ?? null,
        ]);

        $output .= Switcher::get([
            'name' => 'media_redirection',
            'label' => __('Media Redirection'),
            'value' => $widget_saved_values['media_redirection'] ?? null,
            'info' => __('Open in a new tab?')
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
        $widget_saved_values = $this->get_settings();

        $widget_title = SanitizeInput::esc_html(($this->setting_item('title') ?? ''));
        $post_items = $widget_saved_values['post_items'] ?? '';
        $media_redirection= $widget_saved_values['media_redirection'] ?? null;

        $instagram_data = Cache::remember('instagram_feed',now()->addDays(2),function () use($post_items) {
            return (new InstagramFeedHelper())->fetch($post_items);
        });

        $data = [
            'padding_top' => $padding_top,
            'padding_bottom' => $padding_bottom,
            'title' => $widget_title,
            'media_redirection' => $media_redirection,
            'instagram_data' => $instagram_data
        ];

        return self::renderView('tenant.aromatic.common.instagram-feed', $data);
    }

    public function addon_title()
    {
        return __('Aromatic: Instagram Feed');
    }
}

