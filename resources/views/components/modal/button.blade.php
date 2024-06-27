<button data-bs-target="#{{$target}}" data-id="{{$dataid ?? ''}}" data-select-markup="{!! $selectMarkup ?? '' !!}" data-user="{{$datauser ?? false}}"
        data-status="{{$datastatus ?? ''}}" data-bs-toggle="modal" class="mb-3 mr-1 btn-sm btn btn-{{$type ?? 'primary'}} {{$extra ?? ''}}" >{{$slot ?? ''}}</button>
