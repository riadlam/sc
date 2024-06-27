<?php


namespace Plugins\PageBuilder;

use App\Helpers\ModuleMetaData;
use App\Models\PageBuilder;
use Plugins\PageBuilder\Addons\Landlord\Blog\BlogSliderOne;
use Plugins\PageBuilder\Addons\Landlord\Blog\BlogStyleOne;
use Plugins\PageBuilder\Addons\Landlord\Common\Brand;
use Plugins\PageBuilder\Addons\Landlord\Common\ContactArea;
use Plugins\PageBuilder\Addons\Landlord\Common\ContactCards;
use Plugins\PageBuilder\Addons\Landlord\Common\FaqOne;
use Plugins\PageBuilder\Addons\Landlord\Common\Feedback;
use Plugins\PageBuilder\Addons\Landlord\Common\HowItWorks;
use Plugins\PageBuilder\Addons\Landlord\Common\Newsletter;
use Plugins\PageBuilder\Addons\Landlord\Common\NumberCounter;
use Plugins\PageBuilder\Addons\Landlord\Common\PricePlan;
use Plugins\PageBuilder\Addons\Landlord\Common\RawHTML;
use Plugins\PageBuilder\Addons\Landlord\Common\TemplateDesign;
use Plugins\PageBuilder\Addons\Landlord\Common\Themes;
use Plugins\PageBuilder\Addons\Landlord\Common\WhyChooseUs;
use Plugins\PageBuilder\Addons\Landlord\Header\AboutHeaderStyleOne;
use Plugins\PageBuilder\Addons\Landlord\Header\FeaturesStyleOne;
use Plugins\PageBuilder\Addons\Landlord\Header\HeaderStyleOne;
use Plugins\PageBuilder\Addons\Tenants\Aromatic\About\AboutImage;
use Plugins\PageBuilder\Addons\Tenants\Aromatic\Common\BrandTwo;
use Plugins\PageBuilder\Addons\Tenants\Aromatic\Common\InstagramWidget;
use Plugins\PageBuilder\Addons\Tenants\Aromatic\Product\BestProduct;
use Plugins\PageBuilder\Addons\Tenants\Bookpoint\Blog\RecentBlog;
use Plugins\PageBuilder\Addons\Tenants\Bookpoint\Common\TopAuthor;
use Plugins\PageBuilder\Addons\Tenants\Casual\Common\CampaignSale;
use Plugins\PageBuilder\Addons\Tenants\Casual\Common\Categories;
use Plugins\PageBuilder\Addons\Tenants\Casual\Product\PopularCollection;
use Plugins\PageBuilder\Addons\Tenants\Casual\Product\PopularProduct;
use Plugins\PageBuilder\Addons\Tenants\Furnito\Product\TrendingProducts;
use Plugins\PageBuilder\Addons\Tenants\Hexfashion\Contact\ContactAreaOne;
use Plugins\PageBuilder\Addons\Tenants\Hexfashion\Contact\GoogleMap;
use Plugins\PageBuilder\Addons\Tenants\Medicom\Header\Header;
use Plugins\PageBuilder\Addons\Tenants\Service\ServiceOne;
use Plugins\PageBuilder\Addons\Tenants\Hexfashion\Common\CollectionArea;
use Plugins\PageBuilder\Addons\Tenants\Hexfashion\Common\DealArea;
use Plugins\PageBuilder\Addons\Tenants\Hexfashion\Common\Services;
use Plugins\PageBuilder\Addons\Tenants\Hexfashion\Common\Testimonial;
use Plugins\PageBuilder\Addons\Tenants\Hexfashion\Common\TestimonialTwo;
use Plugins\PageBuilder\Addons\Tenants\Hexfashion\Common\Team;
use Plugins\PageBuilder\Addons\Tenants\Hexfashion\Header\HeaderOne;
use Plugins\PageBuilder\Addons\Tenants\Hexfashion\Product\FeaturedProductSlider;
use Plugins\PageBuilder\Addons\Tenants\Hexfashion\Product\FlashStore;
use Plugins\PageBuilder\Addons\Tenants\Hexfashion\Product\ProductTypeList;
use Plugins\PageBuilder\Addons\Tenants\Hexfashion\About\AboutStory;
use Plugins\PageBuilder\Addons\Tenants\Hexfashion\About\AboutCounter;
use Plugins\PageBuilder\Addons\Tenants\Furnito\Blog\BlogOne;
use Plugins\PageBuilder\Addons\Tenants\Furnito\Common\CategoriesSlider;
use Plugins\PageBuilder\Addons\Tenants\Furnito\Common\CollectionCard;
use Plugins\PageBuilder\Addons\Tenants\Furnito\Product\NewCollection;


