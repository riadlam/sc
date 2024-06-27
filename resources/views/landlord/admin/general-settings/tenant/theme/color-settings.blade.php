@php
    $theme_data = getSelectedThemeData();
    $theme_name = theme_custom_name($theme_data);
    $theme_slug = $theme_data->slug;
@endphp

<div class="col">
    <h4 class="my-4">{{__('Theme - '. $theme_name)}}</h4>

    <x-colorpicker.input value="{{get_static_option('main_color_one_'.$theme_slug,'#ff805d')}}" name="main_color_one_{{$theme_slug}}" label="{{__('Site Main Color One')}}"/>
    <x-colorpicker.input value="{{get_static_option('main_color_two_'.$theme_slug,'#ff805d')}}" name="main_color_two_{{$theme_slug}}" label="{{__('Site Main Color Two')}}"/>
    <x-colorpicker.input value="{{get_static_option('main_color_three_'.$theme_slug,'#599a8d')}}" name="main_color_three_{{$theme_slug}}" label="{{__('Site Main Color Three')}}"/>
    <x-colorpicker.input value="{{get_static_option('main_color_four_'.$theme_slug,'#1e88e5')}}" name="main_color_four_{{$theme_slug}}" label="{{__('Site Main Color Four')}}"/>

    <x-colorpicker.input value="{{get_static_option('secondary_color_'.$theme_slug,'#F7A3A8')}}" name="secondary_color_{{$theme_slug}}" label="{{__('Site Secondary Color One')}}"/>
    <x-colorpicker.input value="{{get_static_option('secondary_color_two_'.$theme_slug,'#ffdcd2')}}" name="secondary_color_two_{{$theme_slug}}" label="{{__('Site Secondary Color Two')}}"/>

    <x-colorpicker.input value="{{get_static_option('section_bg_1_'.$theme_slug,'#FFFBFB')}}" name="section_bg_1_{{$theme_slug}}" label="{{__('Section Background Color One')}}"/>
    <x-colorpicker.input value="{{get_static_option('section_bg_2_'.$theme_slug,'#FFF6EE')}}" name="section_bg_2_{{$theme_slug}}" label="{{__('Section Background Color Two')}}"/>
    <x-colorpicker.input value="{{get_static_option('section_bg_3_'.$theme_slug,'#F4F8FB')}}" name="section_bg_3_{{$theme_slug}}" label="{{__('Section Background Color Three')}}"/>
    <x-colorpicker.input value="{{get_static_option('section_bg_4_'.$theme_slug,'#F2F3FB')}}" name="section_bg_4_{{$theme_slug}}" label="{{__('Section Background Color Four')}}"/>
    <x-colorpicker.input value="{{get_static_option('section_bg_5_'.$theme_slug,'#F9F5F2')}}" name="section_bg_5_{{$theme_slug}}" label="{{__('Section Background Color Five')}}"/>
    <x-colorpicker.input value="{{get_static_option('section_bg_6_'.$theme_slug,'#E5EFF8')}}" name="section_bg_6_{{$theme_slug}}" label="{{__('Section Background Color Six')}}"/>

    <x-colorpicker.input value="{{get_static_option('breadcrumb_bg_'.$theme_slug,'#E5EFF8')}}" name="breadcrumb_bg_{{$theme_slug}}" label="{{__('Breadcrumb Background Color')}}"/>

    <x-colorpicker.input value="{{get_static_option('feedback_bg_item_'.$theme_slug,'#333333')}}" name="feedback_bg_item_{{$theme_slug}}" label="{{__('Feedback Color')}}"/>

    <x-colorpicker.input value="{{get_static_option('heading_color_'.$theme_slug,'#333333')}}" name="heading_color_{{$theme_slug}}" label="{{__('Site Heading Color')}}"/>

    <x-colorpicker.input value="{{get_static_option('body_color_'.$theme_slug,'#666666')}}" name="body_color_{{$theme_slug}}" label="{{__('Site Body Color')}}"/>

    <x-colorpicker.input value="{{get_static_option('light_color_'.$theme_slug,'#666666')}}" name="light_color_{{$theme_slug}}" label="{{__('Site Light Color')}}"/>
    <x-colorpicker.input value="{{get_static_option('extra_light_color_'.$theme_slug,'#888888')}}" name="extra_light_color_{{$theme_slug}}" label="{{__('Site Extra Light Color')}}"/>

    <x-colorpicker.input value="{{get_static_option('review_color_'.$theme_slug,'#FABE50')}}" name="review_color_{{$theme_slug}}" label="{{__('Site Review Color')}}"/>

    <x-colorpicker.input value="{{get_static_option('new_color_'.$theme_slug,'#5AB27E')}}" name="new_color_{{$theme_slug}}" label="{{__('Site New Color')}}"/>
</div>

