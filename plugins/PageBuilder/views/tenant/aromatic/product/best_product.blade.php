@php
    $particle_image_one = get_attachment_image_by_id($data['particle_image_one']);
    $particle_image_one = !empty($particle_image_one) ? $particle_image_one['img_url'] : theme_assets('img/circles.png');

    $particle_image_two = get_attachment_image_by_id($data['particle_image_two']);
    $particle_image_two = !empty($particle_image_two) ? $particle_image_two['img_url'] : theme_assets('img/shape1.png');

    $particle_image_three =  get_attachment_image_by_id($data['particle_image_three']);
    $particle_image_three = !empty($particle_image_three) ? $particle_image_three['img_url'] : theme_assets('img/shape2.png');

    $particle_image_four = get_attachment_image_by_id($data['particle_image_four']);
    $particle_image_four = !empty($particle_image_four) ? $particle_image_four['img_url'] : theme_assets('img/collection-sh.png');

    $particle_image_five = get_attachment_image_by_id($data['particle_image_five']);
    $particle_image_five = !empty($particle_image_five) ? $particle_image_five['img_url'] : theme_assets('img/collections-black.png');

    $particle_image_six = get_attachment_image_by_id($data['particle_image_six']);
    $particle_image_six = !empty($particle_image_six) ? $particle_image_six['img_url'] : theme_assets('img/spray-wave.png');
@endphp
<!-- Spray area starts -->
<section class="spray-area body-bg-2" data-padding-top="{{$data['padding_top']}}"
         data-padding-bottom="{{$data['padding_bottom']}}">
    <div class="collection-shapes collection-five">
        <img src="{{$particle_image_one}}" alt="">
        <img src="{{$particle_image_two}}" alt="">
        <img src="{{$particle_image_three}}" alt="">
    </div>
    <div class="container-three">
        <div class="row align-items-center flex-lg-row-reverse">
            <div class="col-lg-6">
                <div class="spray-image-contents">
                    <div class="spray-image wow fadeInUp" data-wow-delay=".3s">
                        <a href="{{$data['image_url'] ?? '#'}}">
                            {!! render_image_markup_by_attachment_id($data['image'], 'lazyloads') !!}
                        </a>
                    </div>
                    <div class="sparay-image-shape">
                        <img src="{{$particle_image_four}}" alt="">
                        <img src="{{$particle_image_five}}" alt="">
                        <img src="{{$particle_image_six}}" alt="">
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="spray-contents padding-0">
                    <h2 class="spray-title ff-playfair fw-400"> {{$data['title'] ?? ''}} </h2>
                    <span class="spray-price color-one ff-playfair fw-400 color-heading margin-top-30"> {{amount_with_currency_symbol($data['price'] ?? '')}} </span>

                    @if(!empty($data['button_url']) && !empty($data['button_text']))
                        <div class="btn-wrapper margin-top-60">
                            <a href="{{$data['button_url']}}" class="cmn-btn btn-bg-heading fs-20 radius-0"> {{$data['button_text']}} </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Spray area end -->
