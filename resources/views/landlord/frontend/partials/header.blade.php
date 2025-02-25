<!DOCTYPE html>
<html dir="{{ \App\Facades\GlobalLanguage::user_lang_dir() }}" lang="{{ \App\Facades\GlobalLanguage::user_lang_slug() }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @if(!empty(SEOMeta::generate()))
        {!! SEOMeta::generate() !!}
    @else
        <title>@yield('page-title')</title>
    @endif

    {!! OpenGraph::generate() !!}
    {!! Twitter::generate() !!}
    {!! JsonLd::generate() !!}

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="canonical" href="{{canonical_url()}}" />

    {!! load_google_fonts() !!}
    {!! render_favicon_by_id(get_static_option('site_favicon')) !!}

{{--    <title>--}}
{{--        @if(!request()->routeIs('landlord.homepage'))--}}
{{--            @yield('title')--}}
{{--            ---}}
{{--            {{get_static_option('site_title')}}--}}
{{--        @else--}}
{{--            {{get_static_option('site_title')}}--}}
{{--            @if(!empty(get_static_option('site_tag_line')))--}}
{{--                - {{get_static_option('site_tag_line')}}--}}
{{--            @endif--}}
{{--        @endif--}}
{{--    </title>--}}

    <link rel="stylesheet" href="{{global_asset('assets/landlord/frontend/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/landlord/frontend/css/animate.css')}}">
    <link rel="stylesheet" href="{{asset('assets/landlord/frontend/css/slick.css')}}">
    <link rel="stylesheet" href="{{asset('assets/landlord/frontend/css/nice-select.css')}}">
    <link rel="stylesheet" href="{{asset('assets/landlord/frontend/css/line-awesome.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/common/css/jquery.ihavecookies.css')}}">
    <link rel="stylesheet" href="{{asset('assets/landlord/frontend/css/odometer.css')}}">
    <link rel="stylesheet" href="{{asset('assets/landlord/frontend/css/common.css')}}">
    <link rel="stylesheet" href="{{global_asset('assets/common/css/loader.css')}}">
    <link rel="stylesheet" href="{{asset('assets/landlord/frontend/css/style.css')}}">
    <link rel="stylesheet" href="{{asset('assets/landlord/common/css/helpers.css')}}">

    <link rel="stylesheet" href="{{global_asset('assets/landlord/frontend/css/custom-style.css')}}">

    @if(\App\Facades\GlobalLanguage::user_lang_dir() == 'rtl')
        <link rel="stylesheet" href="{{asset('assets/landlord/frontend/css/rtl.css')}}">
    @endif

    @include('landlord.frontend.partials.color-font-variable')
    @yield('style')

    @yield('seo_data')

    @php
        $dynamic_style = 'assets/landlord/frontend/css/dynamic-style.css';
    @endphp
    @if(file_exists($dynamic_style))
        <link rel="stylesheet" href="{{asset($dynamic_style)}}">
    @endif

    @php
        $line_shape = get_static_option('highlight_text_shape');
        $highlighted_image = get_attachment_image_by_id($line_shape);
        $highlighted_image = !empty($highlighted_image) ? $highlighted_image['img_url'] : '';
    @endphp
    <style>
        .title-shape::before{
            background-image: url("{{$highlighted_image}}") !important;
        }
    </style>
</head>
<body>

@include('tenant.frontend.partials.loader')
@include('landlord.frontend.partials.navbar')

