<div class="{{ $groupClass }}">
    @if(!$hideLabel)
        <label class="form-label" for="{{ $id }}">{{ $label }}</label>
    @endif
    <input
        type="number"
        name="{{ $name }}"
        class="{{ $class }}"
        id="{{ $id }}"
        value="{{ $value }}"
        placeholder="{{ $placeholder }}"
        @if(!is_null($min)) min="{{ $min }}" @endif
        @if(!is_null($max)) max="{{ $max }}" @endif
        {{ $required ? 'required' : ''}}>

    @if($error)
        <div class="invalid-tooltip d-block">
            {{ $error }}
        </div>
    @endif
</div>
