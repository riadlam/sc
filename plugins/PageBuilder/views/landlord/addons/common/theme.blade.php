@php
    if (str_contains($data['title'], '{h}') && str_contains($data['title'], '{/h}'))
    {
        $text = explode('{h}',$data['title']);

        $highlighted_word = explode('{/h}', $text[1])[0];

        $highlighted_text = '<span class="section-shape title-shape">'. $highlighted_word .'</span>';
        $final_title = '<h1 class="title">'.str_replace('{h}'.$highlighted_word.'{/h}', $highlighted_text, $data['title']).'</h1>';
    } else {
        $final_title = '<h1 class="title">'. $data['title'] .'</h1>';
    }
@endphp

<section class="themes-area section-bg-1" data-padding-top="{{$data['padding_top']}}"
         data-padding-bottom="{{$data['padding_bottom']}}" id="{{$data['section_id']}}">
    <div class="theme-shape">
        {!! render_image_markup_by_attachment_id($data['bg_shape_image']) !!}
    </div>
    <div class="container">
        <div class="section-title">
            {!! $final_title !!}
            <p class="section-para"> {{$data['subtitle']}} </p>
        </div>
        <div class="row mt-4">

            @foreach(getAllThemeData() as $index => $theme)
                @php
                    $theme_slug = $theme->slug;
                    $theme_data = getIndividualThemeDetails($theme_slug);
                    $theme_image = loadScreenshot($theme_slug);

                    $theme_custom_name = get_static_option_central($theme_data['slug'].'_theme_name');
                    $theme_custom_url = get_static_option_central($theme_data['slug'].'_theme_url');
                    $custom_theme_image = get_static_option_central($theme_data['slug'].'_theme_image');
                @endphp

                <div class="col-lg-4 col-sm-6 mt-4">
                    <div class="single-themes">
                        <div class="single-themes-thumb">
                            <a href="{{$theme_custom_url}}" target="_blank">
                                <img src="{{ !empty($custom_theme_image) ? $custom_theme_image : $theme_image}}" alt="">
                            </a>
                        </div>
                        <div class="single-themes-content mt-3">
                            <div class="single-themes-content-flex">
                                <h3 class="single-themes-content-title">
                                    <a href="{{$theme_custom_url}}"> {{!empty($theme_custom_name) ? $theme_custom_name : $theme_data['name']}} </a>
                                </h3>
                                <a href="{{$theme_custom_url}}" class="single-themes-content-title-icon"
                                   target="_blank">
                                    <i class="las la-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach

            @if(get_static_option('up_coming_themes_frontend'))
                @foreach(range(4, 14) as $item)
                    @if($item == 4)
                        @php
                            $base_url = URL::to('/');
                            $base_url = str_replace(['http://','https://'], '', $base_url);
                        @endphp
                        @if($base_url == 'novacommerce.net' || $base_url == 'novacommerce-test.test')
                            <div class="col-lg-4 col-sm-6 mt-4">
                                <div class="single-themes">
                                    <div class="single-themes-thumb">
                                        <a href="http://zamila.novacommerce.net" target="_blank">
                                            <img class="rounded"
                                                 src="{{global_asset('assets/img/theme/th-zamila.jpg')}}" alt="">
                                        </a>
                                    </div>
                                    <div class="single-themes-content mt-3">
                                        <div class="single-themes-content-flex">
                                            <h3 class="single-themes-content-title">
                                                {{__('Zamila - Arabic Version')}}
                                            </h3>
                                            <a href="javascript:void(0)" class="single-themes-content-title-icon">
                                                <i class="las la-arrow-right"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @else
                        <div class="col-lg-4 col-sm-6 mt-4">
                            <div class="single-themes">
                                <div class="single-themes-thumb coming_soon">
                                    <a href="javascript:void(0)">
                                        <img class="rounded" src="{{get_theme_image('theme-'.$item)}}" alt="">
                                    </a>
                                    <div class="coming-soon-theme">{{__('Coming Soon')}}</div>
                                </div>
                                <div class="single-themes-content mt-3">
                                    <div class="single-themes-content-flex">
                                        <h3 class="single-themes-content-title">
                                            {{__('Theme')}} {{$item}}
                                        </h3>
                                        <a href="javascript:void(0)" class="single-themes-content-title-icon">
                                            <i class="las la-arrow-right"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
            @endif
        </div>
    </div>
</section>
