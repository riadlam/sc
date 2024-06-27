



<!-- Store area Starts -->
<section class="stoere-area body-bg-2" data-padding-top="{{$data['padding_top']}}"
         data-padding-bottom="{{$data['padding_bottom']}}">
    <div class="container-three">
        <div class="row">
            <div class="col-lg-12">
                <div class="section-title-three text-center">
                    <h2 class="title">
                        @if(!empty($data['title_line']))
                            <img class="line-round" src="{{title_underline_image_src()}}" alt="">
                        @endif

                        {{$data['title']}}</h2>
                </div>
            </div>
        </div>
        <div class="row margin-top-65">
            <div class="col-lg-12">
                <div class="product-list">
                    <ul class="product-button isootope-button justify-content-center colors-heading">
                        @php
                            $all = !empty($data['categories']) ? $data['categories']->pluck('id')->toArray() : '';
                            $allIds = implode(',', $all);
                        @endphp

                        <li class="list active"
                            data-limit="{{$data['product_limit']}}"
                            data-tab="all"
                            data-all-id="{{$allIds}}"
                            data-sort_by="{{$data['sort_by']}}"
                            data-sort_to="{{$data['sort_to']}}"
                            data-filter="*">{{__('All')}}</li>
                        @foreach($data['categories'] as $category)
                            <li class="list"
                                data-tab="{{$category->slug}}"
                                data-limit="{{$data['product_limit']}}"
                                data-sort_by="{{$data['sort_by']}}"
                                data-sort_to="{{$data['sort_to']}}">{{$category->name}} </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
        <div class="imageloaded">
            <div class="row grid margin-top-40 markup_wrapper">
                @foreach($data['products'] ?? [] as $product)
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
            </div>
        </div>
    </div>
</section>
<!-- Store area end -->



@section("scripts")
    <script>
        $(function () {
            $(document).on('click', '.product-list .list', function (e) {
                e.preventDefault();

                let el = $(this);
                let tab = el.data('tab');
                let limit = el.data('limit');
                let sort_by = el.data('sort_by');
                let sort_to = el.data('sort_to');
                let allId = el.data('all-id');

                $.ajax({
                    type: 'GET',
                    url: "{{route('tenant.category.wise.product.aromatic')}}",
                    data: {
                        category: tab,
                        limit: limit,
                        sort_by: sort_by,
                        sort_to: sort_to,
                        allId: allId
                    },
                    beforeSend: function () {
                        $('.loader').fadeIn(200);
                    },
                    success: function (data) {
                        let tab = $('li.list[data-tab='+data.category+']');
                        let markup_wrapper = $('.markup_wrapper');

                        $('li.list').removeClass('active');
                        tab.addClass('active');
                        markup_wrapper.hide();
                        markup_wrapper.html(data.markup);
                        markup_wrapper.fadeIn();
                        $('.loader').fadeOut(200);
                    },
                    error: function (data) {
                        console.log('error')
                    }
                });
            });
        });
    </script>
@endsection
