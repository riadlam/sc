@extends('tenant.frontend.user.dashboard.user-master')

@section('title')
    {{__('Payment Logs')}}
@endsection

@section('section')
    <style>
        .product-img{
            max-width: 80px;
        }
    </style>
    @if(count($download_list) > 0)
        <div class="table-responsive">
            <!-- Order history start-->
            <div class="order-history-inner">
                <table>
                    <thead>
                    <tr>
                        <th>
                            {{__('ID')}}
                        </th>
                        <th>
                            {{__('Product')}}
                        </th>
                        <th>
                            {{__('File')}}
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($download_list as $data)
                        @php
                            $product = \Modules\DigitalProduct\Entities\DigitalProduct::find($data->product_id);
                        @endphp

                        <tr class="completed">
                            <td class="order-numb">
                                #{{ $data->id ?? 0 }}
                            </td>
                            <td class="d-flex gap-2">
                                {!! render_image_markup_by_attachment_id($product->image_id, 'product-img') !!}
                                <p>{{ $product->name }}</p>
                            </td>

                            <td class="table-btn">
                                <div class="btn-wrapper">
                                    <a href="{{route('tenant.user.dashboard.download.file', $product->slug)}}" class="btn-default rounded-btn">{{__('Download')}}</a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <!-- Order history end-->
        </div>
        <div class="blog-pagination">
            {{ $download_list->links() }}
        </div>
    @else
        <div class="alert alert-warning">{{__('No Order Found')}}</div>
    @endif
@endsection
