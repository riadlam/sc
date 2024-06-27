@php
    $current_theme_slug = getSelectedThemeSlug();
    $widget_area_name = getFooterWidgetArea();

//    $footer_view = 'tenant.frontend.partials.pages-portion.footers.footer-'.$current_theme_slug.'';
    $footer_view = 'themes.'.$current_theme_slug.'.footerWidgetArea.'.$widget_area_name;
@endphp

@if(View::exists($footer_view))
    @include($footer_view)
@else
    @include('tenant.frontend.partials.pages-portion.footers.footer-medicom')
@endif
