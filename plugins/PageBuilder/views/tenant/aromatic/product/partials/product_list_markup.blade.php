@foreach($products ?? [] as $product)
    @php
        $data_info = get_product_dynamic_price($product);
        $campaign_name = $data_info['campaign_name'];
        $regular_price = $data_info['regular_price'];
        $sale_price = $data_info['sale_price'];
        $discount = $data_info['discount'];

        if ($loop->odd)
            {
                $delay = '.1s';
                $fadeClass = 'fadeInUp';
            } else {
                $delay = '.2s';
                $fadeClass = 'fadeInDown';
            }
    @endphp

    <div class="col-xl-3 col-sm-6 margin-top-30 grid-item st1 st2 st3 st4 wow {{$fadeClass}}" data-wow-delay="{{$delay}}">
        <div class="signle-collection text-center padding-0">
            <div class="collction-thumb">
                <a href="{{route('tenant.shop.product.details', $product->slug)}}">
                    {!! render_image_markup_by_attachment_id($product->image_id, 'radius-0') !!}
                </a>

                @include(include_theme_path('shop.partials.product-options'))
            </div>
            <div class="collection-contents">
                {!! mares_product_star_rating($product?->rating, 'collection-review color-three justify-content-center margin-bottom-10') !!}

                <h2 class="collection-title color-three ff-playfair">
                    <a href="{{route('tenant.shop.product.details', $product->slug)}}"> {{product_limited_text($product->name, 'title')}} </a>
                </h2>
                <div class="collection-bottom margin-top-15">
                    @include(include_theme_path('shop.partials.product-options-bottom'))
                    <h3 class="common-price-title color-three fs-20 ff-roboto"> {{amount_with_currency_symbol($sale_price)}} </h3>
                </div>
            </div>
        </div>
    </div>
@endforeach
