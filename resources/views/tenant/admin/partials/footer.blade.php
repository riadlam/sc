<footer class="footer">
    <div class="container-fluid d-flex justify-content-between">
        <span class="text-muted d-block text-center text-sm-start d-sm-inline-block">
            {!! get_footer_copyright_text(\App\Facades\GlobalLanguage::default_slug()) !!}
        </span>
        <span class="float-none float-sm-end mt-1 mt-sm-0 text-end"> v- <strong>{{get_static_option_central('get_script_version')}}</strong></span>
    </div>
</footer>
</div>
</div>
</div>

<script src="{{global_asset('assets/landlord/admin/js/vendor.bundle.base.js')}}"></script>
<script src="{{global_asset('assets/landlord/admin/js/hoverable-collapse.js')}}"></script>
<script src="{{global_asset('assets/landlord/admin/js/off-canvas.js')}}"></script>
<script src="{{global_asset('assets/landlord/admin/js/misc.js')}}"></script>
<script src="{{global_asset('assets/landlord/common/js/axios.min.js')}}"></script>
<script src="{{global_asset('assets/landlord/common/js/sweetalert2.js')}}"></script>
<script src="{{global_asset('assets/common/js/countdown.jquery.js')}}"></script>
<script src="{{global_asset('assets/common/js/flatpickr.js')}}"></script>
<x-flatpicker.flatpickr-locale/>
<script src="{{global_asset('assets/common/js/toastr.min.js')}}"></script>
<script src="{{global_asset('assets/common/js/select2.min.js')}}"></script>
<script>
    const translatedDataTable = () => {
        return {
            "decimal": "",
            "emptyTable": "{{__('No data available in table')}}",
            "info": "{{__('Showing')}} _START_ {{__('to')}} _END_ {{__('of')}} _TOTAL_ {{__('entries')}}",
            "infoEmpty": "{{__('Showing')}} 0 {{__('to')}} 0 {{__('of')}} 0 {{__('entries')}}",
            "infoFiltered": "({{__('filtered from')}} _MAX_ {{__('total entries')}})",
            "infoPostFix": "",
            "thousands": ",",
            "lengthMenu": "{{__('Show')}} _MENU_ {{__('entries')}}",
            "loadingRecords": "{{__('Loading...')}}",
            "processing": "",
            "search": "{{__('Search:')}}",
            "zeroRecords": "{{__('No matching records found')}}",
            "paginate": {
                "first": "{{__('First')}}",
                "last": "{{__('Last')}}",
                "next": "{{__('Next')}}",
                "previous": "{{__('Previous')}}"
            },
            "aria": {
                "sortAscending": ": activate to sort column ascending",
                "sortDescending": ": activate to sort column descending"
            }
        }
    }

    (function($){
        "use strict";

        $(document).ready(function ($) {
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
            var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl)
            })

            $('select.select2').select2();
            $(document).on('click','.swal_delete_button',function(e){
                e.preventDefault();
                Swal.fire({
                    title: '{{__("Are you sure?")}}',
                    text: '{{__("You would not be able to revert this item!")}}',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: "{{__('Yes, delete it!')}}",
                    cancelButtonText: "{{__('Cancel')}}",
                }).then((result) => {
                    if (result.isConfirmed) {
                        $(this).next().find('.swal_form_submit_btn').trigger('click');
                    }
                });
            });

            $(document).on('click','.swal_change_language_button',function(e){
                e.preventDefault();
                Swal.fire({
                    title: '{{__("Are you sure to make this language as a default language?")}}',
                    text: '{{__("Languages will be turn changed as default")}}',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: "{{__('Yes, Change it!')}}",
                    cancelButtonText: "{{__('Cancel')}}",
                }).then((result) => {
                    if (result.isConfirmed) {
                        $(this).next().find('.swal_form_submit_btn').trigger('click');
                    }
                });
            });

            $(document).on('click','.swal_change_approve_payment_button',function(e){
                e.preventDefault();
                Swal.fire({
                    title: '{{__("Are you sure to approve this payment?")}}',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: "{{__('Yes, Accept it!')}}",
                    cancelButtonText: "{{__('Cancel')}}",
                }).then((result) => {
                    if (result.isConfirmed) {
                        $(this).next().find('.swal_form_submit_btn').trigger('click');
                    }
                });
            });

            let light = false;
            $(document).on('click', '.tenant_info_icon', function(){
                $('.tenant_info_list').slideToggle(300);
                if(light === false){
                    $('.tenant_info_icon i').removeClass('mdi-lightbulb-on-outline');
                    $('.tenant_info_icon i').addClass('mdi-lightbulb-on');
                    $('.tenant_info_list').addClass('open-info');
                    light = true;
                } else {
                    $('.tenant_info_icon i').addClass('mdi-lightbulb-on-outline');
                    $('.tenant_info_icon i').removeClass('mdi-lightbulb-on');
                    $('.tenant_info_list').removeClass('open-info');
                    light = false;
                }
            });

            $(document).on('click', '.submenu-disabled', function (e){
                e.preventDefault();

                let text = $(this).text();

                Swal.fire({
                    title: '{{__("Coming Soon")}}'+'\n'+text,
                    text: '{{__("This feature is currently under development and will be available soon. We are committed to continuously enhancing our application to provide you with the best possible user experience.")}}',
                    icon: 'info',
                    showCancelButton: false,
                    confirmButtonColor: '#3fc3ee',
                    confirmButtonText: "{{__('Got it')}}",
                });
            });
        });
    })(jQuery);

    window.addEventListener('click', function(e){
        if (!document.getElementById('tenant_info_list').contains(e.target)){
            if($('.open-info').length == 1)
            {
                $('.tenant_info_icon').trigger('click');
            }
        }
    });
</script>

<script>
    $(".date").flatpickr({
        enableTime: true,
        minDate: "today",
        time_12hr: true,
        altInput: true,
        defaultDate: "2018-04-24 16:57"
    });
</script>
@yield('scripts')
</body>
</html>