class PageBuilderSetup
{
    private static function registerd_widgets(): array
    {
        $customAddons = [];
        $addons = [];

        if (!is_null(tenant()))
        {
            $theme = tenant()->theme_slug;

            // Tenant Register

            if ($theme == 'hexfashion')
            {
                // Theme Hexfashion
                $addons = [
                    HeaderOne::class,
                    Addons\Tenants\Hexfashion\Blog\BlogOne::class,
                    Addons\Tenants\Hexfashion\Common\Brand::class,
                    DealArea::class,
                    ContactAreaOne::class,
                    GoogleMap::class,
                    ServiceOne::class,
                    CollectionArea::class,
                    FeaturedProductSlider::class,
                    ProductTypeList::class,
                    FlashStore::class,
                    Services::class,
                    Testimonial::class,
                    TestimonialTwo::class,
                    AboutStory::class,
                    AboutCounter::class,
                    Team::class,
                ];
            } elseif ($theme == 'furnito') {
                // Theme Furnito
                $addons = [
                    \Plugins\PageBuilder\Addons\Tenants\Furnito\Header\HeaderOne::class,
                    CollectionCard::class,
                    TrendingProducts::class,
                    CategoriesSlider::class,
                    \Plugins\PageBuilder\Addons\Tenants\Furnito\Common\Brand::class,
                    \Plugins\PageBuilder\Addons\Tenants\Furnito\Common\Testimonial::class,
                    \Plugins\PageBuilder\Addons\Tenants\Furnito\Common\Services::class,
                    \Plugins\PageBuilder\Addons\Tenants\Furnito\Common\CollectionArea::class,
                    \Plugins\PageBuilder\Addons\Tenants\Furnito\Product\ProductTypeList::class,
                    \Plugins\PageBuilder\Addons\Tenants\Furnito\Contact\ContactAreaOne::class,
                    \Plugins\PageBuilder\Addons\Tenants\Furnito\Contact\GoogleMap::class,
                    BlogOne::class,
                    \Plugins\PageBuilder\Addons\Tenants\Furnito\About\AboutStory::class,
                    \Plugins\PageBuilder\Addons\Tenants\Furnito\About\AboutCounter::class
                ];
            } elseif ($theme == 'medicom') {
                // Theme Medicom
                $addons = [
                    Header::class,
                    \Plugins\PageBuilder\Addons\Tenants\Medicom\Common\Services::class,
                    \Plugins\PageBuilder\Addons\Tenants\Medicom\Product\FeaturedProductSlider::class,
                    \Plugins\PageBuilder\Addons\Tenants\Medicom\Product\CategoriesSlider::class,
                    \Plugins\PageBuilder\Addons\Tenants\Medicom\Common\CollectionCard::class,
                    \Plugins\PageBuilder\Addons\Tenants\Medicom\Product\ProductTypeList::class,
                    \Plugins\PageBuilder\Addons\Tenants\Hexfashion\Common\Brand::class,
                    ContactAreaOne::class,
                ];
            } elseif($theme == 'bookpoint') {
                $addons = [
                    \Plugins\PageBuilder\Addons\Tenants\Bookpoint\Header\Header::class,
                    \Plugins\PageBuilder\Addons\Tenants\Bookpoint\Product\ProductTypeList::class,
                    \Plugins\PageBuilder\Addons\Tenants\Bookpoint\Product\PhysicalProductTypeList::class,
                    \Plugins\PageBuilder\Addons\Tenants\Bookpoint\Common\CollectionCard::class,
                    TopAuthor::class,
                    RecentBlog::class,
                    \Plugins\PageBuilder\Addons\Tenants\Bookpoint\Common\Services::class,
                    \Plugins\PageBuilder\Addons\Tenants\Bookpoint\Product\FeaturedProductSlider::class,
                    \Plugins\PageBuilder\Addons\Tenants\Bookpoint\Product\FeaturedPhysicalProductSlider::class,

                    //temporary addons
                    \Plugins\PageBuilder\Addons\Tenants\Furnito\About\AboutCounter::class,
                    \Plugins\PageBuilder\Addons\Tenants\Furnito\About\AboutStory::class,
                    \Plugins\PageBuilder\Addons\Tenants\Furnito\Common\Testimonial::class,
                    \Plugins\PageBuilder\Addons\Tenants\Furnito\Common\Services::class,
                    ContactAreaOne::class,
                ];
            } elseif($theme == 'aromatic') {
                $addons = [
                    \Plugins\PageBuilder\Addons\Tenants\Aromatic\Header\HeaderOne::class,
                    \Plugins\PageBuilder\Addons\Tenants\Aromatic\Product\NewCollection::class,
                    BestProduct::class,
                    \Plugins\PageBuilder\Addons\Tenants\Aromatic\Product\ProductTypeList::class,
                    \Plugins\PageBuilder\Addons\Tenants\Aromatic\Common\Brand::class,
                    BrandTwo::class,
                    InstagramWidget::class,
                    AboutImage::class,
                    \Plugins\PageBuilder\Addons\Tenants\Aromatic\Common\Services::class,
                    \Plugins\PageBuilder\Addons\Tenants\Aromatic\Contact\GoogleMap::class,
                    \Plugins\PageBuilder\Addons\Tenants\Aromatic\Contact\ContactArea::class
                ];
            } elseif($theme == 'casual') {
                $addons = [
                    \Plugins\PageBuilder\Addons\Tenants\Casual\Header\Header::class,
                    Categories::class,
                    PopularCollection::class,
                    \Plugins\PageBuilder\Addons\Tenants\Casual\Product\ProductTypeList::class,
                    CampaignSale::class,
                    \Plugins\PageBuilder\Addons\Tenants\Casual\Product\FlashStore::class,
                    \Plugins\PageBuilder\Addons\Tenants\Casual\Blog\BlogOne::class,
                    \Plugins\PageBuilder\Addons\Tenants\Casual\Common\Brand::class
                ];
            }

            // Global addons for all theme
            $globalAddons = [
                RawHTML::class
            ];

            foreach ($globalAddons as $globalItem)
            {
                array_push($addons, $globalItem);
            }

            // Third party custom addons
            $customAddons = (new ModuleMetaData())->getPageBuilderAddonList();
        } else {
            //Admin Register
            $addons = [
                HeaderStyleOne::class,
                FeaturesStyleOne::class,
                Themes::class,
                HowItWorks::class,
                WhyChooseUs::class,
                TemplateDesign::class,
                PricePlan::class,
                Feedback::class,
                FaqOne::class,
                ContactArea::class,
                BlogSliderOne::class,
                NumberCounter::class,
                Newsletter::class,
                AboutHeaderStyleOne::class,
                ContactCards::class,
                BlogStyleOne::class,
                RawHTML::class
            ];
        }

        //check module wise widget by set condition
        return array_merge($addons, $customAddons);
    }

