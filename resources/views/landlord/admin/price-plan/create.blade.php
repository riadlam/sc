@extends(route_prefix().'admin.admin-master')
@section('title')
    {{__('Create Price Plan')}}
@endsection

@section('style')
    <style>
        .all-field-wrap .action-wrap {
            position: absolute;
            right: 0;
            top: 0;
            background-color: #f2f2f2;
            height: 100%;
            width: 60px;
            text-align: center;
            display: flex;
            justify-content: center;
            flex-direction: column;
            align-items: center;
        }

        .f_desc {
            height: 100px;
        }

        small {
            font-size: 12px;
            color: #b66dff;
        }

        .price_plan_info {
            cursor: pointer;
        }

        .payment-gateway-wrapper ul{
            list-style: none;
            display: flex;
            flex-wrap: wrap;
            padding-left: 0;
        }
        .payment-gateway-wrapper ul li{
            max-width: 100px;
            cursor: pointer;
            box-sizing: border-box;
            height: 50px;
            display: flex;
            align-items: center;
            position: relative;
            overflow: hidden;
            margin: 3px;
            border: 1px solid #ddd;
        }
        .payment-gateway-wrapper ul li .img-select{
            margin-bottom: 0
        }
        .img-select img{
            max-width: 100%;
        }

        .payment-gateway-wrapper ul li.selected {
            border: 2px solid red;
        }
    </style>

@endsection

