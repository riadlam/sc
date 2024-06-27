<!-- Flash Store area starts -->
<section class="flash-store-area" data-padding-top="{{$data['padding_top']}}" data-padding-bottom="{{$data['padding_bottom']}}">
    <div class="container-two">
        <div class="row">
            <div class="col-lg-12">
                <div class="section-title text-left section-title-two">
                    <h2 class="title"> {{$data['title'] ?? ''}} </h2>

                    @if(!empty($data['see_all_url']) && !empty($data['see_all_text']))
                        <a href="{{$data['see_all_url']}}">
                            <span class="see-all fs-18"> {{$data['see_all_text']}} </span>
                        </a>
                    @endif
                </div>
            </div>
        </div>
        <div class="row margin-top-10">
            <div class="col-lg-12 margin-top-30">
                <div class="global-slick-init flash-slider nav-style-one dot-style-one slider-inner-margin" data-infinite="true" data-arrows="true" data-swipeToSlide="true" data-autoplaySpeed="3000" data-autoplay="true" data-swipeToslide="true" data-slidesToShow="4"
                     data-prevArrow='<div class="prev-icon"><i class="las la-arrow-left"></i></div>' data-nextArrow='<div class="next-icon"><i class="las la-arrow-right"></i></div>' data-responsive='[{"breakpoint": 1200,"settings": {"slidesToShow": 3}},{"breakpoint": 992,"settings": {"arrows": false,"dots": true,"slidesToShow": 2}},{"breakpoint": 768, "settings": { "arrows": false,"dots": true,"slidesToShow": 1} }]'
                     data-rtl="{{get_user_lang_direction() == 1 ? 'true' : 'false'}}">
                    @foreach($data['products'] ?? [] as $product)
                        @php
                            $sale_data = get_product_dynamic_price($product);
                            $regular_price = $sale_data['regular_price'];
                            $sale_price = $sale_data['sale_price'];
                            $discount = $sale_data['discount'];

                            $delay = '.1s';
                            $class = 'fadeInUp';

                            if ($loop->even)
                            {
                                $delay = '.2s';
                                $class = 'fadeInDown';
                            }
                        @endphp

                        <div class="signle-collection bg-item-four radius-20 wow {{$class}}" data-wow-delay="{{$delay}}">
                            <div class="collction-thumb">
                                <a href="{{to_product_details($product->slug)}}">
                                    {!! render_image_markup_by_attachment_id($product->image_id, 'lazyloads') !!}
                                </a>

                                @include(include_theme_path('shop.partials.product-options'))

                                @if(!empty($discount))
                                    <span class="sale bg-color-one sale-radius-1"> {{__('Sale')}} </span>
                                @endif
                            </div>
                            <div class="collection-contents">
                                <h2 class="collection-title ff-jost">
                                    <a href="{{to_product_details($product->slug)}}"> {{product_limited_text($product->name, 'title')}} </a>
                                </h2>
                                <div class="collection-flex">
                                    <div class="price-update-through margin-top-15">
                                        <span class="fs-22 ff-roboto fw-500 flash-prices color-one"> {{amount_with_currency_symbol($sale_price)}} </span>
                                        <span class="fs-18 flash-old-prices"> {{amount_with_currency_symbol($regular_price)}} </span>
                                    </div>
                                    <div class="collection-flex-icon">
                                        @if($product->inventory_detail_count < 1)
                                            <a href="javascript:void(0)" class="shopping-icon cart-loading add-to-cart-btn" data-product_id="{{ $product->id }}">
                                                <i class="las la-shopping-bag"></i>
                                            </a>
                                        @else
                                            <a href="javascript:void(0)" class="shopping-icon cart-loading product-quick-view-ajax"
                                               data-action-route="{{ route('tenant.products.single-quick-view', $product->slug) }}">
                                                <i class="las la-shopping-bag"></i>
                                            </a>
                                        @endif
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
<!-- Flash Store area end -->
