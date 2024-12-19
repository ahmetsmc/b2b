<div class="{{ $groupClass }}">
    @if(!$hideLabel)
        <label for="{{ $id }}" class="form-label">{{ $label }}</label>
    @endif

    <select class="{{ $class }}" id="{{ $id }}" name="{{ $name }}" @if($required) required @endif>
        @if($placeholder)
            <option value="">{{ $placeholder }}</option>
        @endif
        @foreach($options as $key => $option)
            <option
                value="{{ $key }}" @selected($selected == $key)>
                {{ $option }}
            </option>
        @endforeach
    </select>

    @if($error)
        <div class="invalid-tooltip d-block">
            {{ $error }}
        </div>
    @endif
</div>
