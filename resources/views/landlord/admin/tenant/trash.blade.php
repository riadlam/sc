@php
    $route_name ='landlord';
@endphp

@extends($route_name.'.admin.admin-master')
@section('title') {{__('Trash - All Deleted Tenants')}} @endsection

@section('style')
    <x-datatable.css/>
@endsection

@section('content')
    <div class="col-12 stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-4">{{__('All Deleted Tenants')}}</h4>

                <div class="d-flex justify-content-end mb-3">
                    <a class="btn btn-info btn-sm" href="{{route('landlord.admin.tenant')}}">{{__('Back')}}</a>
                </div>

                <x-error-msg/>
                <x-flash-msg/>

                <x-datatable.table>
                    <x-slot name="th">
                        <th>{{__('ID')}}</th>
                        <th>{{__('Name')}}</th>
                        <th>{{__('Email')}}</th>
                        <th>{{__('Action')}}</th>
                    </x-slot>
                    <x-slot name="tr">
                       @foreach($trashed_users as $user)
                           <tr>
                               <td>{{$user->id}}</td>
                               <td>{{$user->name}}</td>
                               <td>{{$user->email}}
                                   @if($user->email_verified === 0)
                                    <i class="text-danger mdi mdi-close-circle" data-bs-toggle="tooltip" data-bs-placement="top" title="{{__('Email Not Verified')}}"></i>
                                   @else
                                    <i class="text-success mdi mdi-check-circle" data-bs-toggle="tooltip" data-bs-placement="top" title="{{__('Email  Verified')}}"></i>
                                   @endif
                               </td>
                               <td>
                                   <x-link-with-popover url="{{route('landlord.admin.tenant.trash.restore', $user->id)}}" class="success">
                                       {{__('Restore')}}
                                   </x-link-with-popover>
                                   <x-delete-popover url="{{route('landlord.admin.tenant.trash.delete', $user->id)}}" popover="{{__('Delete')}}"/>
                               </td>
                           </tr>
                       @endforeach
                    </x-slot>
                </x-datatable.table>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <x-datatable.js/>
@endsection

