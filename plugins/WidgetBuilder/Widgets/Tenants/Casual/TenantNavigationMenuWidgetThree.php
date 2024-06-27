<?php


namespace Plugins\WidgetBuilder\Widgets\Tenants\Casual;

use App\Models\Menu;
use Plugins\PageBuilder\Fields\Select;
use Plugins\PageBuilder\Fields\Text;
use Plugins\WidgetBuilder\Traits\LanguageFallbackForWidgetBuilder;
use Plugins\WidgetBuilder\WidgetBase;

class TenantNavigationMenuWidgetThree extends WidgetBase
{
    use LanguageFallbackForWidgetBuilder;

    public function admin_render()
    {
        // TODO: Implement admin_render() method.
        $output = $this->admin_form_before();
        $output .= $this->admin_form_start();
        $output .= $this->default_fields();
        $widget_saved_values = $this->get_settings();

        $output .= Text::get([
            'name' => 'title',
            'label' => __('Widget Title'),
            'value' => $widget_saved_values['title'] ?? null,
        ]);

        //end multi langual tab option
        $navigation_menus = Menu::all()->pluck('title','id')->toArray();

        $output .= Select::get([
            'name' => 'menu_id',
            'label' => __('Menu'),
            'options' => $navigation_menus,
            'value' => $widget_saved_values['menu_id'] ?? null,
        ]);

        $output .= $this->admin_form_submit_button();
        $output .= $this->admin_form_end();
        $output .= $this->admin_form_after();

        return $output;
    }

    public function frontend_render()
    {
        // TODO: Implement frontend_render() method.
        $widget_title = esc_html($this->setting_item('title') ?? '');
        $menu_id = $this->setting_item('menu_id') ?? '';

        $output = $this->widget_before(); //render widget before content

        $output .= '<h6 class="widget-title"> '.$widget_title.' </h6>
                    <div class="footer-inner margin-top-30">
                       <ul class="footer-link-list">
                           '.render_frontend_menu($menu_id).'
                       </ul>
                    </div>';

        $output .= $this->widget_after(); // render widget after content

        return $output;
    }


    public function enable(): bool
    {
        return !is_null(tenant());
    }

    public function widget_title()
    {
        // TODO: Implement widget_title() method.
        return __('Tenant Navigation Menu: Casual');
    }
}
