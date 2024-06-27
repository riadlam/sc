<!-- Client Logo area Starts -->
<div class="clent-logo-area body-bg-2" data-padding-top="{{$data['padding_top']}}" data-padding-bottom="{{$data['padding_bottom']}}">
    <div class="container-three">
        <div class="row">
            <div class="col-lg-12">
                <div class="global-slick-init client-logo-slider dot-style-one dot-color-three dot-01 slider-inner-margin" data-infinite="true" data-dots="true" data-slidesToShow="5" data-swipeToSlide="true" data-autoplay="true" data-autoplaySpeed="2500" data-responsive='[{"{"breakpoint": 1200,"settings": {"slidesToShow": 4}},{"breakpoint": 992,"settings": {"slidesToShow": 3}},{"breakpoint": 768, "settings": {"slidesToShow": 2} }]'
                     data-rtl="{{get_user_lang_direction() == 1 ? 'true' : 'false'}}">
                    @foreach($data['brands'] as $brand)
                        <div class="slingle-client padding-0 style-03">
                            <a href="javascript:void(0)">
                                {!! render_image_markup_by_attachment_id($brand->image_id) !!}
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Client Logo area end -->
