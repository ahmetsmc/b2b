@extends('dashboard.layouts.master')

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

    <form method="POST" action="{{ url()->current() }}">
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

                {{--                <div class="card">--}}
                {{--                    <div class="card-header">--}}
                {{--                        <ul class="nav nav-tabs-custom card-header-tabs border-bottom-0" role="tablist">--}}
                {{--                            <li class="nav-item">--}}
                {{--                                <a class="nav-link active" data-bs-toggle="tab" href="#addproduct-general-info"--}}
                {{--                                   role="tab">--}}
                {{--                                    Fiyat ve Stok--}}
                {{--                                </a>--}}
                {{--                            </li>--}}
                {{--                            <li class="nav-item">--}}
                {{--                                <a class="nav-link" data-bs-toggle="tab" href="#addproduct-metadata" role="tab">--}}
                {{--                                    Meta Data--}}
                {{--                                </a>--}}
                {{--                            </li>--}}
                {{--                        </ul>--}}
                {{--                    </div>--}}
                {{--                    <!-- end card header -->--}}
                {{--                    <div class="card-body">--}}
                {{--                        <div class="tab-content">--}}
                {{--                            <div class="tab-pane active" id="addproduct-general-info" role="tabpanel">--}}
                {{--                                <div class="row">--}}
                {{--                                    <div class="col-lg-6">--}}
                {{--                                        <div class="mb-3">--}}
                {{--                                            <label class="form-label" for="manufacturer-name-input">Manufacturer--}}
                {{--                                                Name</label>--}}
                {{--                                            <input type="text" class="form-control" id="manufacturer-name-input"--}}
                {{--                                                   placeholder="Enter manufacturer name">--}}
                {{--                                        </div>--}}
                {{--                                    </div>--}}
                {{--                                    <div class="col-lg-6">--}}
                {{--                                        <div class="mb-3">--}}
                {{--                                            <label class="form-label" for="manufacturer-brand-input">Manufacturer--}}
                {{--                                                Brand</label>--}}
                {{--                                            <input type="text" class="form-control" id="manufacturer-brand-input"--}}
                {{--                                                   placeholder="Enter manufacturer brand">--}}
                {{--                                        </div>--}}
                {{--                                    </div>--}}
                {{--                                </div>--}}
                {{--                                <!-- end row -->--}}

                {{--                                <div class="row">--}}
                {{--                                    <div class="col-lg-3 col-sm-6">--}}
                {{--                                        <div class="mb-3">--}}
                {{--                                            <label class="form-label" for="stocks-input">Stocks</label>--}}
                {{--                                            <input type="text" class="form-control" id="stocks-input"--}}
                {{--                                                   placeholder="Stocks">--}}
                {{--                                            <div class="invalid-feedback">Please Enter a product stocks.</div>--}}
                {{--                                        </div>--}}
                {{--                                    </div>--}}
                {{--                                    <div class="col-lg-3 col-sm-6">--}}
                {{--                                        <div class="mb-3">--}}
                {{--                                            <label class="form-label" for="product-discount-input">Discount</label>--}}
                {{--                                            <div class="input-group mb-3">--}}
                {{--                                                <span class="input-group-text" id="product-discount-addon">%</span>--}}
                {{--                                                <input type="text" class="form-control" id="product-discount-input"--}}
                {{--                                                       placeholder="Enter discount" aria-label="discount"--}}
                {{--                                                       aria-describedby="product-discount-addon">--}}
                {{--                                            </div>--}}
                {{--                                        </div>--}}
                {{--                                    </div>--}}
                {{--                                    <div class="col-lg-3 col-sm-6">--}}
                {{--                                        <div class="mb-3">--}}
                {{--                                            <label class="form-label" for="orders-input">Orders</label>--}}
                {{--                                            <input type="text" class="form-control" id="orders-input"--}}
                {{--                                                   placeholder="Orders">--}}
                {{--                                            <div class="invalid-feedback">Please Enter a product orders.</div>--}}
                {{--                                        </div>--}}
                {{--                                    </div>--}}
                {{--                                </div>--}}
                {{--                            </div>--}}

                {{--                            <div class="tab-pane" id="addproduct-metadata" role="tabpanel">--}}
                {{--                                <div class="row">--}}
                {{--                                    <div class="col-lg-6">--}}
                {{--                                        <div class="mb-3">--}}
                {{--                                            <label class="form-label" for="meta-title-input">Meta title</label>--}}
                {{--                                            <input type="text" class="form-control" placeholder="Enter meta title"--}}
                {{--                                                   id="meta-title-input">--}}
                {{--                                        </div>--}}
                {{--                                    </div>--}}

                {{--                                    <div class="col-lg-6">--}}
                {{--                                        <div class="mb-3">--}}
                {{--                                            <label class="form-label" for="meta-keywords-input">Meta Keywords</label>--}}
                {{--                                            <input type="text" class="form-control" placeholder="Enter meta keywords"--}}
                {{--                                                   id="meta-keywords-input">--}}
                {{--                                        </div>--}}
                {{--                                    </div>--}}
                {{--                                </div>--}}

                {{--                                <div>--}}
                {{--                                    <label class="form-label" for="meta-description-input">Meta Description</label>--}}
                {{--                                    <textarea class="form-control" id="meta-description-input"--}}
                {{--                                              placeholder="Enter meta description" rows="3"></textarea>--}}
                {{--                                </div>--}}
                {{--                            </div>--}}
                {{--                        </div>--}}
                {{--                    </div>--}}
                {{--                </div>--}}
            </div>

            <div class="col-lg-3">
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
    </form>
@endsection