@extends('dashboard.layouts.master')

@section('content')

    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Ürün Grupları</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item active">Ürün Grupları</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>
    <!-- end page title -->

    <div class="row">

        <div class="col-xl-12 col-lg-12">
            <div>
                <div class="card">
                    <div class="card-header border-0">
                        <div class="d-flex justify-content-between">
                            <div>
                                <div class="d-flex justify-content-sm-end align-items-center">
                                    @if(request()->filled('q'))
                                        <a href="{{ route('dashboard.products.index') }}" class="btn btn-light ms-2">
                                            <i class="ri-close-circle-line search-icon"></i>
                                            Sıfırla
                                        </a>
                                    @endif
                                    <form class="search-box ms-2" method="GET" action="{{ url()->current() }}">
                                        <input type="text" class="form-control" id="searchProductList" name="q"
                                               placeholder="Ürünlerde arayın" value="{{ request()->input('q') }}">
                                        <i class="ri-search-line search-icon"></i>
                                    </form>
                                </div>
                            </div>
                            <div>
                                <div>
                                    <a href="{{ route('dashboard.products.create') }}" class="btn btn-success">
                                        <i class="ri-add-line align-bottom me-1"></i> Ürün Grubu Ekle
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
                                    <th style="width: 40px" class="text-center">
                                        <input type="checkbox"
                                               class="form-check form-check-info form-check-input bulk-action-check-select-all">
                                    </th>
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
                                @forelse($categories as $product)
                                    <tr>
                                        <td style="width: 40px" class="text-center">
                                            <input type="checkbox"
                                                   class="form-check form-check-info form-check-input bulk-action-check"
                                                   value="{{ $product->id }}">
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
                                                <a href="{{ route('dashboard.products.delete', $product->id) }}"
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
                        {!! $categories->withQueryString()->links() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="align-items-center d-flex gap-5 p-3 position-fixed" id="bulkActionProducts"
         data-text=":count ürün seçildi">
        <div class="text-content">
            <span class="text"></span>
        </div>
        <div class="actions">
            <button type="button" class="btn btn-primary" id="bulkUpdateHandle">Toplu Güncelle</button>
            <button type="button" class="btn btn-danger" id="bulkDeleteHandle">Toplu Sil</button>
            <button class="close-actions">
                <i class="ri-close-line"></i>
            </button>
        </div>
    </div>

    <div id="bulkActionModal" class="modal fade" tabindex="-1" aria-labelledby="bulkActionModalLabel"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="bulkActionModalLabel">Toplu Ürün Güncelleme</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('dashboard.products.bulk.update') }}" class="bulk-update-form" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="alert alert-warning">
                            Yapacağınız değişikliker seçtiğiniz tüm ürünlerde geçerli olacak ve uygulandıktan sonra
                            tekrar
                            geri alınamaz.
                        </div>

                        <div class="field mb-2">
                            <label for="bulkTaxRate">Vergi Oranı</label>
                            <select name="tax_rate[status]" class="form-select mb-2" id="bulkTaxRate">
                                <option value="">Güncelleme yapma</option>
                                <option value="update">Vergi oranını güncelle</option>
                                <option value="add">Vergi oranına ekleme yap</option>
                                <option value="subtract">Vergi oranından eksilt</option>
                            </select>
                            <div class="field-input d-none">
                                <x-dashboard.form.inputs.number
                                    name="tax_rate[value]"
                                    placeholder="Değer"
                                    :min="0"
                                    class="value-input"
                                />
                            </div>
                        </div>
                        <div class="field">
                            <label for="bulkStock">Stok Sayısı</label>
                            <select name="stock[status]" class="form-select mb-2" id="bulkStock">
                                <option value="">Güncelleme yapma</option>
                                <option value="update">Stoğu güncelle</option>
                                <option value="add">Varolan stoğa ekle</option>
                                <option value="subtract">Varolan stoktan çıkar</option>
                            </select>
                            <div class="field-input d-none">
                                <x-dashboard.form.inputs.number
                                    name="stock[value]"
                                    placeholder="Değer"
                                    :min="0"
                                    class="value-input"
                                />
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">İptal</button>
                        <button type="submit" class="btn btn-primary ">Değişiklieri Uygula</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
@endsection

@push('javascript')
    <script>
        $(document).ready(function () {
            var bulkActionWrapper = $('#bulkActionProducts');

            $(document).on('change', '.product-status-switch', function () {
                var checked = $(this).prop('checked');
                var id = $(this).attr('data-id');
                var action = "{{ route('dashboard.products.update.status', ':id') }}".replace(':id', id);

                $.post(action, {is_active: checked}, function (response) {
                    notify(response.status === true ? "success" : "error", response.message);
                });
            });

            $(document).on('change', '.bulk-action-check', function () {
                var checkedBulkActionInputs = $('.bulk-action-check:checked');
                var bulkUpdateForm = $('.bulk-update-form');
                bulkUpdateForm.find('.product-input').remove();

                if (checkedBulkActionInputs.length > 0) {
                    bulkActionWrapper.find('.text').text(bulkActionWrapper.attr('data-text').replace(':count', checkedBulkActionInputs.length));
                    bulkActionWrapper.addClass('active');
                    checkedBulkActionInputs.each(function () {
                        bulkUpdateForm.append(
                            '<input type="hidden" class="product-input" name="products[]" value="' + $(this).val() + '">'
                        )
                    });
                } else {
                    bulkActionWrapper.find('.text').text('');
                    bulkActionWrapper.removeClass('active');
                }
            });

            $(document).on('click', '#bulkUpdateHandle', function () {
                if ($('.bulk-action-check:checked').length > 0) {
                    $('#bulkActionModal').modal('show');
                } else {
                    notify('error', 'Lütfen önce ürün seçin');
                }
            });

            $(document).on('change', '#bulkActionModal .field > select', function () {
                var nextElement = $(this).next();

                if ($(this).val()) {
                    nextElement.removeClass('d-none');
                    nextElement.find('.value-input').attr('required', true);
                } else {
                    nextElement.addClass('d-none');
                    nextElement.find('.value-input').attr('required', false);
                }
            });

            $(document).on('click', '#bulkActionProducts .close-actions', function () {
                $('.bulk-action-check').prop('checked', false);
                $('.bulk-action-check-select-all').prop('checked', false);
                bulkActionWrapper.removeClass('active');
            });

            $(document).on('change', '.bulk-action-check-select-all', function () {
                if ($(this).prop('checked')) {
                    $('.bulk-action-check').prop('checked', true);
                } else {
                    $('.bulk-action-check').prop('checked', false);
                }

                if ($('.bulk-action-check').first()) {
                    $('.bulk-action-check').first().trigger('change');
                }
            });
        })
    </script>
@endpush
