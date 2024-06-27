@extends(route_prefix().'admin.admin-master')
@section('title')
    {{__('All Themes')}}
@endsection

@section('style')
    <x-datatable.css/>
    <x-media-upload.css/>

    <style>
        .modal-image {
            width: 100%;
        }
    </style>
@endsection

@section('content')
    <div class="col-12 stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <x-admin.header-wrapper>
                        <x-slot name="left">
                            <h4 class="card-title mb-4">{{__('All Themes')}}</h4>
                            <p>{{__('Note : By default every theme button is showing (Inactive) so that means if you click on (Inactive) it will be hide or inactive from frontend, At the same way when it will show active that means this is inactive you can active by clicking it.')}}</p>
                        </x-slot>
                        <x-slot name="right" class="d-flex">
                        </x-slot>
                    </x-admin.header-wrapper>
                    <x-error-msg/>
                    <x-flash-msg/>
                </div>

                <div class="row g-4">
                    @foreach(getAllThemeDataForAdmin() as $theme)
                        @php
                            $theme_slug = $theme->slug;
                            $theme_data = getIndividualThemeDetails($theme_slug);
                            $theme_image = loadScreenshot($theme_slug);
                            $status = $theme->status ? 'inactive' : 'active';
                        @endphp
                        <div class="col-xl-3 col-md-6">
                            @php
                                $theme_name = get_static_option_central($theme_data['slug'].'_theme_name');
                                $theme_description = get_static_option_central($theme_data['slug'].'_theme_description');
                                $theme_url = get_static_option_central($theme_data['slug'].'_theme_url');
                                $custom_theme_id = get_static_option_central($theme_data['slug'].'_theme_image_id');
                                $custom_theme_image = get_static_option_central($theme_data['slug'].'_theme_image');
                            @endphp
                            <div class="themePreview">
                                <p class="themePreview-btn {{$theme->status == 'active' ? '' : 'inactivated'}}" data-slug="{{$theme_slug}}">{{$theme->status == 'active' ? __('Activated') : __('Inactivated')}}</p>
                                <a href="javascript:void(0)" id="theme-preview" data-bs-target="#theme-modal"
                                   data-bs-toggle="modal"
                                   data-slug="{{$theme_data['slug']}}"
                                   data-name="{{ !empty($theme_name) ? $theme_name : $theme_data['name']}}"
                                   data-description="{{ !empty($theme_description) ? $theme_description : $theme_data['description']}}"
                                   data-image="{{ !empty($custom_theme_image) ? $custom_theme_image : $theme_image}}"
                                   data-image_id="{{ $custom_theme_id}}"
                                   data-button_text="{{$status}}"
                                   data-url="{{ !empty($theme_url) ? $theme_url : ''}}"
                                   class="theme-preview"
                                >
                                    <div class="bg"
                                         style="background-image: url('{{ !empty($custom_theme_image) ? $custom_theme_image : $theme_image}}');"></div>
                                </a>

                                <div class="themeInfo themeInfo_{{$theme_data['slug']}}" data-slug="{{$theme_data['slug']}}">
                                    <h3 class="themeName text-center"></h3>
                                </div>

                                <div class="themeLink">
                                    <h3 class="themeName">{{ !empty($theme_name) ? $theme_name : $theme_data['name']}}</h3>
                                    <a href="javascript:void(0)"
                                       class="active-btn text-capitalize theme_status_update_button"
                                       data-slug="{{$theme_data['slug']}}"
                                       data-status="{{$status}}"
                                    >{{$status}}</a>
                                </div>
                            </div>
                        </div>
                    @endforeach

                    @if(get_static_option('up_coming_themes_backend'))
                        @foreach(range(4, 14) as $item)
                            <div class="col-xl-3 col-md-6">
                                <div class="themePreview coming_soon">
                                    <a href="javascript:void(0)" id="theme-preview"
                                       data-bs-toggle="modal"
                                       class="theme-preview">
                                        <div class="bg"
                                             style="background-image: url('{{get_theme_image('theme-'.$item)}}');"></div>
                                    </a>
                                    <div class="coming-soon-theme">{{__('Coming Soon')}}</div>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>

    <x-modal.theme-modal :target="'theme-modal'" :title="'Theme'" :user="'admin'"/>

    <div class="modal fade" id="edit-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">{{__('Edit Theme Details')}}</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{route('landlord.admin.theme.update')}}" method="POST">
                        @csrf
                        <input type="hidden" name="theme_slug" value="">
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="theme-name">{{__('Name')}}</label>
                                    <input type="text" class="form-control" name="theme_name" id="theme-name">
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-group">
                                    <label for="theme-name">{{__('Description')}}</label>
                                    <textarea class="form-control" name="theme_description" id="theme-description"
                                              rows="10"></textarea>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-group">
                                    <label for="theme-url">{{__('Theme URL')}}</label>
                                    <input type="text" class="form-control" name="theme_url" id="theme-url">
                                </div>
                            </div>

                            <div class="col-12">
                                <x-fields.theme-media-upload name="theme_image" title="{{__('Theme Image')}}"/>
                            </div>
                        </div>

                        <div class="form-group d-flex justify-content-end">
                            <button type="submit" class="btn btn-success">{{__('Update')}}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <x-media-upload.markup/>
