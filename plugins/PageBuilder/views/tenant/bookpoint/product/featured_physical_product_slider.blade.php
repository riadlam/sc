<!-- Featured area starts -->
<section class="featured-area featured-area-physical padding-top-100 padding-bottom-50" data-padding-top="{{$data['padding_top']}}" data-padding-bottom="{{$data['padding_bottom']}}">
    <div class="custom-container-one">
        <div class="section-title text-left">
            <h2 class="title"> {{$data['title'] ?? ''}} </h2>
            <div class="append-product"></div>
        </div>
        <div class="row mt-5">
            <div class="col-lg-12">
                <div class="global-slick-init recent-slider nav-style-one slider-inner-margin" data-appendArrows=".append-product" data-infinite="true" data-arrows="true" data-dots="false" data-slidesToShow="3" data-swipeToSlide="true" data-autoplay="true" data-autoplaySpeed="2500"
                     data-prevArrow='<div class="prev-icon"><i class="las la-angle-left"></i></div>' data-nextArrow='<div class="next-icon"><i class="las la-angle-right"></i></div>' data-responsive='[{"breakpoint": 1400,"settings": {"slidesToShow": 2}},{"breakpoint": 1200,"settings": {"slidesToShow": 2}},{"breakpoint": 992,"settings": {"slidesToShow": 1}},{"breakpoint": 768, "settings": {"slidesToShow": 1} }]'
                     data-rtl="{{get_user_lang_bool_direction()}}">
                    @foreach($data['products'] ?? [] as $product)
                        @php
                            if ($loop->odd) {
                                    $delay = '.1s';
                                    $class = 'fadeInDown';
                                }
                            else {
                                $delay = '.2s';
                                $class = 'fadeInUp';
                            }

                            $data_info = get_product_dynamic_price($product);
                            $campaign_name = $data_info['campaign_name'];
                            $regular_price = $data_info['regular_price'];
                            $sale_price = $data_info['sale_price'];
                            $discount = $data_info['discount'];
                        @endphp
                        <div class="slick-slider-items wow {{$class}}" data-wow-delay="{{$delay}}">
                        <div class="global-flex-card hover-overlay featured-card-padding radius-10">
                            <div class="global-flex-card-thumb radius-5">
                                <a href="{{route('tenant.shop.product.details', $product->slug)}}">
                                    {!! render_image_markup_by_attachment_id($product->image_id, 'product-image radius-10') !!}
                                </a>
                            </div>

                            @if($product->inventory_detail_count < 1)
                                <a href="javascript:void(0)" class="product-cart-btn cart-btn-absolute radius-5 add-to-cart-btn" data-product_id="{{ $product->id }}"> {{__('Add to Cart')}} </a>
                            @else
                                <a href="{{route('tenant.shop.product.details', $product->slug)}}" class="product-cart-btn cart-btn-absolute radius-5"> {{__('Add to Cart')}} </a>
                            @endif

                            <a href="{{route('tenant.shop.product.details', $product->slug)}}" class="cart-details-btn cart-details-absolute radius-5"> {{__('View Details')}} </a>
                            <div class="global-flex-card-contents">
                                @if($discount > 0)
                                    <div class="global-badge">
                                        <span class="global-badge-box bg-one"> {{$discount}}% {{__('off')}} </span>
                                    </div>
                                @endif

                                @if(!empty($product->badge))
                                        <span class="global-badge-box bg-new"> {{$product?->badge?->name}} </span>
                                @endif

                                <h6 class="global-flex-card-contents-title">
                                    <a href="{{route('tenant.shop.product.details', $product->slug)}}"> {{product_limited_text($product->name, 'title')}} </a>
                                </h6>

                                {!! render_product_star_rating_markup_with_count($product) !!}

                                <div class="price-update-through mt-3">
                                    <span class="fs-24 fw-500 flash-prices color-one"> {{float_amount_with_currency_symbol($sale_price)}} </span>
                                    <s class="old-prices"> {{float_amount_with_currency_symbol($regular_price)}} </s>
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
<!-- Featured area end -->
