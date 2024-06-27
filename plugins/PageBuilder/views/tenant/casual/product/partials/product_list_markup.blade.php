@foreach($products ?? [] as $product)
    @php
        $data_info = get_product_dynamic_price($product);
        $campaign_name = $data_info['campaign_name'];
        $regular_price = $data_info['regular_price'];
        $sale_price = $data_info['sale_price'];
        $discount = $data_info['discount'];

        $delay = '.1s';
        $class = 'fadeInUp';

        if ($loop->even)
        {
             $delay = '.2s';
             $class = 'fadeInDown';
        }
    @endphp

    <div class="col-xl-4 col-md-6 margin-top-30">
        <div class="signle-collection bg-item-four radius-20">
            <div class="collction-thumb">
                <a href="{{to_product_details($product->slug)}}">
                    {!! render_image_markup_by_attachment_id($product->image_id, 'lazyloads') !!}
                </a>

                @include(include_theme_path('shop.partials.product-options'))

                @if($discount)
                    <span class="sale bg-color-one sale-radius-1"> {{__('Sale')}} </span>
                @endif
            </div>
            <div class="collection-contents">
                <h2 class="collection-title ff-jost">
                    <a href="{{to_product_details($product->slug)}}"> {{product_limited_text($product->name, 'title')}} </a>
                </h2>
                <div class="collection-flex">
                    <div class="price-update-through margin-top-15">
                        <span
                            class="fs-22 ff-roboto fw-500 flash-prices color-one"> {{amount_with_currency_symbol($sale_price)}} </span>
                        <span
                            class="fs-18 flash-old-prices"> {{amount_with_currency_symbol($regular_price)}} </span>
                    </div>
                    <div class="collection-flex-icon">
                        @if($product->inventory_detail_count < 1)
                            <a href="javascript:void(0)" class="shopping-icon cart-loading add-to-cart-btn"
                               data-product_id="{{ $product->id }}">
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
    </div>
@endforeach
