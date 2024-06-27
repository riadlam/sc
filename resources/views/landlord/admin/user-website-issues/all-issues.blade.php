@extends(route_prefix().'admin.admin-master')
@section('title')
    {{__('All User Website Issues')}}
@endsection

@section('style')
    <x-media-upload.css/>
    <x-datatable.css/>
@endsection

@section('content')
    <div class="col-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <x-admin.header-wrapper>
                    <x-slot name="left">
                        <h4 class="card-title mb-5">{{__('All User Website Issues')}}</h4>
                    </x-slot>

                </x-admin.header-wrapper>
                <x-error-msg/>
                <x-flash-msg/>
                <x-datatable.table>
                    <x-slot name="th">
                        <th>{{__('ID')}}</th>
                        <th>{{__('User ID')}}</th>
                        <th>{{__('User Name')}}</th>
                        <th>{{__('Issue Type')}}</th>
                        <th>{{__('Description')}}</th>
                        <th>{{__('Domain')}}</th>
                        <th>{{__('Domain Status')}}</th>
                        <th>{{__('Action')}}</th>
                    </x-slot>
                    <x-slot name="tr">
                        @foreach($all_issues as $data)
                            <tr>
                                <td>{{$data->id}}</td>
                                <td>{{$data->tenant?->payment_log?->user?->id}}</td>
                                <td>{{$data->tenant?->payment_log?->user?->name}}</td>
                                <td>{{ ucfirst($data->issue_type) }}</td>
                                <td>{{ $data->description }}</td>
                                <td>{{ $data->tenant_id  }}</td>
                                <td>{{ \App\Enums\DomainCreateStatusEnum::getText($data->domain_create_status)  }}</td>

                                <td>
                                    <a href="" class="btn btn-success btn-sm view_issue_button"
                                       data-bs-toggle="modal"
                                       data-bs-target="#view_details_website_issues"
                                       data-id="{{$data->id}}"
                                       data-user_id="{{$data->tenant?->payment_log?->user?->id}}"
                                       data-user_name="{{$data->tenant?->payment_log?->user?->name}}"
                                       data-issue_type="{{ ucfirst($data->issue_type)}}"
                                       data-domain="{{$data->tenant_id}}"
                                       data-domain_status="{{\App\Enums\DomainCreateStatusEnum::getText($data->domain_create_status)}}"
                                       data-expected_database_name="{{env('TENANT_DATABASE_PREFIX').$data->tenant_id}}"
                                       data-description="{{$data->description}}"
                                    >
                                        <i class="mdi mdi-eye"></i>
                                    </a>

                                    @if($data->domain_create_status == 0)
                                        <form action="{{route('landlord.admin.failed.domain.generate')}}" method="post"
                                              enctype="multipart/form-data">
                                            @csrf

                                            <input type="hidden" name="id" value="{{$data->id}}">
                                            <button type="submit"
                                                    class="btn btn-info btn-sm mt-2">{{__('Generate')}}</button>
                                        </form>
                                    @endif

                                    @if($data->domain_create_status == 0)
                                        <a class="btn btn-primary btn-sm manual_database_btn"
                                           data-exception_id="{{$data->id}}"
                                           data-bs-target="#manual_database_modal"
                                           data-bs-toggle="modal">{{__('Set Database Manually')}}</a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </x-slot>
                </x-datatable.table>
            </div>
        </div>
    </div>

    <x-media-upload.markup/>

    <div class="modal fade" id="view_details_website_issues" aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{__('Issue Details')}}</h5>
                    <button type="button" class="close" data-bs-dismiss="modal"><span>×</span></button>
                </div>
                <div class="modal-body">
                    <ul>
                        <li><strong>{{ __('Issue ID') }} </strong>: <span class="issue_id"></span></li>
                        <li><strong>{{ __('User ID') }}</strong> : <span class="user_id"></span></li>
                        <li><strong>{{ __('User Name') }}</strong> : <span class="user_name"></span></li>
                        <li><strong>{{ __('Issue Type') }}</strong> : <span class="issue_type"></span></li>
                        <li><strong>{{ __('Domain') }}</strong> : <span class="domain"></span></li>
                        <li><strong>{{ __('Domain Status') }}</strong> : <span class="domain_status"></span></li>
                        <li><strong>{{ __('Expected Database Name') }}</strong> : <span class="expected_database_name"></span></li>
                        <li><strong>{{ __('Description') }}</strong> : <span class="description"></span></li>
                    </ul>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{__('Close')}}</button>
                </div>

            </div>
        </div>
    </div>

    <div class="modal fade" id="manual_database_modal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{__('Set Database Manually')}}</h5>
                    <button type="button" class="close" data-bs-dismiss="modal"><span>×</span></button>
                </div>

                <form action="{{route('landlord.admin.failed.database.generate')}}"
                      id="user_add_subscription_form"
                      method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">

                        <input type="hidden" class="exception_id" name="exception_id" value="">

                        <div class="form-group mb-0">
                            <label for="">{{__('Database Name')}}</label>
                            <input class="form-control database-name" type="text" name="database_name"
                                   id="database-name" autocomplete="off" placeholder="Database name">
                            <p class="bg-warning">
                                <small class="text-dark ms-2">{{__('Set your database name here.')}}</small>
                            </p>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{__('Close')}}</button>
                        <button type="submit" class="btn btn-primary">{{__('Submit')}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <x-media-upload.js/>
    <x-datatable.js/>

    <script>
        $(document).ready(function () {

            $(document).on('click', '.view_issue_button', function () {
                let el = $(this);
                let modal = $('#view_details_website_issues');

                modal.find('.issue_id').text(el.data('id'))
                modal.find('.user_id').text(el.data('user_id'))
                modal.find('.user_name').text(el.data('user_name'))
                modal.find('.issue_type').text(el.data('issue_type'))
                modal.find('.domain').text(el.data('domain'))
                modal.find('.domain_status').text(el.data('domain_status'))
                modal.find('.expected_database_name').text(el.data('expected_database_name'))
                modal.find('.description').text(el.data('description'))
            });

            $(document).on('click', '.manual_database_btn', function () {
                let el = $(this);
                let exception_id = el.data('exception_id')
                let modal = $('#manual_database_modal');

                modal.find('.exception_id').val(exception_id);
            });
        });
    </script>
@endsection
