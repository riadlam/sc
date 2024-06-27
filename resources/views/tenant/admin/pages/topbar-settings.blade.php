@extends(route_prefix().'admin.admin-master')
@section('title')
    {{__('Topbar Settings')}}
@endsection

@section('style')
    <link href="{{ global_asset('assets/common/css/fontawesome-iconpicker.min.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="col-lg-12 col-ml-12">
        <div class="row g-4">
            <div class="col-lg-12">
                <div class="margin-top-40"></div>
                <x-error-msg/>
                <x-flash-msg/>
            </div>
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="header-wrapp d-flex justify-content-between">
                            <h4 class="header-title mb-4">{{__('Topbar Menu')}}  </h4>
                        </div>

                        <div class="menu-select">
                            <form class="forms-sample" method="post" action="{{route('tenant.admin.topbar.settings')}}">
                                @csrf

                                <div class="form-group">
                                    @php
                                        $menu_list = \App\Models\Menu::all();
                                    @endphp
                                    <label for="topbar_menu">{{__('Select Menu')}}</label>
                                    <select class="form-control" name="topbar_menu" id="topbar_menu">
                                        @foreach($menu_list as $menu)
                                            <option value="{{$menu->id}}" {{$menu->id == $topbar_menu ? 'selected' : ''}}>{{$menu->title}}</option>
                                        @endforeach
                                    </select>
                                    <p class="mt-1">
                                        <small class="form-text text-muted">{{__('The menu will be displayed in the top bar section')}} - <span class="text-primary">{{__('If available in the theme')}}</span></small>
                                    </p>
                                </div>

                                <button type="submit" class="btn btn-gradient-primary me-2">{{__('Save Changes')}}</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
