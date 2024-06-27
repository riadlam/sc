@extends('landlord.admin.admin-master')
@section('title') {{__('SSL Settings')}} @endsection
@section('style')
    <x-colorpicker.css/>
@endsection

@section('content')
    <div class="col-12">
        <div class="row g-4">
            <div class="col-lg-12">
                <x-error-msg/>
                <x-flash-msg/>
            </div>
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title mb-4">{{__('SSL Settings')}}</h4>

                        <p class="text-warning">
                            {{__('It will force your website to open with https')}}
                        </p>
                        <form class="forms-sample" method="post" action="{{route('landlord.admin.general.ssl.settings')}}">
                            @csrf

                            <x-fields.switcher :name="'site_force_ssl_redirection'" :label="'Enable SSL'" :value="get_static_option('site_force_ssl_redirection')"/>

                            <button type="submit" class="btn btn-gradient-primary me-2">{{__('Save Changes')}}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <x-colorpicker.js/>
@endsection

