@extends('dashboard.layouts.master')

@push('head')
    <meta name="delete-variant-uri" content="{{ route('dashboard.products.variants.delete', [isset($product) ? $product->id : ':productId', ':variantId']) }}">
@endpush

@section('content')

    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">{{ !isset($product) ? 'Ürün Oluştur' : 'Ürün Düzenle' }}</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard.products.index') }}">Ürünler</a></li>
                        @if(isset($product))
                            <li class="breadcrumb-item"><a
                                    href="{{ route('dashboard.products.index') }}">{{ $product->title }}</a></li>
                        @endif
                        <li class="breadcrumb-item active">{{ !isset($product) ? 'Oluştur' : 'Düzenle' }}</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>

    <form method="POST" action="{{ url()->current() }}" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-lg-9">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Temel Bilgiler</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="mb-3 col-md-6">
                                <x-dashboard.form.inputs.select
                                    name="status"
                                    label="Durum"
                                    placeholder="Durum seçin"
                                    :options="['ACTIVE' => 'Aktif', 'PASSIVE' => 'Pasif']"
                                    :selected="isset($product) ? $product->status : 'ACTIVE'"
                                    :required="true"
                                    :error="$errors->first('status')"
                                />
                            </div>
                            <div class="mb-3 col-md-6">
                                <x-dashboard.form.inputs.text
                                    name="title"
                                    placeholder="Ürün adı"
                                    :value="isset($product) ? $product->title : ''"
                                    :required="true"
                                    :error="$errors->first('title')"
                                />
                            </div>
                            <div class="mb-3 col-md-6">
                                <x-dashboard.form.inputs.text
                                    name="code"
                                    placeholder="Ürün Kodu"
                                    :value="isset($product) ? $product->code : ''"
                                    :required="true"
                                    :error="$errors->first('code')"
                                />
                            </div>
                            <div class="mb-3 col-md-6">
                                <x-dashboard.form.inputs.select
                                    name="category_id"
                                    label="Kategori"
                                    placeholder="Kategori seçin"
                                    :options="modelToSelectComponentOptions($categories, 'id', 'title')"
                                    :selected="isset($product) ? $product->category_id : ''"
                                    :required="true"
                                    :error="$errors->first('category_id')"
                                />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Genel Bilgiler</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="mb-3 col-md-6">
                                <x-dashboard.form.inputs.select
                                    name="unit_id"
                                    label="Ölçü Birimi"
                                    placeholder="Ölçü birimi seçin"
                                    :selected="isset($product) ? $product->unit_id : ''"
                                    :options="modelToSelectComponentOptions($product_units, 'id', 'title')"
                                    :required="true"
                                    :error="$errors->first('unit_id')"
                                />
                            </div>
                            <div class="mb-3 col-md-6">
                                <x-dashboard.form.inputs.price
                                    name="price"
                                    :required="true"
                                    placeholder="Fiyat"
                                    :value="isset($product) ? $product->price : ''"
                                />
                            </div>
                            <div class="mb-3 col-md-6">
                                <x-dashboard.form.inputs.number
                                    name="tax_rate"
                                    :required="true"
                                    :value="!isset($product) ? setting('defaults.tax_rate') : $product->tax_rate"
                                    placeholder="KDV Oranı"
                                    :min="0"
                                    :max="100"
                                />
                            </div>
                            <div class="mb-3 col-md-3">
                                <x-dashboard.form.inputs.number
                                    name="stock"
                                    :required="true"
                                    placeholder="Stok Sayısı"
                                    :min="0"
                                    :value="isset($product) ? $product->stock : ''"
                                />
                            </div>
                            <div class="mb-3 col-md-3">
                                <x-dashboard.form.inputs.text
                                    name="lead_time"
                                    :required="false"
                                    placeholder="Tedarik Süresi"
                                    :value="isset($product) ? $product->lead_time : ''"
                                />
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Ürün Açıklaması</h5>
                    </div>
                    <div class="card-body pt-0">
                        <x-dashboard.form.inputs.editor
                            name="content"
                            :value="isset($product) ? $product->content : ''"
                        />
                    </div>
                </div>

                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">Ürün Varyantları</h5>
                        <button type="button" class="btn btn-primary btn-sm" id="createVariant">Varyant Ekle</button>
                    </div>
                    <div class="card-body pt-0">
                        @if($errors->has('variants.*'))
                            @foreach ($errors->get('variants.*') as $messages)
                                @foreach ($messages as $message)
                                    <div class="alert alert-danger">
                                        {{ $message }}
                                    </div>
                                @endforeach
                            @endforeach
                        @endif
                        <div id="productVariants">
                            <div>
                                <x-dashboard.partials.products.variant class="default-variant-item" :variant="null"/>
                            </div>

                            @if(isset($product))
                                @foreach($product->variants as $variant)
                                    <x-dashboard.partials.products.variant :variant="$variant"/>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3">
                <div class="position-sticky top-70">

                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">İşlemler</h5>
                        </div>
                        <div class="card-body">
                            <button type="submit" class="btn btn-success w-100">Kaydet</button>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Özet</h5>
                        </div>
                        <div class="card-body">
                            <div class="p-5 text-center">
                                <p class="text-muted mb-0">Henüz kayıt yok</p>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </form>
@endsection

@push('javascript')
    <script src="{{ asset('assets/dashboard/js/products.init.js') }}"></script>
@endpush
