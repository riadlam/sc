@php
    if (str_contains($data['title'], '{h}') && str_contains($data['title'], '{/h}'))
    {
        $text = explode('{h}',$data['title']);

        $highlighted_word = explode('{/h}', $text[1])[0];

        $highlighted_text = '<span class="section-shape title-shape">'. $highlighted_word .'</span>';
        $final_title = '<h1 class="title">'.str_replace('{h}'.$highlighted_word.'{/h}', $highlighted_text, $data['title']).'</h1>';
    } else {
        $final_title = '<h1 class="title">'. $data['title'] .'</h1>';
    }
@endphp

<style>
    .all-features a{
        color: var(--main-color-one);
    }
    .all-features a:hover{
        border-bottom: 1px solid var(--main-color-one);
    }
    .plan-description {
        background: var(--section-bg-1);
    }
    .plan-description p{
        text-align: justify;
        hyphens: none;
    }
    .single-price:hover .plan-description {
        background: #ffffff;
    }
</style>

<section class="pricing-area section-bg-1" data-padding-top="{{$data['padding_top']}}"
         data-padding-bottom="{{$data['padding_bottom']}}" id="{{$data['section_id']}}">
    <div class="container">
        <div class="section-title">
            {!! $final_title !!}
            <p class="section-para"> {{$data['subtitle']}} </p>
        </div>

        <div class="row justify-content-center mt-4">
            <div class="col-lg-6 mt-4">
                <div class="pricing-tab-list center-text">
                    <ul class="tabs price-tab radius-10">
                        @foreach(($data['plan_types']) as $type)
                            @php
                                $type_data_tab = match ($type) {
                                    0 => 'month',
                                    1 => 'year',
                                    2 => 'lifetime'
                                };
                            @endphp
                            <li data-tab="tab-{{$type_data_tab}}" class="price-tab-list {{$loop->first ? 'active' : ''}}"> {{\App\Enums\PricePlanTypEnums::getText($type)}}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
        @foreach($data['all_price_plan'] as  $plan_type => $plan_items)
            @php
                $id= '';
                $active = '';
                $period = '';
                if($plan_type == 0){
                    $id = 'month';
                    $active = 'show active';
                    $period = __('/mo');
                }elseif($plan_type == 1){
                    $id = 'year';
                     $period = __('/yr');
                }else{
                     $id = 'lifetime';
                      $period = __('/lt');
                }

                $content_center_class = count($plan_items) <= 3 ? 'justify-content-center' : '';
            @endphp

            <div class="tab-content-item {{$active}}" id="tab-{{$id}}">
                <div class="row {{$content_center_class}} mt-4">
                    @foreach($plan_items as $key => $price_plan_item)
                        @php
                            $featured_condition = $key == 1 ? 'active' : '';
                        @endphp

                        <div class="col-lg-4 col-md-6 mt-4">
                            <div class="single-price radius-10 {{$featured_condition}}">
                                <span class="single-price-sub-title mb-5 radius-5"> {{$price_plan_item->package_badge}} </span>
                                <div class="single-price-top center-text">
                                    <span
                                        class="single-price-top-plan"> {{$price_plan_item->title}} </span>
                                    <h3 class="single-price-top-title mt-4"> {{amount_with_currency_symbol($price_plan_item->price)}}
                                        <sub>{{$period}}</sub></h3>
                                </div>
                                <ul class="single-price-list mt-4">
                                    @if(!empty($price_plan_item->page_permission_feature))
                                        <li class="single-price-list-item">
                                            <span class="check-icon"> <i class="las la-check"></i> </span>
                                            <span>
                                                <strong>
                                                    @if($price_plan_item->page_permission_feature < 0)
                                                        {{__('Page Unlimited')}}
                                                    @else
                                                         {{ __(sprintf('Page %d', $price_plan_item->page_permission_feature) )}}
                                                    @endif
                                                </strong>
                                            </span>
                                        </li>
                                    @endif

                                    @if(!empty($price_plan_item->product_permission_feature))
                                        <li class="single-price-list-item">
                                            <span class="check-icon"> <i class="las la-check"></i> </span>
                                            <span>
                                                <strong>
                                                    @if($price_plan_item->product_permission_feature < 0)
                                                        {{__('Product Unlimited')}}
                                                    @else
                                                        {{ __(sprintf('Product %d',$price_plan_item->product_permission_feature) )}}
                                                    @endif
                                                </strong>
                                            </span>
                                        </li>
                                    @endif

                                    @if(!empty($price_plan_item->blog_permission_feature))
                                        <li class="single-price-list-item">
                                            <span class="check-icon"> <i class="las la-check"></i> </span>
                                            <span>
                                                <strong>
                                                    @if($price_plan_item->blog_permission_feature < 0)
                                                        {{__('Blog Unlimited')}}
                                                    @else
                                                        {{ __(sprintf('Blog %d',$price_plan_item->blog_permission_feature) )}}
                                                    @endif
                                                </strong>
                                            </span>
                                        </li>
                                    @endif

                                        @if(!empty($price_plan_item->storage_permission_feature))
                                            <li class="single-price-list-item">
                                                <span class="check-icon"> <i class="las la-check"></i> </span>
                                                <span>
                                                    <strong>
                                                        @if($price_plan_item->storage_permission_feature < 0)
                                                            {{__('Storage Unlimited')}}
                                                        @else
                                                            {{ __(sprintf('Storage %d MB',$price_plan_item->storage_permission_feature) )}}
                                                        @endif
                                                    </strong>
                                                </span>
                                            </li>
                                        @endif
                                </ul>

                                @if(!empty($price_plan_item->description))
                                    <div class="mt-4 p-3 rounded plan-description">
                                        <p>{{$price_plan_item->description}}</p>
                                    </div>
                                @endif

                                <div class="btn-wrapper text-center all-features mt-4 mt-lg-4">
                                    <a href="{{route('landlord.frontend.plan.order',$price_plan_item->id)}}">{{__('View All Features')}}</a>
                                </div>
                                <div class="btn-wrapper mt-4 mt-lg-4">
                                    @php
                                        $buy_text = $price_plan_item->price > 0 ? __('Buy Now') : __('Get Now');
                                    @endphp
                                    @if($price_plan_item->has_trial == true)
                                        <div class="d-flex justify-content-center">
                                            <a href="{{route('landlord.frontend.plan.order',$price_plan_item->id)}}" class="cmn-btn cmn-btn-outline-one color-one w-100 mx-1">
                                                {{$buy_text}} </a>

                                            <a href="{{route('landlord.frontend.plan.view',[$price_plan_item->id, 'trial'])}}" class="cmn-btn cmn-btn-outline-one color-one w-100 mx-1">
                                                {{__('Try Now')}} </a>
                                        </div>
                                    @else
                                        <a href="{{route('landlord.frontend.plan.order',$price_plan_item->id)}}" class="cmn-btn cmn-btn-outline-one color-one w-100">
                                            {{$buy_text}} </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>
</section>
