@php
    $current_theme_slug = getSelectedThemeSlug();
    $navbar_area_name = getHeaderNavbarArea();

    $navbar_view = 'themes.'.$current_theme_slug.'.headerNavbarArea.'.$navbar_area_name;
@endphp

@if(View::exists($navbar_view))
    @include($navbar_view)
@else
    @include('tenant.frontend.partials.pages-portion.navbars.navbar-01')
@endif
