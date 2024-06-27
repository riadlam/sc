@include('tenant.frontend.partials.header')

@php
    $current_theme_slug = getSelectedThemeSlug();
    $breadcrumb_area_name = getHeaderBreadcrumbArea();

    $breadcrumb_view = 'themes.'.$current_theme_slug.'.headerBreadcrumbArea.'.$breadcrumb_area_name;
@endphp

@if(!empty(getHeaderBreadcrumbArea()))
    @include($breadcrumb_view)
@else
    <div class="breadcrumb-area breadcrumb-padding-two breadcrumb-bg
    @if((in_array(request()->route()->getName(),['tenant.frontend.homepage','tenant.dynamic.page']) && !empty($page_post) && $page_post->breadcrumb == 0 ))
        d-none
    @endif
">
        <div class="container container-one">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb-contents center-text">
                        <h1 class="breadcrumb-contents-title-two fw-500"> @yield('page-title') </h1>
                        <ul class="breadcrumb-contents-list mt-2">
                            <li class="breadcrumb-contents-list-item"><a
                                    href="{{route('tenant.frontend.homepage')}}">{{__('Home')}}</a></li>
                            @if(Route::currentRouteName() === 'tenant.dynamic.page')
                                <li class="breadcrumb-contents-list-item"><a
                                        href="#">{!! $page_post->title ?? '' !!}</a></li>
                            @else
                                <li class="breadcrumb-contents-list-item">@yield('page-title')</li>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif

{!! \App\Facades\ThemeDataFacade::renderHeaderHookBladeFile() !!}

@yield('content')
@include('tenant.frontend.partials.footer')
