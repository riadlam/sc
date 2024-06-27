<!-- Blog area start -->
<section class="blog-area padding-top-50 padding-bottom-100" data-padding-top="{{$data['padding_top']}}" data-padding-bottom="{{$data['padding_bottom']}}">
    <div class="container custom-container-one">
        <div class="section-title text-left">
            <h2 class="title"> {{$data['title'] ?? ''}} </h2>
            <div class="append-news"></div>
        </div>
        <div class="row mt-4">
            <div class="col-lg-12 mt-4">
                <div class="global-slick-init recent-slider nav-style-one slider-inner-margin" data-appendArrows=".append-news" data-infinite="true" data-arrows="true" data-dots="false" data-slidesToShow="3" data-swipeToSlide="true" data-autoplay="true" data-autoplaySpeed="2500"
                     data-prevArrow='<div class="prev-icon"><i class="las la-angle-left"></i></div>' data-nextArrow='<div class="next-icon"><i class="las la-angle-right"></i></div>' data-responsive='[{"breakpoint": 1500,"settings": {"slidesToShow": 3}},{"breakpoint": 1400,"settings": {"slidesToShow": 3}},{"breakpoint": 1200,"settings": {"slidesToShow": 2}},{"breakpoint": 992,"settings": {"slidesToShow": 2}},{"breakpoint": 768, "settings": {"slidesToShow": 1}}]'
                     data-rtl="{{get_user_lang_direction()}}">
                    @foreach($data['blogs'] ?? [] as $item)
                        <div class="slick-slider-item">
                        <div class="single-blog">
                            <div class="single-blog-thumb">
                                <a href="{{route('tenant.frontend.blog.single',$item->slug)}}">
                                    {!! render_image_markup_by_attachment_id($item->image) !!}
                                </a>
                            </div>
                            <div class="single-blog-contents mt-3">
                                <h3 class="single-blog-contents-title fw-600">
                                    <a href="{{route('tenant.frontend.blog.single',$item->slug)}}"> {{\App\Helpers\SanitizeInput::esc_html(Str::words($item->title, 10))}} </a>
                                </h3>
                                <p class="single-blog-contents-para mt-3"> {{\App\Helpers\SanitizeInput::esc_html(Str::words($item->blog_content, 18))}} </p>
                                <div class="btn-wrapper mt-4">
                                    <a href="{{route('tenant.frontend.blog.single',$item->slug)}}" class="cmn-btn cmn-btn-bg-1 cmn-btn-small radius-0"> {{$data['button_text'] ?? ''}} </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Blog area end -->
