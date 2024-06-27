@php
    $primary_image = get_attachment_image_by_id($data['primary_image']);
    $primary_image = !empty($primary_image) ? $primary_image['img_url'] : '';

    $particle_image_one = get_attachment_image_by_id($data['particle_image_one']);
    $particle_image_one = !empty($particle_image_one) ? $particle_image_one['img_url'] : theme_assets('img/shape1.png');

    $particle_image_two = get_attachment_image_by_id($data['particle_image_two']);
    $particle_image_two = !empty($particle_image_two) ? $particle_image_two['img_url'] : theme_assets('img/shape2.png');

    $particle_image_three =  get_attachment_image_by_id($data['particle_image_three']);
    $particle_image_three = !empty($particle_image_three) ? $particle_image_three['img_url'] : theme_assets('img/shape3.png');

    $particle_image_four = get_attachment_image_by_id($data['particle_image_four']);
    $particle_image_four = !empty($particle_image_four) ? $particle_image_four['img_url'] : theme_assets('img/shape4.png');
@endphp

<style>
    .banner-left-products.banner-left-products-slider {
        display: unset;
    }
</style>
<!-- Banner area end -->

<div class="banner-area banner-two position-relative" data-padding-top="{{$data['padding_top']}}" data-padding-bottom="{{$data['padding_bottom']}}">
    <div class="container-two">
        <div class="banner-contents-wrappers bg-item-four radius-30">
            <div class="banner-shapes">
                <img src="{{$particle_image_one}}" alt="">
                <img src="{{$particle_image_two}}" alt="">
                <img src="{{$particle_image_three}}" alt="">
                <img src="{{$particle_image_four}}" alt="">
            </div>
            <div class="banner-contents">
                <span class="banner-store color-heading fs-26"> {{$data['pre_title'] ?? ''}} </span>
                <h2 class="title ff-jost fw-600"> {{$data['title']}} </h2>
                @if(!empty($data['button_text']) && !empty($data['button_url'] ?? ''))
                    <div class="comingsoon-btn margin-top-40">
                        <a href="{{$data['button_url'] ?? ''}}"
                           class="comingsoon-order brows-category"> {{$data['button_text'] ?? ''}} </a>
                    </div>
                @endif
                <div class="banner-left-products banner-left-products-slider mt-4">
                    <div class="global-slick-init slider-inner-margin nav-style-one" data-slidesToShow="2" data-infinite="true" data-arrows="false"
                         data-dots="false" data-swipeToSlide="true" data-centerMode="false" data-centerPadding="40px" data-autoplay="false" data-autoplaySpeed="6000"
                         data-prevArrow='<div class="prev-icon"><i class="las la-angle-left"></i></div>'
                         data-nextArrow='<div class="next-icon"><i class="las la-angle-right"></i></div>'
                         data-rtl="{{get_user_lang_direction() == 1 ? 'true' : 'false'}}" data-responsive='[{"breakpoint": 1400,"settings": {"slidesToShow": 2}},{"breakpoint": 1200,"settings": {"slidesToShow": 2}},{"breakpoint": 992,"settings": {"slidesToShow": 2}},{"breakpoint": 575, "settings": {"slidesToShow": 1} }]'>
                        @foreach($data['products']?? [] as $key => $product)
                            @php
                                $price_data = get_product_dynamic_price($product);
                                $regular_price = $price_data['regular_price'];
                                $sale_price = $price_data['sale_price'];
                            @endphp

                            <div class="banner-single-products bg-white radius-20 margin-top-30">
                                <div class="banner-product-thumb radius-10">
                                    <a href="{{to_product_details($product->slug)}}">
                                        {!! render_image_markup_by_attachment_id($product->image_id) !!}
                                    </a>
                                </div>
                                <div class="banner-product-flex">
                                    <div class="single-flex-banner">
                                        <h6 class="banner_title ff-jost">
                                            <a href="{{to_product_details($product->slug)}}"> {{Str::limit($product->name ,12,'..')}} </a>
                                        </h6>
                                        <span
                                            class="common-price-title color-one fs-18 fw-700"> {{amount_with_currency_symbol($sale_price)}} </span>
                                    </div>
                                    <div class="banner-iconlist">
                                        <a href="{{to_product_details($product->slug)}}"
                                           class="banner-icon popup-modal"> <i class="lar la-eye"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="banner-socials">
                <ul class="social-lists">
                    @foreach($data['social_repeater']['name_'] ?? [] as $key => $value)
                        @continue(empty($value))
                        <li>
                            @php
                                $title = $data['social_repeater']['name_'][$key] ?? '';
                                $url = $data['social_repeater']['url_'][$key] ?? '#';
                            @endphp
                            <a href="{{esc_url($url)}}" {{!empty($data['new_tab']) ? 'target=""_blank' : ''}}> {{esc_html($title)}} </a>
                        </li>
                    @endforeach
                </ul>
            </div>
            <div class="banner-right-contents-all">
                <div class="banner-images-right wow fadeInUp" data-wow-delay=".3s">
                    <img class="lazyloads" src="{{$primary_image}}" alt="">
                </div>
                <div class="banner-image-shapes">
                </div>
            </div>
        </div>
    </div>
</div>