    public static function get_tenant_admin_panel_widgets(): string
    {
        $widgets_markup = '';
        $widget_list = self::tenant_registerd_widgets();
        foreach ($widget_list as $widget) {
            try {
                $widget_instance = new  $widget();
            } catch (\Exception $e) {
                $msg = $e->getMessage();
                throw new \ErrorException($msg);
            }

            if ($widget_instance->enable()) {
                $widgets_markup .= self::render_admin_addon_item([
                    'addon_name' => $widget_instance->addon_name(),
                    'addon_namespace' => $widget_instance->addon_namespace(), // new added
                    'addon_title' => $widget_instance->addon_title(),
                    'preview_image' => $widget_instance->get_preview_image($widget_instance->preview_image())
                ]);
            }
        }
        return $widgets_markup;
    }

    public static function get_admin_panel_widgets(): string
    {
        $widgets_markup = '';
        $widget_list = self::registerd_widgets();
        foreach ($widget_list as $widget) {
            try {
                $widget_instance = new  $widget();
            } catch (\Exception $e) {
                $msg = $e->getMessage();
                throw new \ErrorException($msg);
            }

            if ($widget_instance->enable()) {
                $widgets_markup .= self::render_admin_addon_item([
                    'addon_name' => $widget_instance->addon_name(),
                    'addon_namespace' => $widget_instance->addon_namespace(), // new added
                    'addon_title' => $widget_instance->addon_title(),
                    'preview_image' => $widget_instance->get_preview_image($widget_instance->preview_image())
                ]);
            }
        }
        return $widgets_markup;
    }

