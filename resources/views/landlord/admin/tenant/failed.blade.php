@php
    $route_name ='landlord';
@endphp

@extends($route_name.'.admin.admin-master')
@section('title')
    {{__('All Failed Tenants')}}
@endsection

@section('style')
    <x-datatable.css/>
    <x-summernote.css/>
@endsection

@section('content')
    <div class="col-12 stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-4">{{__('All Failed Tenants')}}</h4>

                <x-error-msg/>
                <x-flash-msg/>

                <x-datatable.table>
                    <x-slot name="th">
                        <th>{{__('Tenant Name')}}</th>
                        <th>{{__('Domain')}}</th>
                        <th>{{__('Theme')}}</th>
                        <th>{{__('Payment Status')}}</th>
                        <th>{{__('Payment Log')}}</th>
                        <th>{{__('Action')}}</th>
                    </x-slot>
                    <x-slot name="tr">
                        @foreach($tenants as $user)
                            <tr>
                                <td>{{$user->id}}</td>
                                <td>{{$user->id.'.'.env('CENTRAL_DOMAIN')}}</td>
                                <td>{{$user->theme_slug}}</td>
                                <td>{{$user?->payment_log?->payment_status}}</td>
                                <td>
                                    @if(!empty($user?->payment_log))
                                        @php
                                            $payment_log = $user?->payment_log;
                                        @endphp
                                        <a class="btn btn-info btn-sm payment_log_modal_open_btn"
                                           href="javascript:void(0)"
                                           data-bs-target="#tenant_payment_log_modal"
                                           data-bs-toggle="modal"
                                           data-email="{{$payment_log?->email}}"
                                           data-name="{{$payment_log?->name}}"
                                           data-package="{{$payment_log?->package_name}}"
                                           data-gateway="{{$payment_log?->package_gateway}}"
                                           data-tenant="{{$payment_log?->tenant_id}}"
                                           data-theme="{{$payment_log?->theme_slug}}"
                                           data-status="{{$payment_log?->status}}"
                                           data-payment_status="{{$payment_log?->payment_status}}"
                                           data-transaction_id="{{$payment_log?->transaction_id}}"
                                           data-created_at="{{$payment_log?->created_at}}"
                                        >{{__('Open Log')}}</a>
                                    @endif
                                </td>
                                <td>
                                    <x-delete-popover url="{{route('landlord.admin.tenant.failed.delete',$user->id)}}"
                                                      popover="{{__('Delete')}}"/>

                                    <x-modal.button target="tenant_edit" extra="tenant_edit_btn" type="info"
                                                    dataid="{{$user->id}}">
                                        <i class="mdi mdi-pencil"></i>
                                    </x-modal.button>

                                    <x-modal.button target="user_add_subscription" extra="user_add_subscription"
                                                    type="success" dataid="{{$user->id}}" datastatus="{{$user?->payment_log?->status}}"
                                                    datauser="{{ !empty($user?->payment_log?->user_id) }}">
                                        {{__('Regenerate')}}
                                    </x-modal.button>

                                    @if(empty($user->payment_log))
                                        <x-modal.button target="tenant_create_payment_log_modal"
                                                        extra="tenant_create_payment_log_modal"
                                                        type="primary" dataid="{{$user->id}}">
                                            {{__('Create Payment Log')}}
                                        </x-modal.button>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </x-slot>
                </x-datatable.table>
            </div>
        </div>
    </div>


    {{--Assign Subscription Modal--}}
    <div class="modal fade" id="user_add_subscription" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{__('Regenerate Tenant')}}</h5>
                    <button type="button" class="close" data-bs-dismiss="modal"><span>×</span></button>
                </div>

                <form action="{{route('landlord.admin.tenant.failed.assign.subscription')}}"
                      id="user_add_subscription_form"
                      method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" name="subs_tenant_id" id="subs_user_id">
                        <input type="hidden" name="subs_pack_id" id="subs_pack_id">

                        {{--                        <div class="form-group user-select-wrapper" style="display: none">--}}
                        {{--                            <label for="subdomain">{{__('User')}}</label>--}}
                        {{--                            <select class="form-select user" id="user" name="user">--}}
                        {{--                                <option value="" selected disabled>{{__('Select an user')}}</option>--}}
                        {{--                                @foreach($users as $user)--}}
                        {{--                                    <option value="{{$user->id}}">{{$user->name}}</option>--}}
                        {{--                                @endforeach--}}
                        {{--                            </select>--}}
                        {{--                        </div>--}}

                        {{--                        <div class="form-group custom_subdomain_wrapper mt-3">--}}
                        {{--                            <label for="custom-subdomain">Add new subdomain</label>--}}
                        {{--                            <input class="form--control custom_subdomain" id="custom-subdomain" type="text"--}}
                        {{--                                   autocomplete="off" value="{{old('subdomain')}}"--}}
                        {{--                                   placeholder="{{__('Subdomain')}}"--}}
                        {{--                                   style="border:0;border-bottom: 1px solid #595959;width: 100%">--}}
                        {{--                            <div id="subdomain-wrap"></div>--}}
                        {{--                        </div>--}}

                        {{--                        <div class="form-group mt-3">--}}
                        {{--                            @php--}}
                        {{--                                $themes = getAllThemeSlug();--}}
                        {{--                            @endphp--}}
                        {{--                            <label for="custom-theme">{{__('Add Theme')}}</label>--}}
                        {{--                            <select class="form-select text-capitalize" name="custom_theme" id="custom-theme">--}}
                        {{--                                @foreach($themes as $theme)--}}
                        {{--                                    <option value="{{$theme}}">{{$theme}}</option>--}}
                        {{--                                @endforeach--}}
                        {{--                            </select>--}}
                        {{--                        </div>--}}

                        {{--                        <div class="form-group">--}}
                        {{--                            <label for="">{{__('Select A Package')}}</label>--}}
                        {{--                            <select class="form-control package_id_selector" name="package">--}}
                        {{--                                <option value="">{{__('Select Package')}}</option>--}}
                        {{--                                @foreach(\App\Models\PricePlan::all() as $price)--}}
                        {{--                                    <option value="{{$price->id}}" data-id="{{$price->id}}">--}}
                        {{--                                        {{$price->title}} {{ '('.float_amount_with_currency_symbol($price->price).')' }}--}}
                        {{--                                        - {{\App\Enums\PricePlanTypEnums::getText($price->type)}}--}}
                        {{--                                    </option>--}}
                        {{--                                @endforeach--}}
                        {{--                            </select>--}}
                        {{--                        </div>--}}

                        {{--                        <div class="form-group">--}}
                        {{--                            <label for="">{{__('Database Name')}}</label>--}}
                        {{--                            <input class="form-control database-name" type="text" name="database_name" id="database-name" autocomplete="off" placeholder="Database name">--}}
                        {{--                            <p class="bg-warning">--}}
                        {{--                                <small class="text-dark ms-2">{{__('Set your database name here.')}}</small>--}}
                        {{--                            </p>--}}
                        {{--                        </div>--}}

                        {{--                        <div class="form-group">--}}
                        {{--                            <label for="">{{__('Payment Status')}}</label>--}}
                        {{--                            <select class="form-control" name="payment_status">--}}
                        {{--                                <option value="complete">{{__('Complete')}}</option>--}}
                        {{--                                <option value="pending">{{__('Pending')}}</option>--}}
                        {{--                            </select>--}}
                        {{--                            <p>--}}
                        {{--                                <small class="text-primary">{{__('You can set payment status pending or complete from here')}}</small>--}}
                        {{--                            </p>--}}
                        {{--                        </div>--}}

                        <div class="form-group">
                            <label for="">{{__('Account Status')}}</label>
                            <select class="form-control" name="account_status">
                                <option value="complete">{{__('Complete')}}</option>
                                <option value="pending">{{__('Pending')}}</option>
                                <option value="trial">{{__('Trial')}}</option>
                            </select>
                            <p>
                                <small
                                    class="text-primary">{{__('You can set account status pending or complete from here')}}</small>
                            </p>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{__('Close')}}</button>
                        <button type="submit" class="btn btn-primary">{{__('Submit')}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{--Change Domain Modal--}}
    <div class="modal fade" id="tenant_edit" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{__('Edit Tenant')}}</h5>
                    <button type="button" class="close" data-bs-dismiss="modal"><span>×</span></button>
                </div>

                <form action="{{route('landlord.admin.tenant.failed.edit')}}" id="tenant_edit_modal_form" method="post">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" name="tenant_id" id="tenant_id">
                        <div class="form-group">
                            <label for="password">{{__('Domain Name')}}</label>
                            <input type="text" class="form-control" name="tenant_name"
                                   placeholder="{{__('Enter Domain Name')}}">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{__('Close')}}</button>
                        <button type="submit" class="btn btn-primary">{{__('Update')}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{--Payment Log Modal--}}
    <div class="modal fade" id="tenant_payment_log_modal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{__('Tenant Payment Log')}}</h5>
                    <button type="button" class="close" data-bs-dismiss="modal"><span>×</span></button>
                </div>

                <div class="modal-body">

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">{{__('Close')}}</button>
                </div>
            </div>
        </div>
    </div>

    {{--Create Payment Log Modal--}}
    <div class="modal fade" id="tenant_create_payment_log_modal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{__('Create Tenant Payment Log')}}</h5>
                    <button type="button" class="close" data-bs-dismiss="modal"><span>×</span></button>
                </div>

                <form action="{{route('landlord.admin.tenant.failed.manual.paymentlog')}}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" name="tenant_id" id="tenant_id">

                        <div class="form-group user-select-wrapper">
                            <label for="subdomain">{{__('User')}}</label>
                            <select class="form-select user" id="user" name="user">
                                <option value="" selected disabled>{{__('Select an user')}}</option>
                                @foreach($users as $user)
                                    <option value="{{$user->id}}">{{$user->name}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group custom_subdomain_wrapper mt-3">
                            <label for="custom-subdomain">{{__('Add new subdomain')}}</label>
                            <input class="form--control custom_subdomain" id="custom-subdomain" type="text"
                                   autocomplete="off" value="{{old('subdomain')}}"
                                   placeholder="{{__('Subdomain')}}"
                                   style="border:0;border-bottom: 1px solid #595959;width: 100%">
                            <div id="subdomain-wrap"></div>
                        </div>

                        <div class="form-group mt-3">
                            @php
                                $themes = getAllThemeSlug();
                            @endphp
                            <label for="custom-theme">{{__('Add Theme')}}</label>
                            <select class="form-select text-capitalize" name="custom_theme" id="custom-theme">
                                @foreach($themes as $theme)
                                    <option value="{{$theme}}">{{$theme}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="">{{__('Select A Package')}}</label>
                            <select class="form-control package_id_selector" name="package">
                                <option value="">{{__('Select Package')}}</option>
                                @foreach(\App\Models\PricePlan::all() as $price)
                                    <option value="{{$price->id}}" data-id="{{$price->id}}">
                                        {{$price->title}} {{ '('.float_amount_with_currency_symbol($price->price).')' }}
                                        - {{\App\Enums\PricePlanTypEnums::getText($price->type)}}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="">{{__('Payment Status')}}</label>
                            <select class="form-control" name="payment_status">
                                <option value="complete">{{__('Complete')}}</option>
                                <option value="pending">{{__('Pending')}}</option>
                            </select>
                            <p>
                                <small
                                    class="text-primary">{{__('You can set payment status pending or complete from here')}}</small>
                            </p>
                        </div>

                        <div class="form-group">
                            <label for="">{{__('Account Status')}}</label>
                            <select class="form-control" name="status">
                                <option value="complete">{{__('Complete')}}</option>
                                <option value="pending">{{__('Pending')}}</option>
                            </select>
                            <p>
                                <small
                                    class="text-primary">{{__('You can set payment status pending or complete from here')}}</small>
                            </p>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">{{__('Close')}}</button>
                        <button type="submit" class="btn btn-success">{{__('Create')}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{--Send Mail Modal--}}
    <div class="modal fade" id="send_mail_to_tenant_modal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{__('Send Mail To Subscriber')}}</h5>
                    <button type="button" class="close" data-bs-dismiss="modal"><span>×</span></button>
                </div>
                <form action="{{route(route_prefix().'admin.tenant.send.mail')}}"
                      id="send_mail_to_subscriber_edit_modal_form" method="post">
                    <div class="modal-body">
                        @csrf
                        <div class="form-group">
                            <label for="email">{{__('Email')}}</label>
                            <input type="text" readonly class="form-control" id="email" name="email"
                                   placeholder="{{__('Email')}}">
                        </div>
                        <div class="form-group">
                            <label for="edit_icon">{{__('Subject')}}</label>
                            <input type="text" class="form-control" id="subject" name="subject"
                                   placeholder="{{__('Subject')}}">
                        </div>
                        <div class="form-group">
                            <label for="message">{{__('Message')}}</label>
                            <input type="hidden" name="message">
                            <div class="summernote"></div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{__('Close')}}</button>
                        <button id="submit" type="submit" class="btn btn-primary">{{__('Send Mail')}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <x-datatable.js/>
    <x-summernote.js/>
    <x-custom-js.landloard-unique-subdomain-check :name="'custom_subdomain'"/>
    {{--subdomain check--}}

    <script>
        $(document).ready(function () {
            let theme_selected_first = false; // if theme selected first then after domain selection do not change theme again

            $(document).on('click', '.tenant_edit_btn', function () {
                let el = $(this);
                let id = el.data('id');

                let modal = $('#tenant_edit_modal_form');
                modal.find('input[name=tenant_id]').val(id);
                modal.find('input[name=tenant_name]').val(id);
            });


            $(document).on('click', '.payment_log_modal_open_btn', function () {
                let el = $(this);
                let email = el.data('email');
                let name = el.data('name');
                let package = el.data('package');
                let gateway = el.data('gateway');
                let tenant = el.data('tenant');
                let theme = el.data('theme');
                let status = el.data('status');
                let payment_status = el.data('payment_status');
                let transaction_id = el.data('transaction_id');
                let created_at = el.data('created_at');

                let modal = $('#tenant_payment_log_modal');

                let markup = ``;
                markup += `<h4>{{__('User Information')}}</h4>`;
                markup += `<hr class="my-2">`;
                markup += `<p>{{__('User Email:')}} ${email}</p>`;
                markup += `<p>{{__('User Name:')}} ${name}</p>`;
                markup += `<p>{{__('Tenant:')}} ${tenant}</p>`;
                markup += `<p>{{__('Account Status:')}} ${status}</p>`;

                markup += `<h4 class='mt-5'>{{__('Theme Information')}}</h4>`;
                markup += `<hr class="my-2">`;
                markup += `<p>{{__('Theme:')}} ${theme}</p>`;

                markup += `<h4 class='mt-5'>{{__('Payment Information')}}</h4>`;
                markup += `<hr class="my-2">`;
                markup += `<p>{{__('Package:')}} ${package}</p>`;
                markup += `<p>{{__('Payment Gateway:')}} ${gateway}</p>`;
                let color = 'text-danger';
                if (payment_status === 'complete') {
                    color = 'text-success';
                }
                markup += `<p class='${color}'>{{__('Payment Status:')}} ${payment_status}</p>`;
                markup += `<p>{{__('Transaction ID:')}} ${transaction_id}</p>`;
                markup += `<p>{{__('Payment Date:')}} ${created_at}</p>`;

                modal.find('.modal-body').children().remove();
                modal.find('.modal-body').append(markup);
            });

            $(document).on('click', '.tenant_create_payment_log_modal', function (){
                let el = $(this);
                let tenant_id = el.data('id');
                let modal = $('#tenant_create_payment_log_modal');

                modal.find('input#tenant_id').val(tenant_id);
            });

            //Assign Subscription Modal Code
            $(document).on('click', '.user_add_subscription', function () {
                let user_id = $(this).data('id');
                let user = $(this).data('user');
                let status = $(this).data('status');

                $('#subs_user_id').val(user_id);
                let user_wrapper = $('.user-select-wrapper');
                user_wrapper.hide();

                if (!user) {
                    user_wrapper.show();
                }

                let modal = $('#user_add_subscription');
                modal.find(`select option`).attr('selected', false);

                if (status !== undefined)
                {
                    modal.find(`select option[value=${status}]`).attr('selected', true);
                }
            });

            $(document).on('change', '.package_id_selector', function () {
                let el = $(this);
                let form = $('.user_add_subscription_form');
                $('#subs_pack_id').val(el.val());
            });


            let custom_subdomain_wrapper = $('.custom_subdomain_wrapper');
            custom_subdomain_wrapper.hide();
            $(document).on('change', '#subdomain', function (e) {
                let el = $(this);
                let subdomain_type = el.val();

                if (subdomain_type == 'custom_domain__dd') {
                    custom_subdomain_wrapper.slideDown();
                    custom_subdomain_wrapper.find('#custom-subdomain').attr('name', 'custom_subdomain');
                } else {
                    custom_subdomain_wrapper.slideUp();
                    custom_subdomain_wrapper.removeAttr('#custom-subdomain').attr('name', 'custom_subdomain');
                }
            });

            $(document).on('change', '#subdomain', function () {
                let el = $(this).parent().parent().find(".form-group #custom-theme");
                let subdomain = $(this).val();

                if (!theme_selected_first) {
                    $.ajax({
                        url: '{{route('landlord.admin.tenant.check.subdomain.theme')}}',
                        type: 'POST',
                        data: {
                            _token: '{{csrf_token()}}',
                            subdomain: subdomain
                        },
                        beforeSend: function () {
                            el.find('option').attr('selected', false);
                        },
                        success: function (res) {
                            el.find("option[value=" + res.theme_slug + "]").attr('selected', true);
                        }
                    });
                }
            });

            $(document).on('change', '#custom-theme', function () {
                theme_selected_first = true;
            });

            $(document).on('submit', '#user_add_subscription_form', function () {
                $(this).find('button[type=submit]').attr('disabled', true);
            });
        });
    </script>

    <script>
        (function ($) {
            "use strict";
            $(document).ready(function () {

                $(document).on('click', '.send_mail_to_tenant_btn', function () {
                    var el = $(this);
                    var email = el.data('id');

                    var form = $('#send_mail_to_subscriber_edit_modal_form');
                    form.find('#email').val(email);
                });
                $('.summernote').summernote({
                    height: 300,   //set editable area's height
                    codemirror: { // codemirror options
                        theme: 'monokai'
                    },
                    callbacks: {
                        onChange: function (contents, $editable) {
                            $(this).prev('input').val(contents);
                        }
                    }
                });
            });

        })(jQuery)
    </script>
@endsection

