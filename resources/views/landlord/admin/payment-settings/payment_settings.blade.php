@extends(route_prefix().'admin.admin-master')
@section('title')
    {{__('Payment Settings')}}
@endsection
@section('style')
    <x-summernote.css/>
    <x-media-upload.css/>
@endsection
@section('content')
    <div class="col-lg-12 col-ml-12">
        <div class="row">
            <div class="col-12">
                <x-flash-msg/>
                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title mb-4">{{__("Payment Gateway Settings")}}</h4>
                        <x-error-msg/>
                        <form action="{{route(route_prefix().'admin.payment.settings.update')}}" method="POST"
                              enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="card">
                                        <div class="card-body">
                                            @if(!empty($gateway->description))
                                                <div class="payment-notice alert alert-warning">
                                                    <p>{{$gateway->description}}</p>
                                                </div>
                                            @endif

                                            @if(isset($cod) && $cod)
                                                <input type="hidden" name="gateway_name" value="cash_on_delivery">
                                                @if(tenant())
                                                    <x-fields.switcher value="{{get_static_option('cash_on_delivery')}}"
                                                                       name="cash_on_delivery"
                                                                       label="{{__('Enable Cash On Delivery')}}"/>
                                                @endif
                                            @else
                                                <input type="hidden" name="gateway_name" value="{{$gateway->name}}">

                                                <div class="form-group">
                                                    <label
                                                        for="instamojo_gateway"><strong>{{__('Enable/Disable '. ucfirst($gateway->name))}}</strong></label>
                                                    <input type="hidden" name="{{$gateway->name}}_gateway">
                                                    <label class="switch">
                                                        <input type="checkbox" name="{{$gateway->name}}_gateway"
                                                               @if($gateway->status === 1 ) checked @endif >
                                                        <span class="slider onff"></span>
                                                    </label>
                                                </div>

                                                <div class="form-group">
                                                    <label
                                                        for="instamojo_test_mode"><strong>{{sprintf(__('Enable Test Mode %s'),ucfirst($gateway->name))}}</strong></label>

                                                    <label class="switch">
                                                        <input type="checkbox" name="{{$gateway->name}}_test_mode"
                                                               @if($gateway->test_mode === 1) checked @endif>
                                                        <span class="slider onff"></span>
                                                    </label>
                                                </div>

                                                <x-landlord-others.edit-media-upload-image
                                                    label="{{ sprintf(__('%s Logo'),ucfirst($gateway->name))}}"
                                                    name="{{$gateway->name.'_logo'}}" :value="$gateway->image"/>

                                                @if($gateway->name === "paystack")
                                                    <div class="form-group">
                                                        <p>{{__('Do not forget to put below url to "Settings > API Key & Webhook > Callback URL" in your paystack admin panel')}}</p>
                                                        <input type="text" class="form-control mb-2" readonly
                                                               value="{{tenant() ? route('tenant.user.frontend.paystack.ipn') : route('landlord.frontend.paystack.ipn')}}"/>
                                                    </div>
                                                @endif
                                                @php
                                                    $credentials = !empty($gateway->credentials) ? json_decode($gateway->credentials) : [];
                                                @endphp
                                                @foreach($credentials as $cre_name =>  $cre_value)
                                                    <div class="form-group">
                                                        <label>{{ str_replace('_', ' ' , ucwords($cre_name)) }}</label>
                                                        <input type="text" name="{{$gateway->name.'_'.$cre_name}}"
                                                               value="{{$cre_value}}"
                                                               class="form-control">
                                                        @if($gateway->name == 'paytabs')
                                                            @if($cre_name == 'region')
                                                                <small class="text-secondary" style="font-size: 13px">GLOBAL,
                                                                    ARE, EGY, SAU,
                                                                    OMN, JOR</small>
                                                            @endif
                                                        @endif
                                                    </div>
                                                @endforeach
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <button type="submit"
                                    class="btn btn-primary mt-4 pr-4 pl-4">{{__('Update Changes')}}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <x-media-upload.markup/>

@endsection
@section('scripts')
    <x-summernote.js/>
    <x-media-upload.js/>
    <script>
        (function ($) {
            "use strict";
            $(document).ready(function ($) {
                $('.summernote').summernote({
                    height: 200,   //set editable area's height
                    codemirror: { // codemirror options
                        theme: 'monokai'
                    },
                    callbacks: {
                        onChange: function (contents, $editable) {
                            $(this).prev('input').val(contents);
                        }
                    }
                });
                if ($('.summernote').length > 0) {
                    $('.summernote').each(function (index, value) {
                        $(this).summernote('code', $(this).data('content'));
                    });
                }
            });
        })(jQuery);


    </script>
@endsection

