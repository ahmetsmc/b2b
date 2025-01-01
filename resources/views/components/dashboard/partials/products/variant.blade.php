<div class="{{ $class }}">
    <div class="image" style="width: 100px">
        <input type="file" id="variantImage" accept="image/*" name="{{ !is_null($variant) ? 'variants['.$variant->id.'][image]' : 'variants[:id][image]' }}">
        <label for="variantImage">
            <img src="{{ isset($variant) ? $variant->getImage() : asset('assets/no-image.jpg') }}" alt="" class="img-fluid">
        </label>
        <a href="{{ isset($variant) ? $variant->getImage() : asset('assets/no-image.jpg') }}" data-fancybox>
        </a>
    </div>
    <div class="title">
        <x-dashboard.form.inputs.text
            :name="!is_null($variant) ? 'variants['.$variant->id.'][title]' : 'variants[:id][title]'"
            placeholder="Başlık"
            :required="true"
            :value="$variant?->title"
        />
    </div>
    <div class="code">
        <x-dashboard.form.inputs.text
            :name="!is_null($variant) ? 'variants['.$variant->id.'][code]' : 'variants[:id][code]'"
            placeholder="Varyant Kodu"
            :required="true"
            :value="$variant?->code"
        />
    </div>
    <div class="price">
        <x-dashboard.form.inputs.price
            :name="!is_null($variant) ? 'variants['.$variant->id.'][price]' : 'variants[:id][price]'"
            placeholder="Fiyat" class="price-input"
            :required="true"
            :value="$variant?->price"
        />
    </div>
    <div class="code">
        <x-dashboard.form.inputs.number
            :name="!is_null($variant) ? 'variants['.$variant->id.'][stock]' : 'variants[:id][stock]'"
            placeholder="Stok Sayısı"
            :required="true"
            :value="$variant?->stock"
            :min="0"
        />
    </div>
    <div class="button">
        <button type="button" class="btn btn-danger delete-variant" data-id="{{ !is_null($variant) ? $variant->id : ':id' }}">
            <i class="las la-trash"></i>
        </button>
    </div>
</div>