    private static function render_admin_addon_item($args): string
    {
        return '<li class="ui-state-default widget-handler" data-name="' . $args['addon_name'] . '" data-namespace="' . base64_encode($args['addon_namespace']) . '" >
                    <h4 class="top-part"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span>' . $args['addon_title'] . $args['preview_image'] . '</h4>
                </li>';
    }

    public static function render_widgets_by_name_for_admin($args)
    {
        $widget_class = $args['namespace'];
        if (class_exists($widget_class))
        {
            $instance = new $widget_class($args);
            if ($instance->enable()) {
                return $instance->admin_render();
            }
        }
    }

    public static function render_widgets_by_name_for_frontend($args)
    {
        $widget_class = $args['namespace'];
        if(class_exists($widget_class))
        {
            $instance = new $widget_class($args);
            if ($instance->enable()) {
                return $instance->frontend_render();
            }
        }
    }

    public static function render_frontend_pagebuilder_content_by_location($location): string
    {
        $output = '';
        $all_widgets = PageBuilder::where(['addon_location' => $location])->orderBy('addon_order', 'ASC')->get();
        foreach ($all_widgets as $widget) {
            $output .= self::render_widgets_by_name_for_frontend([
                'name' => $widget->addon_name,
                'namespace' => $widget->addon_namespace,
                'location' => $location,
                'id' => $widget->id,
                'column' => $args['column'] ?? false
            ]);
        }
        return $output;
    }

    public static function get_saved_addons_by_location($location): string
    {
        $output = '';
        $all_widgets = PageBuilder::where(['addon_location' => $location])->orderBy('addon_order', 'asc')->get();
        foreach ($all_widgets as $widget) {
            $output .= self::render_widgets_by_name_for_admin([
                'name' => $widget->addon_name,
                'namespace' => $widget->addon_namespace,
                'id' => $widget->id,
                'type' => 'update',
                'order' => $widget->addon_order,
                'page_type' => $widget->addon_page_type,
                'page_id' => $widget->addon_page_id,
                'location' => $widget->addon_location
            ]);
        }

        return $output;
    }

    public static function get_saved_addons_for_dynamic_page($page_type, $page_id): string
    {
        $output = '';
        $all_widgets = \Cache::remember('page_id-'.$page_id, 60*60*24, function () use ($page_type, $page_id) {
            return PageBuilder::where(['addon_page_type' => $page_type, 'addon_page_id' => $page_id])->orderBy('addon_order', 'asc')->get();
        });

        foreach ($all_widgets as $widget) {
            $output .= self::render_widgets_by_name_for_admin([
                'name' => $widget->addon_name,
                'namespace' => $widget->addon_namespace,
                'id' => $widget->id,
                'type' => 'update',
                'order' => $widget->addon_order,
                'page_type' => $widget->addon_page_type,
                'page_id' => $widget->addon_page_id,
                'location' => $widget->addon_location
            ]);
        }

        return $output;
    }

    public static function render_frontend_pagebuilder_content_for_dynamic_page($page_type, $page_id): string
    {
        $output = '';
        $all_widgets = \Cache::remember('page_id-'.$page_id, 24*60*60, function () use ($page_type, $page_id) {
            return PageBuilder::where(['addon_page_type' => $page_type, 'addon_page_id' => $page_id])->orderBy('addon_order', 'asc')->get();
        });

        foreach ($all_widgets as $widget) {
            $output .= self::render_widgets_by_name_for_frontend([
                'name' => $widget->addon_name,
                'namespace' => $widget->addon_namespace,
                'id' => $widget->id,
                'column' => $args['column'] ?? false
            ]);
        }
        return $output;
    }
}
