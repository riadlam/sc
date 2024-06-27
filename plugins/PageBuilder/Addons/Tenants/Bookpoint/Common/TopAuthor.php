<?php

namespace Plugins\PageBuilder\Addons\Tenants\Bookpoint\Common;

use App\Facades\GlobalLanguage;
use App\Helpers\SanitizeInput;
use Modules\DigitalProduct\Entities\DigitalAuthor;
use Plugins\PageBuilder\Fields\Number;
use Plugins\PageBuilder\Fields\Repeater;
use Plugins\PageBuilder\Fields\Select;
use Plugins\PageBuilder\Fields\Switcher;
use Plugins\PageBuilder\Fields\Text;
use Plugins\PageBuilder\Helpers\RepeaterField;
use Plugins\PageBuilder\PageBuilderBase;
use function __;

class TopAuthor extends PageBuilderBase
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

        $output .= Text::get([
            'name' => 'title',
            'label' => __('Title'),
            'value' => $widget_saved_values['title'] ?? null,
        ]);

        $output .= Switcher::get([
            'name' => 'book_count',
            'label' => __('Show Book Numbers'),
            'value' => $widget_saved_values['book_count'] ?? null,
        ]);

        $output .= Number::get([
            'name' => 'limit',
            'label' => __('Author Limit'),
            'value' => $widget_saved_values['limit'] ?? null,
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
        $title = SanitizeInput::esc_html($this->setting_item('title'));
        $book_count = $this->setting_item('book_count');
        $limit = SanitizeInput::esc_html($this->setting_item('limit'));

        $padding_top = SanitizeInput::esc_html($this->setting_item('padding_top'));
        $padding_bottom = SanitizeInput::esc_html($this->setting_item('padding_bottom'));

        $authors = DigitalAuthor::whereHas('additionalFields');
        if ($book_count)
        {
            $authors->withCount('additionalFields')->withCount('additionalFields');
        }

        if ($limit)
        {
            $authors->take($limit);
        }

        $authors = $authors->get();

        $data = [
            'padding_top' => $padding_top,
            'padding_bottom' => $padding_bottom,
            'title' => $title,
            'authors' => $authors
        ];

        return self::renderView('tenant.bookpoint.common.top-author', $data);
    }

    public function enable(): bool
    {
        return (bool)!is_null(tenant());
    }

    public function addon_title()
    {
        return __('Theme Bookpoint: Top Author (01)');
    }
}
