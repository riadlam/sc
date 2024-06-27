<script>
    (function ($){
        $(document).ready(function (){
            // $(document).on('click', '.payment-gateway-wrapper li', function (){
            //     let el = $(this);
            //     let payment_gateway_wrapper = $('.payment-gateway-wrapper');
            //     let selected_payment_gateway = $('input[name=selected_payment_gateway]');
            //
            //     payment_gateway_wrapper.find('li').removeClass('selected');
            //     payment_gateway_wrapper.find('li').css('opacity', '0.7');
            //     selected_payment_gateway.val('');
            //
            //     el.addClass('selected');
            //     el.css('opacity', '1');
            //     selected_payment_gateway.val(el.data('gateway'));
            //
            //     if (el.data('gateway') === 'manual_payment')
            //     {
            //         payment_gateway_wrapper.append('<input class="form-control manual_payment_image mt-4" type="file" name="manual_payment_image" accept="image/*"></input>')
            //     } else{
            //         $('.manual_payment_image').remove();
            //     }
            // });


            var defaulGateway = $('#site_global_payment_gateway').val();
            $('.payment-gateway-wrapper ul li[data-gateway="' + defaulGateway + '"]').addClass('selected');

            let customFormParent = $('.payment_gateway_extra_field_information_wrap');
            customFormParent.children().hide();

            $(document).on('click', '.payment-gateway-wrapper > ul > li', function (e) {
                e.preventDefault();

                let gateway = $(this).data('gateway');
                let manual_transaction_div = $('.manual_transaction_id');
                let summernot_wrap_div = $('.summernot_wrap');

                customFormParent.children().hide();
                if (gateway === 'manual_payment') {
                    manual_transaction_div.fadeIn();
                    summernot_wrap_div.fadeIn();
                    manual_transaction_div.removeClass('d-none');
                } else {
                    manual_transaction_div.addClass('d-none');
                    summernot_wrap_div.fadeOut();
                    manual_transaction_div.fadeOut();

                    let wrapper = customFormParent.find('#'+gateway+'-parent-wrapper');
                    if (wrapper.length > 0)
                    {
                        wrapper.fadeIn();
                    }
                }

                $(this).addClass('selected').siblings().removeClass('selected');
                $('.payment-gateway-wrapper').find(('input')).val($(this).data('gateway'));
                $('.payment_gateway_passing_clicking_name').val($(this).data('gateway'));
            });
        });
    })(jQuery);
</script>
