<?php
if (!isset($name))
    $name = '';
if (!isset($extra))
    $extra = '';

if (isset($class)) {
    if (str_contains($class, 'form-required')) {
        $required = true;
    }
} else
    $class = '';

if (isset($disabled) and $disabled) {
    $required = false;
    $extra .= ' disabled ';
}



if (isset($value) and is_object($value))
    $value = $value->$name;

if (!isset($in_form))
    $in_form = true;
?>
@if(!isset($condition) or $condition)
    @if($in_form)
        <div class="form-group {{ (isset($container['class']) ? $container['class'] : '') }}"
        {{ isset($container['id']) ? "id=$container[id]" : '' }}
        @if(isset($container['other']))
            @foreach($container['other'] as $attrName => $attrValue)
                {{ $attrName }}="{{ $attrValue }}"
            @endforeach
        @endif
        >
        @if(!isset($label))
            {{ null, $label = Lang::has("validation.attributes.$name") ? trans("validation.attributes.$name") : $name }}
        @elseif($label)
            {{ null, $label = is_string($label) ? $label : trans("validation.attributes.$name") }}
        @endif

        @if($label)
            <label
                    for="{{$name}}"
                    class="col-sm-12 control-label {{$label_class or ''}}"
            >
                {{ $label }}
                @if(isset($required) and $required)
                    @include('front.forms.require-sign')
                @endif
            </label>

        @endif
        <div class="col-sm-12">
            @include('forms.input-self')
            <span class="help-block persian {{$hint_class or ''}}" style="{{$hint_style or ''}}">
					{{ $hint or '' }}
				</span>

            @if ($errors->has('email'))
                <span class="help-block">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
            @endif

        </div>
        </div>
    @else
        @include('forms.input-self')
    @endif
@endif