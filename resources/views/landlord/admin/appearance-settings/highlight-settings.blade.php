@extends(route_prefix().'admin.admin-master')
@section('title') {{__('Text Highlight Settings')}} @endsection
@section('style')
    <x-media-upload.css/>
@endsection
@section('content')
    <div class="col-12 stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-4">{{__('Text Highlight Settings')}}</h4>
                <x-error-msg/>
                <x-flash-msg/>
                <form class="forms-sample" method="post" action="{{route(route_prefix().'admin.highlight.update')}}">
                    @csrf

                    <p>{{__('If you used highlighted text anywhere, this image will be shown under the text')}}</p>
                    <x-fields.media-upload name="highlight_text_shape" title="{{__('Highlighted Text Shape')}}" dimentions="~230x26px"/>

                    <button type="submit" class="btn btn-gradient-primary mt-5 me-2">{{__('Save Changes')}}</button>
                </form>
            </div>
        </div>
    </div>
    <x-media-upload.markup/>
@endsection
@section('scripts')
    <x-media-upload.js/>
@endsection
