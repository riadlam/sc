<!-- Banner area Starts -->
<div class="banner-area" data-padding-top="{{$data['padding_top']}}"
     data-padding-bottom="{{$data['padding_bottom']}}">
    <div class="container custom-container-one">
        <div class="row align-items-center justify-content-center">
            <div class="col-lg-6">
                <div class="banner-content-wrapper">
                    <div class="banner-single">
                        <div class="banner-single-content">
                            <h2 class="banner-single-content-title fw-600"> {{$data['title']}} </h2>
                            <p class="banner-single-content-para mt-3"> {{$data['description']}} </p>
                            <div class="btn-wrapper">
                                <a href="{{$data['button_url']}}" class="cmn-btn cmn-btn-bg-1 radius-0 mt-4 mt-lg-5"> {{$data['button_text']}} </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                @php
                    $background_image = get_attachment_image_by_id($data['background_image']);
                    $background_image_url = !empty($background_image) ? $background_image['img_url'] : '';
                @endphp
                <div class="banner-image-wrappers bg-image" style="background-image: url({{$background_image_url}});">
                    <div class="banner-book-thumb">
                        <div class="single-book">
                            {!! render_image_markup_by_attachment_id($data['foreground_image_bottom']) !!}
                        </div>
                        <div class="single-book">
                            {!! render_image_markup_by_attachment_id($data['foreground_image_middle']) !!}
                        </div>
                        <div class="single-book">
                            {!! render_image_markup_by_attachment_id($data['foreground_image_top']) !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Banner area end -->
