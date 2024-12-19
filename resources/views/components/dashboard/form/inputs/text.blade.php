<div class="{{ $groupClass }}">
    @if(!$hideLabel)
        <label class="form-label" for="{{ $id }}">{{ $label }}</label>
    @endif
    <input
        type="text"
        name="{{ $name }}"
        class="{{ $class }}"
        id="{{ $id }}"
        value="{{ $value }}"
        placeholder="{{ $placeholder }}"
        {{ $required ? 'required' : ''}}>

    @if($error)
        <div class="invalid-tooltip d-block">
            {{ $error }}
        </div>
    @endif
</div>
