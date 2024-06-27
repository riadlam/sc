@extends(route_prefix().'admin.admin-master')
@section('title') {{__('Section Title Settings')}} @endsection
@section('style')
    <x-media-upload.css/>
@endsection
@section('content')
    <div class="col-12 stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-4">{{__('Section Title Settings')}}</h4>
                <x-error-msg/>
                <x-flash-msg/>
                <form class="forms-sample" method="post" action="{{route(route_prefix().'admin.section.manage.update')}}">
                    @csrf

                    <p>{{__('This image will be visible under section title if the feature is available in the selected theme')}}</p>
                    <x-fields.media-upload name="shape_image" title="{{__('Shape Image')}}" dimentions="~230x26px"/>

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
