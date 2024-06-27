<section class="promo-area" data-padding-top="{{$data['padding_top']}}" data-padding-bottom="{{$data['padding_bottom']}}">
    <div class="container">
        <div class="row gy-5 promo-inner-border">
            @php
                $index = 1;
            @endphp
            @foreach($data['repeater_data']['repeater_title_'] ?? [] as $key => $title)
                <div class="col-lg-4 col-md-6">
                <div class="single-promo theme-three-padding">
                    <div class="single-promo-flex">
                        <div class="single-promo-icon">
                            <span> {{$index++}} </span>
                        </div>
                        <div class="single-promo-contents mt-2">
                            <h4 class="single-promo-contents-title fw-400">
                                <a href="javascript:void(0)"> {{\App\Helpers\SanitizeInput::esc_html($title)}} </a>
                            </h4>
                            <p class="single-promo-contents-para mt-2"> {{\App\Helpers\SanitizeInput::esc_html($data['repeater_data']['repeater_subtitle_'][$key]) ?? ''}} </p>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
