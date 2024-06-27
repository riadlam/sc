<!-- Collection area starts -->
<section class="collection-area body-bg-2" data-padding-top="{{$data['padding_top']}}"
         data-padding-bottom="{{$data['padding_bottom']}}">
    <div class="container-three">
        <div class="row">
            <div class="col-lg-12">
                <div class="section-title-three text-center">
                    <h2 class="title">
                        @if(!empty($data['title_line']))
                            @php
                                $title_line = get_attachment_image_by_id(get_static_option('title_shape_image'));
                                $title_line_image = !empty($title_line) ? $title_line['img_url'] : '';
                            @endphp

                            <img class="line-round" src="{{$title_line_image}}" alt="">
                        @endif
                        {{$data['title'] ?? ''}}
                    </h2>
                </div>
            </div>
        </div>
        <div class="row margin-top-40">
            @foreach($data['products'] ?? [] as $product)
                @php
                    $data = get_product_dynamic_price($product);
                    $campaign_name = $data['campaign_name'];
                    $regular_price = $data['regular_price'];
                    $sale_price = $data['sale_price'];
                    $discount = $data['discount'];

                    $delay = $loop->odd ? '.1s' : '.2s';
                    $fadeClass = $loop->odd ? 'fadeInUp' : 'fadeInDown';
                @endphp

                <div class="col-xl-3 col-sm-6 margin-top-30 wow {{$fadeClass}}" data-wow-delay="{{$delay}}">
                    <div class="signle-collection text-center padding-0">
                        <div class="collction-thumb">
                            <a href="{{route('tenant.shop.product.details', $product->slug)}}">
                                {!! render_image_markup_by_attachment_id($product->image_id, 'radius-0') !!}
                            </a>

                            @include(include_theme_path('shop.partials.product-options'))
                        </div>

                        <div class="collection-contents">
                            <!--Product rating markup-->
                            {!! mares_product_star_rating($product?->rating, 'collection-review color-three justify-content-center margin-bottom-10') !!}

                            <h2 class="collection-title color-three ff-playfair">
                                <a href="{{route('tenant.shop.product.details', $product->slug)}}"> {{product_limited_text($product->name, 'title')}} </a>
                            </h2>
                            <div class="collection-bottom margin-top-15">
                                <!--product bottom add to cart button-->
                                @include(include_theme_path('shop.partials.product-options-bottom'))
                                <h3 class="common-price-title color-three fs-20 ff-roboto"> {{amount_with_currency_symbol($sale_price)}} </h3>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
<!-- Collection area end -->
