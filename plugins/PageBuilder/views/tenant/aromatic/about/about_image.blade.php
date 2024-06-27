<!-- About area starts -->
<section class="about-area {{\App\Helpers\SanitizeInput::esc_html($data['section_class'])}}" data-padding-top="{{$data['padding_top']}}" data-padding-bottom="{{$data['padding_bottom']}}" id="{{\App\Helpers\SanitizeInput::esc_html($data['section_id'])}}">
    <div class="container-three">
        <div class="row">
            <div class="col-lg-12">
                <div class="about-thumb-wrapper">
                    <div class="about-thumb">
                        @foreach($data['repeater_data']['repeater_image_'] ?? [] as $image)
                            {!! render_image_markup_by_attachment_id($image) !!}
                        @endforeach
                    </div>
                    <div class="row align-items-center margin-top-10 padding-top-10">
                        <div class="col-xl-8 margin-top-30">
                            <div class="single-about-content bg-item-four">
                                <h2 class="about-title fs-46"> {{$data['primary_title'] ?? ''}} </h2>
                                <p class="about-para"> {!! $data['primary_description'] ?? '' !!} </p>
                                </p>
                            </div>
                        </div>
                        <div class="col-xl-4 margin-top-30">
                            <div class="single-about-address">
                                <h2 class="title"> {{$data['secondary_title']}} </h2>
                                <ul class="about-location-list">
                                    {!! $data['secondary_description'] !!}
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- About area end -->
