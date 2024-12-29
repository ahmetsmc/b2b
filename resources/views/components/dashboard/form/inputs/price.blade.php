<div class="{{ $groupClass }}">
    @if(!$hideLabel)
        <label class="form-label" for="{{ $id }}">{{ $label }}</label>
    @endif
    <div class="input-group">
        <span class="input-group-text">₺</span>
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
</div>


@push('javascript')
    <script>
        $(document).ready(function () {
            $('#{{ $id }}').inputmask({
                alias: "currency",
                groupSeparator: ".",
                decimalSeparator: ",",
                digits: 2,
                rightAlign: false,
                autoUnmask: true,
                removeMaskOnSubmit: true
            })
        })
    </script>
@endpush
