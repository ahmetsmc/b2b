@extends('dashboard.layouts.master')

@section('content')

    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">{{ $product->title }}</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard.products.index') }}">Ürünler</a></li>
                        @if(isset($product))
                            <li class="breadcrumb-item"><a
                                    href="{{ route('dashboard.products.edit', $product->id) }}">{{ $product->title }}</a>
                            </li>
                        @endif
                        <li class="breadcrumb-item active">Varyantlar</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between border-0 align-items-center">
                    <h3 class="card-title">Varyantlar</h3>
                    <a href="{{ route('dashboard.products.variants.create', $product->id) }}" class="btn btn-success">
                        <i class="ri-add-line align-bottom me-1"></i> Varyant Ekle
                    </a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                            <tr>
                                <th style="width: 40px" class="text-center">#</th>
                                <th>Ürün Kodu</th>
                                <th>Başlık</th>
                                <th>Stok Sayısı</th>
                                <th>Fiyat</th>
                                <th class="text-end">İşlem</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($variants as $variant)
                                <tr>
                                    <td style="width: 40px" class="text-center">
                                        <input type="checkbox" class="form-check form-check-info form-check-input">
                                    </td>
                                    <td>{{ $variant->code }}</td>
                                    <td>{{ $variant->title }}</td>
                                    <td>{{ $variant->stock }}</td>
                                    <td>{{ money($variant->price, 'TRY', true) }}</td>
                                    <td class="text-end">
                                        <div class="d-flex gap-2 justify-content-end">
                                            <a href="{{ route('dashboard.products.variants.edit', [$product->id, $variant->id]) }}"
                                               type="button" class="btn btn-primary btn-sm">
                                                <i class="ri-pencil-line align-bottom me-1"></i>
                                                Düzenle
                                            </a>
                                            <a href="{{ route('dashboard.products.delete', $variant->id) }}"
                                               type="button"
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
                    {!! $variants->withQueryString()->links() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
