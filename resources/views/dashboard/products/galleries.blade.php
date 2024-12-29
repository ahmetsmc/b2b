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
                                    href="{{ route('dashboard.products.index') }}">{{ $product->title }}</a></li>
                        @endif
                        <li class="breadcrumb-item active">Galeri</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">Ürün Görselleri</h4>
                </div>

                <div class="card-body">
                    <div class="dropzone dz-clickable position-sticky top-70" style="z-index: 999"
                         data-upload="{{ route('dashboard.products.gallery.upload', $product->id) }}"
                         data-cover="{{ route('dashboard.products.gallery.update.cover', $product->id) }}"
                         data-delete="{{ route('dashboard.products.gallery.delete', $product->id) }}"
                         data-ranking="{{ route('dashboard.products.gallery.update.ranking', $product->id) }}">
                        <div class="fallback d-none">
                            <input name="file" type="file" multiple="multiple" id="dropzoneUploadFileInput">
                        </div>
                        <label class="dz-message needsclick" for="dropzoneUploadFileInput">
                            <div class="mb-3">
                                <i class="display-4 text-muted ri-upload-cloud-2-fill"></i>
                            </div>
                            <h4>Dosyaları buraya bırakın veya yüklemek için tıklayın.</h4>
                        </label>
                    </div>

                    <ul class="list-unstyled mb-0" id="dropzone-preview">
                        <li class="mt-2" id="dropzone-preview-list" data-id="">
                            <div class="border rounded">
                                <div class="d-flex p-2 align-items-center">
                                    <div class="flex-shrink-0 me-3">
                                        <div class="avatar-sm bg-light rounded">
                                            <a href="" data-fancybox>
                                                <img data-dz-thumbnail
                                                     class="img-fluid rounded d-block h-100 object-fit-cover"
                                                     src="{{ asset('assets/dashboard/images/no-image.png') }}"/>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1">
                                        <div class="pt-1">
                                            <h5 class="fs-14 mb-1" data-dz-name>&nbsp;</h5>
                                            <p class="fs-13 text-muted mb-0" data-dz-size></p>
                                            <strong class="error text-danger" data-dz-errormessage></strong>
                                        </div>
                                    </div>
                                    <div class="flex-shrink-0 ms-3">
                                        <div class="form-check form-switch form-switch-md">
                                            <input class="form-check-input" type="checkbox" role="switch"
                                                   id="setCoverPhotoToggle:id" value=":id">
                                            <label for="setCoverPhotoToggle:id" class="mb-0">Kapak Görseli</label>
                                        </div>
                                    </div>
                                    <div class="flex-shrink-0 ms-3">
                                        <button data-dz-remove class="btn btn-sm btn-danger" data-id="" type="button">
                                            Kaldır
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </li>

                        @foreach($product->galleries as $gallery)
                            <li class="mt-2" data-id="{{ $gallery->id }}">
                                <div class="border rounded">
                                    <div class="d-flex p-2 align-items-center">
                                        <div class="flex-shrink-0 me-3">
                                            <div class="avatar-sm bg-light rounded">
                                                <a href="{{ asset('storage/' . $gallery->large_path) }}" data-fancybox>
                                                    <img data-dz-thumbnail
                                                         class="img-fluid rounded d-block h-100 object-fit-cover"
                                                         src="{{ asset('storage/' . $gallery->small_path) }}"
                                                         alt="Dropzone-Image"/>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="flex-grow-1">
                                            <div class="pt-1">
                                                <h5 class="fs-14 mb-1">{{ $gallery->name }}</h5>
                                                <p class="fs-13 text-muted mb-0">{{ $gallery->size }}B</p>
                                                <strong class="error text-danger" data-dz-errormessage></strong>
                                            </div>
                                        </div>
                                        <div class="flex-shrink-0 ms-3">
                                            <div class="form-check form-switch form-switch-md">
                                                <input class="form-check-input" type="checkbox" role="switch"
                                                       value="{{ $gallery->id }}"
                                                       id="setCoverPhotoToggle{{ $gallery->id }}" @checked($gallery->isCover())>
                                                <label for="setCoverPhotoToggle{{ $gallery->id }}" class="mb-0">Kapak
                                                    Görseli</label>
                                            </div>
                                        </div>
                                        <div class="flex-shrink-0 ms-3">
                                            <button data-dz-remove class="btn btn-sm btn-danger"
                                                    data-id="{{ $gallery->id }}" type="button">Kaldır
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        @endforeach

                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('head')
    <link rel="stylesheet" href="{{ asset('assets/dashboard/libs/dropzone/dropzone.css') }}">
    <style>
        #dropzone-preview .form-check input:checked {
            pointer-events: none;
        }
    </style>
@endpush

