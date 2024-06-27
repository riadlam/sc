<!-- Instagram area Starts -->
<div class="instagram-area body-bg-2" data-padding-top="{{$data['padding_top']}}"
     data-padding-bottom="{{$data['padding_bottom']}}">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="instagram-wrapper">
                    <div class="instagram-contents bg-white">
                        @php
                            $instagram_data = !empty($data['instagram_data']) ? $data['instagram_data']->data : [];
                            $single_data = !empty($instagram_data) ? current($instagram_data) : [];
                            $username = $single_data->username ?? '';

                            $account_link = !empty($username) ? 'https://instagram.com/'.$username : '#';
                        @endphp
                        <a href="{{$account_link}}" class="icon color-three"> <i class="lab la-instagram"></i> </a>
                        <h6 class="instagram-title ff-playfair fw-400"><a
                                href="javascript:void(0)"> {{$data['title'] ?? ''}} </a></h6>
                    </div>
                    <div
                        class="global-slick-init instagram-slider dot-style-one dot-color-three dot-02 slider-inner-margin-10"
                        data-infinite="true" data-dots="false" data-swipeToSlide="true" data-autoplaySpeed="3000"
                        data-autoplay="true" data-slidesToShow="6"
                        data-responsive='[{"breakpoint": 1400,"settings": {"slidesToShow": 5}},{"breakpoint": 1200,"settings": {"slidesToShow": 4}},{"breakpoint": 992,"settings": {"dots": true,"slidesToShow": 3}},{"breakpoint": 768, "settings": {"slidesToShow": 2} }]'>
                        @foreach($data['instagram_data']->data ?? [] as $item)
                            @continue($item->media_type == 'VIDEO')
                            <div class="single-instagram">
                                <div class="instagram-image">
                                    <a href="{{$item->permalink}}" {{!empty($data['media_redirection']) ? 'target="blank"' : ''}}>
                                        <img class="lazyloads" src="{{$item->media_url}}" alt="">
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Instagram area end -->
