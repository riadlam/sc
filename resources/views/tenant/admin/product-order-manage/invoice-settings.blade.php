@extends(route_prefix().'admin.admin-master')
@section('title')
    {{__('Order Settings')}}
@endsection
@section('content')
    <div class="col-lg-12 col-ml-12">
        <div class="row g-4">
            <div class="col-12">
                <x-error-msg/>
                <x-flash-msg/>
                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title mb-4">{{__("Order Settings")}}</h4>
                        <form action="{{route(route_prefix().'admin.product.invoice.settings')}}" method="POST" enctype="multipart/form-data" id="report_generate_form">
                            @csrf
                            <div class="form-group mt-4">
                                <label for="invoice_number_padding">{{__('Invoice Serial Number Padding')}}</label>
                                <input id="invoice_number_padding" name="invoice_number_padding" type="number" class="form-control" placeholder="2" value="{{get_static_option('invoice_number_padding') ?? ''}}">
                                <br>
                                <small>{{__('Sequence will be padded accordingly, for ex. Serial No. 00001')}}</small>
                            </div>

                            <div class="form-group mt-4">
                                @php
                                    $options = ['each' => __('Each Product tax'), 'total' => __('Total Tax')];
                                @endphp
                                <label for="invoice_tax_position">{{__('Invoice Serial Number Padding')}}</label>
                                <select class="form-control" name="invoice_tax_position" id="invoice_tax_position">
                                    @foreach($options as $index => $option)
                                        <option value="{{$index}}" {{get_static_option('invoice_tax_position') == $index ? 'selected' : ''}}>{{$option}}</option>
                                    @endforeach
                                </select>
                                <br>
                                <small>{{__('It will determine where the tax will be shown')}}</small>
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-success">{{__('Update')}}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