@push('javascript')
    <script src="{{ asset('assets/dashboard/libs/dropzone/dropzone-min.js') }}"></script>

    <script>
        $(document).ready(function () {
            var uploadUri = $('.dropzone').attr('data-upload');
            var dropzonePreviewNode = document.querySelector("#dropzone-preview-list");
            var previewTemplate = dropzonePreviewNode.parentNode.innerHTML;
            var csrf = $('meta[name="csrf-token"]').attr('content');
            var technicalError = "Bilinmeyen bir sorun oluştu, lütfen daha sonra tekrar deneyin";
            initSortablePropertyImages();

            dropzonePreviewNode.parentNode.removeChild(dropzonePreviewNode);

            new Dropzone('.dropzone', {
                url: uploadUri,
                method: "POST",
                previewTemplate: previewTemplate,
                maxFilesize: 20,
                previewsContainer: "#dropzone-preview",
                acceptedFiles: 'image/*',
                init: function () {

                    this.on("sending", function (file, xhr, formData) {
                        formData.append("_token", csrf);
                    });

                    this.on('error', function (file, response) {
                        $(file.previewElement).find('[data-dz-errormessage]').text(response.message);
                        $(file.previewElement).addClass('has-error');
                        $(file.previewElement).removeClass('loader');
                        notify('error', (response.message ? response.message : technicalError));
                        initSortablePropertyImages();
                    });

                    this.on('success', function (file, response) {
                        file.previewElement.removeAttribute('id');
                        if (response.status !== true) {
                            $(file.previewElement).find('[data-dz-errormessage]').text(response.message);
                            $(file.previewElement).addClass('has-error');
                            $(file.previewElement).removeClass('loader');
                            notify('error', (response.message ? response.message : technicalError));
                        } else {
                            $(file.previewElement).attr('data-id', response.data.id);
                            $(file.previewElement).find('[data-dz-thumbnail]').attr('src', response.data.small);
                            $(file.previewElement).find('.form-check-input').attr('id', 'setCoverPhotoToggle' + response.data.id);
                            $(file.previewElement).find('.form-check-input + label').attr('for', 'setCoverPhotoToggle' + response.data.id);
                            $(file.previewElement).find('.form-check-input').attr('value', response.data.id);
                            $(file.previewElement).find('[data-dz-name]').text(response.file);
                            $(file.previewElement).find('[data-fancybox]').attr('href', response.data.large);
                            $(file.previewElement).attr('data-id', response.data.id);
                            $(file.previewElement).find('input').attr('data-id', response.data.id);
                            $(file.previewElement).find('.bulk-delete-image-check').val(response.data.id);
                            $(file.previewElement).find('[data-dz-remove]').val(response.data.id);
                            $(file.previewElement).removeClass('loader');
                        }

                        initSortablePropertyImages();
                    });
                }
            });
        });

        $(document).on('change', '#dropzone-preview .form-check input', function () {
            var action = $('.dropzone').attr('data-cover');
            var id = $(this).val();
            $.post(action, {id: id}, function (response) {
                if (response.status === true) {
                    notify("success", response.message);
                } else {
                    notify("success", response.message);
                }

                $('#dropzone-preview .form-check input').prop('checked', false);
                $('#dropzone-preview .form-check input[value="' + response.checked_id + '"]').prop('checked', true);
            });
        });

        $(document).on('click', '#dropzone-preview button[data-dz-remove]', function () {
            Swal.fire({
                html: '<div class="mt-3">' +
                    '<lord-icon src="https://cdn.lordicon.com/gsqxdxog.json" trigger="loop" colors="primary:#f7b84b,secondary:#f06548" style="width:100px;height:100px"></lord-icon>' +
                    '<div class="mt-4 pt-2 fs-15 mx-5">' +
                    '<h4>Silmek istediğinize emin misiniz?</h4>' +
                    '<p class="text-muted mx-4 mb-0">Bu kaydı sildikten sonra geri alamasınız, silmek istediğinize emin misiniz?</p></div>' +
                    '</div>',
                showCancelButton: !0,
                customClass: {
                    confirmButton: "btn btn-danger w-xs me-2 mb-1",
                    cancelButton: "btn btn-primary w-xs mb-1"
                },
                confirmButtonText: "Evet, kaldır",
                buttonsStyling: !1,
                showCloseButton: !0,
                cancelButtonText: "İptal",
            }).then((result) => {

                var action = $('.dropzone').attr('data-delete');
                var id = $(this).attr('data-id');
                var button = $(this);

                if (result.isConfirmed) {
                    $.post(action, {id: id}, function (response) {
                        if (response.status === true) {
                            notify("success", response.message);
                            var parentItem = button.closest('li');

                            if (parentItem) {
                                parentItem.remove()
                            }
                        } else {
                            notify("error", response.message);
                        }
                    });
                }
            });
        });

        function initSortablePropertyImages() {
            const sortableItems = new Sortable(document.getElementById("dropzone-preview"), {
                animation: 300,
                easing: "ease-in-out",
                onEnd: function () {
                    let sortedIDs = Array.from($('#dropzone-preview > li')).map(item => item.getAttribute('data-id'));
                    var action = $('.dropzone').attr('data-ranking');
                    $.post(action, {galleries: sortedIDs}, function (response) {
                        notify((response.status === true ? 'success' : 'error'), response.message);
                    });
                },
            });
        }
    </script>
@endpush
