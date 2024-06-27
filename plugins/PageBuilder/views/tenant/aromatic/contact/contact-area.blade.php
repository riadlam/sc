<!-- Contact Area Starts -->
<section class="contact-area" data-padding-top="{{$data['padding_top']}}" data-padding-bottom="{{$data['padding_bottom']}}">
    <div class="container-three">
        <div class="row align-items-center">
            <div class="col-xl-5 col-lg-6 margin-top-30">
                <div class="contact-wrappers bg-item-four">
                    <div class="contacts-content">
                        <h2 class="contact-title"> {{$data['title'] ?? ''}} </h2>
                        @foreach($data['repeater_data']['repeater_info_'] ?? [] as $key => $item)
                            <div class="single-contact-item margin-top-30">
                                <span class="item-title"> {{esc_html($data['repeater_data']['repeater_info_'][$key]) ?? ''}} </span>
                                <span class="item-para"> {{esc_html($data['repeater_data']['repeater_sub_info_'][$key]) ?? ''}} </span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="col-xl-7 col-lg-6 margin-top-30">
                <div class="contact-form">
                    @if(!empty($data['custom_form_id']))
                        @php
                            $form_details = \App\Models\FormBuilder::find($data['custom_form_id']);
                        @endphp
                    @endif

                    {!! \App\Helpers\FormBuilderCustom::render_form(optional($form_details)->id,null,null,'btn-default') !!}
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Contact Area end -->



@section('scripts')
    <script>
        $(document).on('submit', '.custom-form-builder-ten', function (e) {
            e.preventDefault();
            var btn = $('#contact_form_btn');
            var form = $(this);
            var formID = form.attr('id');
            var msgContainer =  form.find('.error-message');
            var formSelector = document.getElementById(formID);
            var formData = new FormData(formSelector);
            msgContainer.html('');
            $.ajax({
                url: "{{route(route_prefix().'frontend.form.builder.custom.submit')}}",
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': "{{csrf_token()}}",
                },
                beforeSend:function (){
                    btn.html('<i class="fas fa-spinner fa-spin mr-1"></i> {{__("Submitting..")}}');
                },
                processData: false,
                contentType: false,
                data:formData,
                success: function (data) {
                    form.find('.ajax-loading-wrap').removeClass('show').addClass('hide');
                    msgContainer.html('<div class="alert alert-'+data.type+'">' + data.msg + '</div>');
                    btn.text('{{__("Submit Message")}}');
                    form[0].reset();

                },
                error: function (data) {

                    form.find('.ajax-loading-wrap').removeClass('show').addClass('hide');
                    var errors = data.responseJSON.errors;
                    var markup = '<ul class="alert alert-danger">';

                    $.each(errors,function (index,value){
                        markup += '<li>'+value+'</li>';})
                    markup += '</ul>';


                    msgContainer.html(markup);
                    btn.text('{{__("Submit Message")}}');
                }
            });
        });

        $(document).ready(function () {
            let contact_form_name = `{{$form_details->title ?? ''}}`;
            let appendable = `<label class="contact-title" for="#"> ${contact_form_name} </label>`;
            let form = $('.contact-form form');

            form.prepend(appendable);
            form.find('textarea').attr('rows', 3);
            $('.contact-title').addClass('mb-4');
        });
    </script>

@endsection


