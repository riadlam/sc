@foreach($products as $product)
    @php
        $data_info = get_product_dynamic_price($product);
        $campaign_name = $data_info['campaign_name'];
        $regular_price = $data_info['regular_price'];
        $sale_price = $data_info['sale_price'];
        $discount = $data_info['discount'];
    @endphp
    <div class="grid-item col-xxl-4 col-lg-6 mt-4">
        <div class="global-flex-card hover-overlay featured-card-padding radius-10">
            <div class="global-flex-card-thumb radius-5">
                <a href="{{route('tenant.shop.product.details', $product->slug)}}">
                    {!! render_image_markup_by_attachment_id($product->image_id, 'product-image') !!}
                </a>
            </div>

            @if($product->inventory_detail_count < 1)
                <a href="javascript:void(0)" class="product-cart-btn cart-btn-absolute radius-5 add-to-cart-btn" data-product_id="{{ $product->id }}"> {{__('Add to Cart')}} </a>
            @else
                <a href="{{route('tenant.shop.product.details', $product->slug)}}" class="product-cart-btn cart-btn-absolute radius-5"> {{__('Add to Cart')}} </a>
            @endif

            <a href="{{route('tenant.shop.product.details', $product->slug)}}" class="cart-details-btn cart-details-absolute radius-5">{{__('View Details')}}</a>
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