@endsection
@section('scripts')
    <x-media-upload.js/>
    <x-datatable.js/>
    <script>
        $(document).ready(function ($) {
            "use strict";

            $('.themeInfo').hide();
            $('.modal-success-msg').hide()

            $(document).on('change', 'select[name="lang"]', function (e) {
                $(this).closest('form').trigger('submit');
                $('input[name="lang"]').val($(this).val());
            });


            $(document).on('click', '#theme-preview', function (e) {
                let el = $(this);
                let slug = el.data('slug');
                let name = el.data('name');
                let description = el.data('description');
                let button_text = el.attr('data-button_text');
                let image = el.data('image');
                let image_id = el.data('image_id');
                let url = el.data('url');

                let modal = $('#theme-modal');
                modal.attr("data-selected", slug);
                modal.find('.modal-body img').attr('src', image);
                modal.find('.modal-body h2').text(name);
                modal.find('.modal-body p').text(description);
                modal.find('.modal-body a.theme_status_update_button').text(button_text);
                modal.find('.modal-body a.theme_status_update_button').attr('data-slug', slug);
                modal.find('.modal-body a.theme_status_update_button').attr('data-status', button_text);
                modal.find('.modal-body a.edit-btn').attr('data-slug', slug)
                modal.find('.modal-body a.edit-btn').attr('data-name', name)
                modal.find('.modal-body a.edit-btn').attr('data-description', description)
                modal.find('.modal-body a.edit-btn').attr('data-theme_url', url)
                modal.find('.modal-body a.edit-btn').attr('data-image', image)
                modal.find('.modal-body a.edit-btn').attr('data-image_id', image_id)
            });

            $(document).on('click', 'a.edit-btn', function (e) {
                let el = $(this);
                let slug = el.attr('data-slug');
                let name = el.attr('data-name');
                let description = el.attr('data-description');
                let theme_url = el.attr('data-theme_url');
                let theme_image = el.attr('data-image');
                let theme_image_id = el.attr('data-image_id');

                let modal = $('#edit-modal');
                modal.find('.modal-body input[name=theme_slug]').val(slug);
                modal.find('.modal-body input[name=theme_name]').val(name);
                modal.find('.modal-body textarea[name=theme_description]').text(description);
                modal.find('.modal-body input[name=theme_url]').val(theme_url);

                if (theme_image_id != '') {
                    modal.find('.media-upload-btn-wrapper .img-wrap').html('<div class="attachment-preview"><div class="thumbnail"><div class="centered">' +
                        '<img class="avatar user-thumb" src="' + theme_image + '" > </div></div></div>');
                    modal.find('.media-upload-btn-wrapper input').val(theme_image_id);
                    modal.find('.media-upload-btn-wrapper .media_upload_form_btn').text('Change Image');
                }
                modal.find('.modal-body input[name=theme_url]').val(theme_url);
            });
        });

        $(document).on('click', '.theme_status_update_button', function (e) {
            e.preventDefault();

            Swal.fire({
                title: '{{ __('Are you sure?') }}',
                text: '{{ __('Activation of Inactivation of this theme will bring changes in the page builder add-ons, but there will be no change in the front end but break design') }}',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: '{{__('Confirm')}}',
                cancelButtonText: "{{__('Cancel')}}",
            }).then((result) => {
                if (result.isConfirmed) {
                    let el = $(this);
                    let slug = el.attr('data-slug');
                    let status = el.attr('data-status');

                    let button = $('.theme_status_update_button[data-slug=' + slug + ']');
                    let theme_preview_button = $('.theme-preview[data-slug=' + slug + ']');
                    let theme_current_slug = $('.themePreview-btn[data-slug=' + slug + ']')

                    $.ajax({
                        'type': 'POST',
                        'url': '{{route('landlord.admin.theme.status.update')}}',
                        'data': {
                            '_token': '{{csrf_token()}}',
                            'slug': slug
                        },
                        beforeSend: function () {
                            if (status == 'active') {
                                button.text(`{{__('Inactivating..')}}`);
                            } else {
                                button.text(`{{__('Activating..')}}`);
                            }
                        },
                        success: function (data) {
                            var success = $('.themeInfo_' + slug + '');
                            var modal = $('#theme-modal');

                            if (data.status === true) {
                                button.text('Inactive');
                                button.attr('data-status', 'inactive');
                                theme_preview_button.attr('data-button_text', 'inactive');

                                theme_current_slug.text(`{{__('Activated')}}`);
                                theme_current_slug.removeClass('inactivated');

                                success.find('h3').text(`{{__('The theme is active successfully')}}`);
                                success.slideDown(20);

                                modal.find('.themeName').text(`{{__('The theme is inactive successfully')}}`);
                                $('.modal-success-msg').slideDown(20)
                            } else {
                                button.text(`{{__('Active')}}`);
                                button.attr('data-status', 'active');
                                theme_preview_button.attr('data-button_text', 'active');

                                theme_current_slug.text(`{{__('Inactivated')}}`);
                                theme_current_slug.addClass('inactivated');

                                success.find('h3').text(`{{__('The theme is inactive successfully')}}`);
                                success.slideDown(20);

                                modal.find('.themeName').text(`{{__('The theme is inactive successfully')}}`);
                                $('.modal-success-msg').slideDown(20)
                            }

                            setTimeout(function () {
                                success.slideUp()
                                $('.modal-success-msg').slideUp()
                            }, 5000);
                        },
                        error: function (data) {

                        }
                    });
                }
            });
        });
    </script>
@endsection
