@extends('dashboard.layouts.master')

@section('content')

    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Ürünler</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item active">Ürünler</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>
    <!-- end page title -->

    <div class="row">
        <div class="col-xl-3 col-lg-4">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex">
                        <div class="flex-grow-1">
                            <h5 class="fs-16 mb-0">Ürünleri Filtrele</h5>
                        </div>
                        <div class="flex-shrink-0">
                            <a href="{{ route('dashboard.products.index') }}" class="text-decoration-underline">
                                Filtreyi Temizle
                            </a>
                        </div>
                    </div>
                </div>

                <div class="card mb-0">
                    <form class="search-box" method="GET" action="{{ url()->current() }}">
                        <div class="card-body">
                            <div class="accordion-body text-body">
                                <div class="position-relative mb-4">
                                    <input type="text" class="form-control" name="q" placeholder="Ürünlerde arayın"
                                           value="{{ request()->input('q') }}">
                                    <i class="ri-search-line search-icon"></i>
                                </div>
                                <div class="d-flex flex-column gap-2 mb-4">
                                    <p class="text-muted text-uppercase mb-1">KATEGORİLER</p>
                                    @foreach($categories as $category)
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox"
                                                   name="categories[]"
                                                   value="{{ $category->id }}"
                                                   id="categoryFilter{{ $category->id }}"
                                                @checked(request()->has('categories') && in_array($category->id, request()->input('categories')))>
                                            <label class="form-check-label" for="categoryFilter{{ $category->id }}">
                                                {{ $category->title }}
                                            </label>
                                        </div>
                                    @endforeach
                                </div>

                                <div class="d-flex flex-column gap-2">
                                    <p class="text-muted text-uppercase mb-1">STOK DURUMU</p>
                                    @foreach([1 => 'ONLY_AVAILABLE', 0 => 'ONLY_OUT_OF_STOCK'] as $key => $stock_status)
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio"
                                                   name="stock"
                                                   value="{{ $key }}"
                                                   id="stockFilter{{ str($stock_status)->camel() }}" @checked(request()->has('stock') && request()->input('stock') == $key)>
                                            <label class="form-check-label"
                                                   for="stockFilter{{ str($stock_status)->camel() }}">
                                                {{ str_contains($stock_status, 'AVAILABLE') ? 'Sadece Stokta Olanlar' : 'Sadece Stokta Olmayanlar' }}
                                            </label>
                                        </div>
                                    @endforeach
                                </div>

                                <div class="position-sticky top-0">
                                    <button type="submit" class="btn btn-primary w-100 mt-2">Seçenekleri Uygula</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <!-- end card -->
        </div>
        <!-- end col -->

        <div class="col-xl-9 col-lg-8">
            <div>
                <div class="card">
                    <div class="card-header border-0">
                        <div class="d-flex justify-content-between">
                            <div>
                                {{--                                <div class="d-flex justify-content-sm-end align-items-center">--}}
                                {{--                                    @if(request()->filled('q'))--}}
                                {{--                                        <a href="{{ route('dashboard.products.index') }}" class="btn btn-light ms-2">--}}
                                {{--                                            <i class="ri-close-circle-line search-icon"></i>--}}
                                {{--                                            Sıfırla--}}
                                {{--                                        </a>--}}
                                {{--                                    @endif--}}
                                {{--                                    <form class="search-box ms-2" method="GET" action="{{ url()->current() }}">--}}
                                {{--                                        <input type="text" class="form-control" id="searchProductList" name="q"--}}
                                {{--                                               placeholder="Ürünlerde arayın" value="{{ request()->input('q') }}">--}}
                                {{--                                        <i class="ri-search-line search-icon"></i>--}}
                                {{--                                    </form>--}}
                                {{--                                </div>--}}
                            </div>
                            <div>
                                <div>
                                    <a href="{{ route('dashboard.products.create') }}" class="btn btn-success">
                                        <i class="ri-add-line align-bottom me-1"></i> Ürün Ekle
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th style="width: 40px" class="text-center">#</th>
                                    <th>Ürün Kodu</th>
                                    <th>Başlık</th>
                                    <th>Kategori</th>
                                    <th>Stok Sayısı</th>
                                    <th>Fiyat</th>
                                    <th>Durum</th>
                                    <th class="text-end">İşlem</th>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse($products as $product)
                                    <tr>
                                        <td style="width: 40px" class="text-center">
                                            <input type="checkbox" class="form-check form-check-info form-check-input">
                                        </td>
                                        <td>{{ $product->code }}</td>
                                        <td>{{ $product->title }}</td>
                                        <td>{{ $product->category->title }}</td>
                                        <td>{{ $product->stock }}</td>
                                        <td>{{ money($product->price, 'TRY', true) }}</td>
                                        <td>
                                            <div class="form-check form-switch form-switch-md">
                                                <input class="form-check-input product-status-switch" type="checkbox"
                                                       role="switch"
                                                       data-id="{{ $product->id }}" @checked($product->isActive())>
                                            </div>
                                        </td>
                                        <td class="text-end">
                                            <div class="d-flex gap-2 justify-content-end">
                                                <a href="{{ route('dashboard.products.edit', $product->id) }}"
                                                   type="button" class="btn btn-primary btn-sm">
                                                    <i class="ri-pencil-line align-bottom me-1"></i>
                                                    Düzenle
                                                </a>
                                                <a href="{{ route('dashboard.products.gallery.index', $product->id) }}"
                                                   type="button" class="btn btn-info btn-sm">
                                                    <i class="ri-image-2-line align-bottom me-1"></i>
                                                    Görseller
                                                </a>
                                                <a href="{{ route('dashboard.products.variants.index', $product->id) }}"
                                                   type="button" class="btn btn-secondary btn-sm">
                                                    <i class="ri-image-2-line align-bottom me-1"></i>
                                                    Varyantlar
                                                </a>
                                                <a href="{{ route('dashboard.products.delete', $product->id) }}" type="button"
                                                   class="btn btn-danger btn-sm delete-confirm-action">
                                                    <i class="ri-delete-bin-2-line align-bottom me-1"></i>
                                                    Kaldır
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8">
                                            <div class="alert alert-warning text-center mb-0">
                                                Kayıt yok
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                                </tbody>
                            </table>
                        </div>
                        {!! $products->withQueryString()->links() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('javascript')
    <script>
        $(document).ready(function () {
            $(document).on('change', '.product-status-switch', function () {
                var checked = $(this).prop('checked');
                var id = $(this).attr('data-id');
                var action = "{{ route('dashboard.products.update.status', ':id') }}".replace(':id', id);

                $.post(action, {is_active: checked}, function (response) {
                    notify(response.status === true ? "success" : "error", response.message);
                });
            });
        })
    </script>
@endpush
