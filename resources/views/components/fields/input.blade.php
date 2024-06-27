@php
    $type = $type ?? 'text';
@endphp

<div class="form-group">
    @if(isset($type) && $type !== 'hidden')
        <label>
            {{$label}}
            @if(isset($tooltip))
                <i class="mdi mdi-information-outline text-primary price_plan_info"
                   data-bs-toggle="{{isset($direction) ? $direction : 'top'}}"
                   data-bs-placement="top"
                   data-bs-original-title="{{$tooltip}}"
                   aria-label="{{$tooltip}}"></i>
            @endif
        </label>
    @endif
    <input type="{{$type ?? 'text'}}"
           name="{{$name}}"
           class="form-control {{$class ?? ''}}"
           @if( isset($type) && $type !== 'hidden')
           placeholder="{{$placeholder ?? $label}}"
           @endif
           value="{{$value ?? ''}}" min="{{$min ?? ''}}">
    @if(isset($info))
        <small class="info-text d-block mt-2">{!!  $info !!}</small>
    @endif
</div>
