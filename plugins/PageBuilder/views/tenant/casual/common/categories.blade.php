@php
    $product_bg_image = get_attachment_image_by_id($data['product_background_image']);
    $product_bg_image = !empty($product_bg_image) ? $product_bg_image['img_url'] : theme_assets('img/cate-shapes.png');
@endphp

<!-- Category area Starts -->
<section class="category-area" data-padding-top="{{$data['padding_top']}}" data-padding-bottom="{{$data['padding_bottom']}}">
    <div class="container-two">
        <div class="row">
            <div class="col-lg-12">
                <div class="section-title text-left section-title-two">
                    <h2 class="title"> {{$data['title'] ?? ''}} </h2>

                    @if(!empty($data['button_url']) && !empty($data['button_text']))
                        <a href="{{$data['button_url']}}">
                            <span class="see-all fs-18"> {{$data['button_text'] ?? ''}} </span>
                        </a>
                    @endif
                </div>
            </div>
        </div>
        <div class="row margin-top-10">
            @foreach($data['categories_info'] ?? [] as $category)
                @php
                    $delay = '.1s';
                    $class = 'fadeInUp';

                    if ($loop->even)
                    {
                        $delay = '.2s';
                        $class = 'fadeInDown';
                    }
                @endphp

                <div class="col-xl-3 col-sm-6 margin-top-30 wow {{$class}}" data-wow-delay="{{$delay}}">
                    <div class="single-category radius-20 bg-item-four text-center">
                        <div class="image-contents">
                            <div class="category-thumb">
                                {!! render_image_markup_by_attachment_id($category->image_id, 'lazyloads') !!}
                            </div>

                            <div class="shape-circle">
                                <img src="{{$product_bg_image}}" alt="">
                            </div>
                        </div>
                        <div class="category-contents">
                            <div class="notification-title">
                                <h2 class="titles ff-jost">
                                    <a href="javascript:void(0)"> {{$category->name}} </a>
                                </h2>

                                @if($data['product_count'])
                                    @php
                                        $product_count = count($category->product_categories);
                                    @endphp

                                    @if($product_count > 0)
                                        <span class="notification bg-color-one"> {{$product_count}} </span>
                                    @endif
                                @endif
                            </div>

                            <a href="{{route('tenant.shop.category.products', [$category->slug, 'category'])}}" class="collection-btn color-one"> {{$data['read_more_button_text'] ?? __('See Collection')}} </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
<!-- Category area end -->
