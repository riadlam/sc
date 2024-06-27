<?php

namespace Plugins\WidgetBuilder\Widgets\Tenants\Bookpoint;

use App\Helpers\SanitizeInput;
use App\Models\Menu;
use Plugins\WidgetBuilder\WidgetBase;

class NavigationMenuWidgetBookpoint extends WidgetBase
{

    public function admin_render()
    {
        // TODO: Implement admin_render() method.
        $output = $this->admin_form_before();
        $output .= $this->admin_form_start();
        $output .= $this->default_fields();
        $widget_saved_values = $this->get_settings();

        $widget_title =  $widget_saved_values['widget_title'] ?? '';
        $selected_menu_id = $widget_saved_values['menu_id'] ?? '';

        $output .= '<div class="form-group"><input type="text" name="widget_title" class="form-control" placeholder="' . __('Widget Title') . '" value="'. SanitizeInput::esc_html($widget_title) .'"></div>';

        $navigation_menus = Menu::all();
        $output .= '<div class="form-group">';
        $output .= '<select class="form-control" name="menu_id">';
        foreach($navigation_menus as $menu_item){
            $selected = $selected_menu_id == $menu_item->id ? 'selected' : '';
            $output .= '<option value="'.$menu_item->id.'" '.$selected.'>'.SanitizeInput::esc_html($menu_item->title).'</option>';
        }
        $output .= '</select>';
        $output .= '</div>';
        $output .= $this->admin_form_submit_button();
        $output .= $this->admin_form_end();
        $output .= $this->admin_form_after();

        return $output;
    }

    public function frontend_render()
    {
        // TODO: Implement frontend_render() method.
        $widget_saved_values = $this->get_settings();
        $widget_title = SanitizeInput::esc_html($widget_saved_values['widget_title'] ?? '');
        $menu_id = $widget_saved_values['menu_id'] ?? '';

        $output = '<div class="col-lg-2 col-md-6 col-sm-6">';
        $output .= '<div class="footer-widget widget">';
        $output .= '<h4 class="widget-title fw-500">'.$widget_title.'</h4>';
        $output .= '<div class="footer-inner mt-4">';
        $output .= '<ul class="footer-link-list">';
        $output .= render_frontend_menu($menu_id);
        $output .= '</ul>';
        $output .= '</div>';
        $output .= '</div>';
        $output .= '</div>';

        return $output;
    }

    public function enable(): bool
    {
        return !is_null(tenant()) ? true : false;
    }

    public function widget_title()
    {
        // TODO: Implement widget_title() method.
        return __('Navigation Menu: BookPoint');
    }
}
