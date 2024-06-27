
<section class="collection-area" data-padding-top="{{$data['padding_top']}}" data-padding-bottom="{{$data['padding_bottom']}}">
    <div class="container container-one">
        <div class="collection-wrapper">
            <div class="row gy-4">
                @foreach($data['repeater_data']['repeater_title_'] ?? [] as $key => $title)
                    @php
                        $class = $loop->odd ? ['col-xl-5 col-lg-6', ''] : ['col-xl-7 col-lg-6', 'flex-row-reverse'];
                    @endphp

                    <div class="{{current($class)}}">
                        <div class="single-collection-two collection-padding section-bg-4" style="background-color: {{$data['repeater_data']['repeater_background_color_'][$key] ?? ''}}">
                            <div class="single-collection-two-flex {{last($class)}} d-flex align-items-center">
                                <div class="single-collection-two-contents">
                                    <h3 class="single-collection-two-contents-title  fw-500">
                                        <a href="{{$data['repeater_data']['repeater_button_url_'][$key]}}">
                                            @php
                                                    $markup = \App\Helpers\SanitizeInput::esc_html($title);
                                                    if (!empty($data['repeater_data']['repeater_break_text_'][$key]))
                                                    {
                                                        $title_exploded = explode(' ', $markup);
                                                        if (count($title_exploded) > 1)
                                                        {
                                                            $first = current($title_exploded);
                                                            unset($title_exploded[0]);
                                                            $rest = implode(' ', $title_exploded);
                                                            $markup = $first . '<span class="single-collection-two-contents-title-block">'. $rest .'</span>';
                                                        }
                                                    }
                                            @endphp

                                            {!! $markup !!}
                                        </a>
                                    </h3>
                                    <a href="{{$data['repeater_data']['repeater_button_url_'][$key]}}" class="shop-now-btn shop-now-border mt-4"> {{\App\Helpers\SanitizeInput::esc_html($data['repeater_data']['repeater_button_text_'][$key] ?? '')}} </a>
                                </div>
                                <div class="single-collection-two-thumb">
                                    {!! render_image_markup_by_attachment_id($data['repeater_data']['repeater_image_'][$key]) !!}
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>
