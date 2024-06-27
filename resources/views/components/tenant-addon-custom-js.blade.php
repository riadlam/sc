<script>
    $(function () {
        $(document).ready(function () {
            $(document).on('click', '.physical-explore-category-area .store-tabs .list', function (e) {
                e.preventDefault();

                let el = $(this);
                let tab = el.data('tab');
                let limit = el.data('limit');
                let allId = el.data('all-id');
                let sort_by = el.data('sort_by');
                let sort_to = el.data('sort_to');

                $.ajax({
                    type: 'GET',
                    url: "{{route('tenant.category.wise.product.bookpoint.physical')}}",
                    data: {
                        category: tab,
                        limit: limit,
                        allId: allId,
                        sort_by: sort_by,
                        sort_to: sort_to
                    },
                    beforeSend: function () {
                        $('.loader').fadeIn(200);
                    },
                    success: function (data) {
                        let tab = $('li.list[data-tab=' + data.category + ']');
                        let markup_wrapper = $('.physical-explore-category-area .markup_wrapper');

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

            $(document).on('click', '.digital-explore-category-area .store-tabs .list', function (e) {
                e.preventDefault();

                let el = $(this);
                let tab = el.data('tab');
                let limit = el.data('limit');
                let allId = el.data('all-id');
                let sort_by = el.data('sort_by');
                let sort_to = el.data('sort_to');

                $.ajax({
                    type: 'GET',
                    url: "{{route('tenant.category.wise.product.bookpoint')}}",
                    data: {
                        category: tab,
                        limit: limit,
                        allId: allId,
                        sort_by: sort_by,
                        sort_to: sort_to
                    },
                    beforeSend: function () {
                        $('.loader').fadeIn(200);
                    },
                    success: function (data) {
                        let tab = $('li.list[data-tab=' + data.category + ']');
                        let markup_wrapper = $('.digital-explore-category-area .markup_wrapper');

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
    });
</script>

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
                url: "{{route('tenant.category.wise.product.casual')}}",
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
