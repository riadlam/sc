<!-- Blog area Start -->
<section class="blog-area" data-padding-top="{{$data['padding_top']}}" data-padding-bottom="{{$data['padding_bottom']}}">
    <div class="container-two">
        <div class="row">
            <div class="col-lg-12">
                <div class="section-title text-left section-title-two">
                    <h2 class="title"> {{$data['title'] ?? ''}} </h2>

                    @if(!empty($data['see_all_url']) && !empty($data['see_all_text']))
                        <a href="{{$data['see_all_url']}}">
                            <span class="see-all fs-18"> {{$data['see_all_text']}} </span>
                        </a>
                    @endif
                </div>
            </div>
        </div>
        <div class="row margin-top-10">
            @foreach($data['blogs'] as $blog)
                @php
                    $delay = '.1s';
                    $class = 'fadeInUp';

                    if ($loop->even)
                    {
                        $delay = '.2s';
                        $class = 'fadeInDown';
                    }
                @endphp
                <div class="col-xl-4 col-md-6 margin-top-30 wow {{$class}}" data-wow-delay="{{$delay}}">
                    <div class="single-blog style-02 bg-item-four radius-20">
                        <a href="{{route('tenant.frontend.blog.single', $blog->slug)}}" class="blog-image radius-10">
                            {!! render_image_markup_by_attachment_id($blog->image, 'lazyloads') !!}
                        </a>

                        <div class="contents">
                            <h3 class="blog-title ff-jost">
                                <a href="{{route('tenant.frontend.blog.single', $blog->slug)}}"> {{blog_limited_text($blog->title)}} </a>
                            </h3>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
<!-- Blog area end -->
