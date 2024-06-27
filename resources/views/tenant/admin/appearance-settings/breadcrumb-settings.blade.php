@extends(route_prefix().'admin.admin-master')
@section('title') {{__('Breadcrumb Settings')}} @endsection
@section('style')
    <x-media-upload.css/>
@endsection
@section('content')
    <div class="col-12 stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-4">{{__('Breadcrumb Settings')}}</h4>
                <x-error-msg/>
                <x-flash-msg/>
                <form class="forms-sample" method="post" action="{{route(route_prefix().'admin.breadcrumb.update')}}">
                    @csrf

                    <x-fields.media-upload name="background_left_shape_image" title="{{__('Left Shape Image')}}"/>
                    <x-fields.media-upload name="background_right_shape_image" title="{{__('Right Shape Image')}}"/>

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
