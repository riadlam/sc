@extends('landlord.admin.admin-master')
@section('title')
    {{__('Price Plan Settings')}}
@endsection

@section('style')
    <link rel="stylesheet" href="{{global_asset('assets/common/css/select2.min.css')}}">
@endsection

@section('content')
    <div class="col-lg-12 col-ml-12">
        <div class="row">
            <div class="col-12">
                <x-error-msg/>
                <x-flash-msg/>
                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title mb-4">{{__("Price Plan Settings")}}</h4>
                        <form action="{{route('landlord.admin.price.plan.settings')}}" method="POST" enctype="multipart/form-data">
                          @csrf
                            @php
                                $fileds = [
                                        1 => __('One Day'),
                                        2 => __('Two Day'),
                                        3 => __('Three Day'),
                                        4 => __('Four Day'),
                                        5 => __('Five Day'),
                                        6 => __('Six Day'),
                                        7 => __('Seven Day')
                                    ];
                            @endphp
                               <div class="form-group  mt-3">
                                   <label for="site_logo">{{__('Select How many days earlier expiration mail alert will be send')}}</label>
                                   <select name="package_expire_notify_mail_days[]" class="form-control expiration_dates" multiple="multiple">

                                       @foreach($fileds as $key => $field)
                                           @php
                                               $package_expire_notify_mail_days = get_static_option('package_expire_notify_mail_days');
                                               $decoded = json_decode($package_expire_notify_mail_days) ?? [];
                                           @endphp
                                         <option value="{{$key}}"
                                         @foreach($decoded as  $day)
                                                {{$day == $key ? 'selected' : ''}}
                                          @endforeach
                                         >{{__($field)}}</option>
                                       @endforeach

                                   </select>
                               </div>

                            <div class="form-group">
                                @php
                                    $themes = getAllThemeData();
                                @endphp
                                <label for="default-theme">{{__('Default Theme')}}</label>
                                <select name="default_theme" id="default-theme" class="form-control">
                                    @foreach($themes as $theme)
                                        @php
                                            $custom_theme_name = get_static_option_central($theme->slug.'_theme_name');
                                        @endphp
                                        <option value="{{$theme->slug}}" {{get_static_option('default_theme') == $theme->slug ? 'selected' : ''}}>{{ !empty($custom_theme_name) ? $custom_theme_name : $theme->name}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                @php
                                    $languages = ['en_GB' => 'English (UK)', 'ar' => 'العربية'];
                                @endphp
                                <label for="default-language">{{__('Default Languages')}}</label>
                                <select name="default_language" id="default-language" class="form-control">
                                    @foreach($languages as $index => $language)
                                        <option value="{{$index}}" {{get_static_option_central('default_language') == $index ? 'selected' : ''}}>{{ $language }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="zero-plan-limit">{{__('Zero Price Plan Purchase Limit (Free Plan)')}}</label>
                                <input class="form-control" type="number" name="zero_plan_limit" id="zero-plan-limit" placeholder="{{__('Example: 1')}}" value="{{get_static_option('zero_plan_limit')}}">
                                <small>{{__('Purchase limitation for a price plan which price is zero')}}</small>
                            </div>

                            <div class="form-group">
                                <x-fields.input type="text" name="tenant_admin_default_username" value="{{get_static_option_central('tenant_admin_default_username')}}" label="{{__('Tenant Admin Default Username')}}"/>
                                <x-fields.input type="text" name="tenant_admin_default_password" value="{{get_static_option_central('tenant_admin_default_password')}}" label="{{__('Tenant Admin Default Password')}}"/>
                            </div>

                            <button type="submit" id="update" class="btn btn-primary mt-4 pr-4 pl-4">{{__('Update Changes')}}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{global_asset('assets/common/js/select2.min.js')}}"></script>
    <script>
        $(document).ready(function() {
            $('.expiration_dates').select2();
        });
    </script>
@endsection
