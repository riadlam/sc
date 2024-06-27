@extends('tenant.admin.admin-master')
@section('title')
    {{ __('Product Settings') }}
@endsection

@section('style')
    <style>
        .product_image{
            max-width: 100px;
        }
        .star{
            color: gray;
            font-size: 20px;
        }
        .star.checked{
            color: orange;
        }
    </style>
@endsection

@section('content')
    <div class="dashboard-recent-order">
        <div class="row">
            <x-flash-msg/>

            <div class="col-lg-12 mt-4">
                <div class="recent-order-wrapper dashboard-table bg-white">
                    <div class="product-list-title-flex d-flex flex-wrap align-items-center justify-content-between">
                        <h3>{{__('Product Global Settings')}}</h3>
                    </div>

                    <div class="card">
                        <div class="card-body">
                            <form class="forms-sample" method="post" action="{{route('tenant.admin.product.settings')}}">
                                @csrf

                                <x-fields.input type="number" value="{{get_static_option('product_title_length')}}" name="product_title_length"
                                                label="{{__('Product Title Length')}}"
                                                info="{{__('It will limit every product title word length on the whole site')}}"
                                                tooltip="{{__('asd')}}" direction="right"/>

                                <x-fields.input type="number" value="{{get_static_option('product_description_length')}}" name="product_description_length"
                                                label="{{__('Product Description Length')}}"
                                                info="{{__('It will limit every product description word length on the whole site')}}"
                                                tooltip="{{__('asd')}}" direction="right"/>

                                <button type="submit" class="btn btn-gradient-primary mt-5 me-2">{{__('Save Changes')}}</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <x-product::table.status-js />
    <x-product::table.bulk-action-js :url="route('tenant.admin.product.bulk.destroy')"/>
    <script>
        $(function (){
            $("#search-date_range").flatpickr({
                mode: "range",
                dateFormat: "Y-m-d",
            });

            $("#product-search-form").fadeOut();
            $(document).on("click","#product-list-title-flex h3", function (){
                $("#product-search-form").slideToggle();
            })

            $(document).ready(function (){
                $(".loader").hide();
            })

            $(document).on("click","#product-search-button", function (){
                $("#product-search-form").trigger("submit");
            });

            $(document).on("submit","#product-search-form", function (e){
                e.preventDefault();
                let form_data = $("#product-search-form").serialize().toString();
                form_data += "&count=" + $("#number-of-item").val();

                // product-table-body
                send_ajax_request("GET",null,$(this).attr("action") + "?" + form_data, () => {
                    // before send request
                    $(".loader").fadeIn();
                }, (data) => {
                    $("#product-table-body").html(data);
                    $(".loader").fadeOut();
                }, (data) => {
                    prepare_errors(data);
                });
            });

            $(document).on("change","#number-of-item", function (e){
                e.preventDefault();
                let form_data = $("#product-search-form").serialize().toString()
                form_data += "&count=" + $(this).val();

                // product-table-body
                send_ajax_request("GET",null,$("#product-search-form").attr("action") + "?" + form_data, () => {
                    // before send request
                    $(".loader").show();
                }, (data) => {
                    $("#product-table-body").html(data);
                    $(".loader").hide();
                }, (data) => {
                    prepare_errors(data);
                });
            });

            /*
            ========================================
                Row Remove Click Delete
            ========================================
            */
            $(document).on("click", ".pagination-list li a", function(e) {
                e.preventDefault();

                $(".pagination-list li a").removeClass("current");
                $(this).addClass("current");

                // product-table-body
                send_ajax_request("GET",null,$(this).attr("href"), () => {
                    // before send request
                    $(".loader").show();
                }, (data) => {
                    $("#product-table-body").html(data);
                    $(".loader").hide();
                }, (data) => {
                    prepare_errors(data);
                });
            });

            $(document).on("click", ".delete-row", function(e) {
                e.preventDefault();
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        send_ajax_request("GET",null,$(this).data("product-url"), () => {
                            // before send request
                            toastr.warning("Request send please wait while");
                        }, (data) => {
                            Swal.fire(
                                'Deleted!',
                                'Your file has been deleted.',
                                'success'
                            );

                            let product = $(this).parent().parent().parent();
                            product.fadeOut();

                            setTimeout(() => {
                                product.remove();
                                $(".tenant_info").load(location.href + " .tenant_info");
                                ajax_toastr_success_message(data);
                            }, 800)

                        }, (data) => {
                            prepare_errors(data);
                        })
                    }
                });
            });

            function send_ajax_request(request_type, request_data, url, before_send, success_response, errors) {
                $.ajax({
                    url: url,
                    type: request_type,
                    headers: {
                        'X-CSRF-TOKEN': "{{csrf_token()}}",
                    },
                    beforeSend: (typeof before_send !== "undefined" && typeof before_send === "function") ? before_send : () => {
                        return "";
                    },
                    processData: false,
                    contentType: false,
                    data: request_data,
                    success: (typeof success_response !== "undefined" && typeof success_response === "function") ? success_response : () => {
                        return "";
                    },
                    error: (typeof errors !== "undefined" && typeof errors === "function") ? errors : () => {
                        return "";
                    }
                });
            }

            function prepare_errors(data, form, msgContainer, btn) {
                let errors = data.responseJSON;

                if (errors.success != undefined) {
                    toastr.error(errors.msg.errorInfo[2]);
                    toastr.error(errors.custom_msg);
                }

                $.each(errors.errors, function (index, value) {
                    console.log(value)
                    toastr.error(value[0]);
                });
            }


            function ajax_toastr_error_message(xhr) {
                $.each(xhr.responseJSON.errors, function (key, value) {
                    toastr.error((key.capitalize()).replace("-", " ").replace("_", " "), value);
                });
            }

            function ajax_toastr_success_message(data) {
                if (data.success) {
                    toastr.success(data.msg)
                } else {
                    toastr.warning(data.msg);
                }
            }
        });
    </script>
@endsection
