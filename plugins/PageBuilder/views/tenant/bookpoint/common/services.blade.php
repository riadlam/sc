<!-- Promo area Starts -->
<section class="promo-area section-bg-1 padding-bottom-50 padding-top-25" data-padding-top="{{$data['padding_top']}}" data-padding-bottom="{{$data['padding_bottom']}}">
    <div class="container custom-container-one">
        <div class="row">
            @foreach($data['repeater_data']['repeater_title_'] ?? [] as $key => $title)
                <div class="col-xxl-3 col-xl-4 col-md-6 mt-4">
                <div class="single-promo center-text promo-padding">
                    <div class="single-promo-icon">
                        <i class="{{$data['repeater_data']['repeater_icon_'][$key] ?? ''}}"></i>
                    </div>
                    <div class="single-promo-contents mt-2">
                        <h4 class="single-promo-contents-title fw-500"> <a href="javascript:void(0)"> {{\App\Helpers\SanitizeInput::esc_html($title)}} </a> </h4>
                        <p class="single-promo-contents-para mt-2"> {{\App\Helpers\SanitizeInput::esc_html($data['repeater_data']['repeater_subtitle_'][$key]) ?? ''}} </p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
<!-- Promo area end -->