@section('content')
    @php
        $features = price_plan_feature_list();
    @endphp
    <div class="col-12 stretch-card">
        <div class="card">
            <div class="card-body">
                <x-admin.header-wrapper>
                    <x-slot name="left">
                        <h4 class="card-title mb-4">{{__('Create Price Plan')}}</h4>
                    </x-slot>
                    <x-slot name="right" class="d-flex">
                        <x-link-with-popover url="{{route(route_prefix().'admin.price.plan')}}" extraclass="ml-3">
                            {{__('All Price Plan')}}
                        </x-link-with-popover>
                    </x-slot>
                </x-admin.header-wrapper>
                <x-error-msg/>
                <x-flash-msg/>
                <form class="forms-sample" method="post" action="{{route(route_prefix().'admin.price.plan.create')}}">
                    @csrf
                    <x-fields.input name="title" label="{{__('Title')}}"/>
                    <x-fields.input name="package_badge" label="{{__('Package Badge')}}"/>
                    <x-fields.textarea name="package_description" label="{{__('Package Description')}}"/>

                    @if(!tenant())
                        <div class="form-group landlord_price_plan_feature">
                            <h4>{{__('Select Features')}}</h4>
                            <div class="feature-section">
                                <ul>
                                    @foreach($features as $key => $feat)
                                        <li class="d-inline">
                                            <input type="checkbox" name="features[]"
                                                   id="{{$key}}" class="exampleCheck1" value="{{$key}}"
                                                   data-feature="{{$key}}">
                                            <label class="ml-1" for="{{$key}}">
                                                {{__(str_replace('_', ' ', ucwords($feat)))}}
                                            </label>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>

                        <div class="form-group page_permission_box"></div>

                        <div class="form-group blog_permission_box"></div>

                        <div class="form-group product_permission_box"></div>

                        <div class="form-group storage_permission_box"></div>

                        <div class="form-group landlord_price_plan_themes">
                            <h4>{{__('Select Themes')}}</h4>
                            <div class="feature-section">
                                <ul class="d-flex flex-wrap gap-3" style="list-style-type: none">
                                    @php
                                        $themes = getAllThemeSlug();
                                    @endphp
                                    @foreach($themes as $theme)
                                        <li>
                                            <input type="checkbox" name="themes[]"
                                                   id="{{$theme}}" class="exampleCheck1" value="{{$theme}}"
                                                   data-feature="{{$theme}}">
                                            <label class="ml-1 text-capitalize" for="{{$theme}}">
                                                {{$theme}}
                                            </label>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>

                        <div class="form-group landlord_price_plan_payment_gateways">
                            <h4>{{__('Select Payment Gateways')}}</h4>
                            <div class="feature-section">
                                <style>
                                    .select-all-theme{
                                        width: 115px;
                                    }
                                    .select-all-theme .onff.slider:before{
                                        content: "Select All";
                                        width: 80px;
                                    }
                                    .select-all-theme input:checked + .onff.slider:before {
                                        content: "Unselect" !important;
                                    }
                                </style>
                                <x-fields.switcher class="select-all-theme" name="" label="" value=""/>
                                @php
                                    $replaceable_text = '<input type="hidden" name="selected_payment_gateway" value="paytm">';
                                @endphp
                                {!! str_replace($replaceable_text,'',render_payment_gateway_for_price_plan()) !!}
                                <input type="hidden" name="payment_gateways">
                            </div>
                        </div>

                        <x-fields.select name="type" class="package_type" title="{{__('Type')}}">
                            <option value="">{{__('Select')}}</option>
                            <option value="0">{{__('Monthly')}}</option>
                            <option value="1">{{__('Yearly')}}</option>
                            <option value="2">{{__('Lifetime')}}</option>
                        </x-fields.select>

                        <div class="d-flex justify-content-start">
                            <x-fields.switcher name="has_trial" label="{{__('Free Trial')}}"/>

                            <div class="form-group trial_date_box mx-4">
                                <label for="">{{__('Trial Days')}}</label>
                                <input type="number" class="form-control" name="trial_days" placeholder="Days..">
                            </div>
                        </div>
                    @endif

                    <x-fields.input type="number" name="price" label="{{__('Price')}}"/>
                    <x-fields.select name="status" title="{{__('Status')}}">
                        <option value="1">{{__('Publish')}}</option>
                        <option value="0">{{__('Draft')}}</option>
                    </x-fields.select>

                    @if(!tenant())
                        <div class="iconbox-repeater-wrapper">
                            <div class="all-field-wrap">
                                <div class="form-group">
                                    <label for="faq">{{__('Faq Title')}}</label>
                                    <input type="text" name="faq[title][]" class="form-control"
                                           placeholder="{{__('faq title')}}">
                                </div>
                                <div class="form-group">
                                    <label for="faq_desc">{{__('Faq Description')}}</label>
                                    <textarea name="faq[description][]" class="form-control f_desc"
                                              placeholder="{{__('faq description')}}"></textarea>
                                </div>
                                <div class="action-wrap">
                                    <span class="add"><i class="las la-plus"></i></span>
                                    <span class="remove"><i class="las la-trash"></i></span>
                                </div>
                            </div>
                        </div>
                    @endif

                    <button type="submit" class="btn btn-gradient-primary me-2 mt-5">{{__('Save Changes')}}</button>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        //Date Picker
        flatpickr('.date', {
            enableTime: false,
            dateFormat: "d-m-Y",
            minDate: "today"
        });

        $(document).on('change', 'select[name="lang"]', function (e) {
            $(this).closest('form').trigger('submit');
            $('input[name="lang"]').val($(this).val());
        });

        $('.trial_date_box').hide();
        $(document).on('change', 'input[name=has_trial]', function (e) {
            let el = $(this).val();

            $('.trial_date_box').toggle(500);
        });

        let page_permission = $('.page_permission_box');
        let blog_permission = $('.blog_permission_box');
        let product_permission = $('.product_permission_box');
        let storage_permission = $('.storage_permission_box');

        page_permission.hide();
        blog_permission.hide();
        product_permission.hide();
        storage_permission.hide();

        $(document).on('change', '.exampleCheck1', function (e) {
            let feature = $(this).attr('data-feature');

            if (feature == 'pages') {
                var page = `<label for="">{{__('Page Create Permission')}} <i class="mdi mdi-information-outline text-primary price_plan_info" data-bs-toggle="tooltip" data-bs-placement="top" title="{{__('Keep -1 for Unlimited')}}"></i></label>
                            <input type="text" min="1" class="form-control" name="page_permission_feature" value="">
                            <small>Page limit</small>`;

                if (feature == 'pages' && this.checked) {
                    page_permission.append(page).hide();
                    page_permission.slideDown();
                } else {
                    page_permission.slideUp().html('');
                }
            }


            if (feature == 'blog') {
                var blog = `<label for="">{{__('Blog Create Permission')}} <i class="mdi mdi-information-outline text-primary price_plan_info" data-bs-toggle="tooltip" data-bs-placement="top" title="{{__('Keep -1 for Unlimited')}}"></i></label>
                            <input type="text" min="1" class="form-control" name="blog_permission_feature" value="">
                            <small>Blog limit</small>`;

                if (feature == 'blog' && this.checked) {
                    blog_permission.append(blog).hide();
                    blog_permission.slideDown();

                } else {
                    blog_permission.slideUp().html('');
                }

            }


            if (feature == 'products') {
                var product = `<label for="">{{__('Product Create Permission')}} <i class="mdi mdi-information-outline text-primary price_plan_info" data-bs-toggle="tooltip" data-bs-placement="top" title="{{__('Keep -1 for Unlimited')}}"></i></label>
                            <input type="text" min="1" class="form-control" name="product_permission_feature"
                                   value="">
                                   <small>Product limit</small>`;

                if (feature == 'products' && this.checked) {
                    product_permission.append(product).hide();
                    product_permission.slideDown();
                } else {
                    product_permission.slideUp().html('');
                }

            }

            if (feature == 'storage') {
                var storage = `<label for="">{{__('Storage Create Permission')}} <i class="mdi mdi-information-outline text-primary price_plan_info" data-bs-toggle="tooltip" data-bs-placement="top" title="{{__('Keep -1 for Unlimited')}}"></i></label>
                            <input type="text" min="1" class="form-control" name="storage_permission_feature"
                                   value="">
                                   <small>Storage limit (MB)</small>`;

                if (feature == 'storage' && this.checked) {
                    storage_permission.append(storage).hide();
                    storage_permission.slideDown();
                } else {
                    storage_permission.slideUp().html('');
                }

            }
        });

        $(document).ready(function (){
            let payment_gateway_item = $('.payment-gateway-wrapper ul li');
            payment_gateway_item.removeClass('selected');

            payment_gateway_item.on('click', function (e){
                let gateways = '';

                let el = $(this);
                el.toggleClass('selected');

                let all_payment_gateways = $('.payment-gateway-wrapper ul li.selected');
                all_payment_gateways.each(function (index){
                    gateways += $(this).data('gateway') + (all_payment_gateways.length-1 !== index ? ',' : '');
                });

                $("input[name='payment_gateways']").val(gateways);
            });

            $('.select-all-theme input[type="checkbox"]').on('change', function (){
                let gateways = '';
                let el = $(this);

                payment_gateway_item.each(function (){
                    $(this).removeClass('selected');
                });

                if(el.is(":checked"))
                {
                    let all_payment_gateways = $('.payment-gateway-wrapper ul li.selected');
                    payment_gateway_item.each(function (index){
                        $(this).addClass('selected');
                        gateways += $(this).data('gateway') + (payment_gateway_item.length-1 !== index ? ',' : '');
                    });
                }

                $("input[name='payment_gateways']").val(gateways);
            });
        });
    </script>
    <x-repeater/>
@endsection
