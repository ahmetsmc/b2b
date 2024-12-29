<div class="{{ $groupClass }}">
    @if(!$hideLabel)
        <label class="form-label" for="{{ $id }}">{{ $label }}</label>
    @endif
    <textarea
        name="{{ $name }}"
        class="{{ $class }}"
        id="{{ $id }}"
        placeholder="{{ $placeholder }}"
        {{ $required ? 'required' : ''}}>{{ $value }}</textarea>


    @if($error)
        <div class="invalid-tooltip d-block">
            {{ $error }}
        </div>
    @endif
</div>

@push('javascript')
    <script>
        var id = "{{ $id }}";

        ClassicEditor
            .create(document.querySelector('#' + id), {
                language: 'tr',
                extraPlugins: [MyCustomUploadAdapterPlugin],
                toolbar: {
                    items: [
                        'heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', '|',
                        'imageUpload', 'blockQuote', 'insertTable', 'mediaEmbed', 'undo', 'redo'
                    ]
                },
                image: {
                    toolbar: ['imageTextAlternative', 'toggleImageCaption', 'imageStyle:full', 'imageStyle:side'],
                    styles: [
                        'full',
                        'side'
                    ]
                }
            })
            .then(function (editor) {
                editor.ui.view.editable.element.style.height = "200px";
                editor.model.document.on('change:data', (evt, data) => {
                    var textarea = $('textarea#{{ $id }}');
                    textarea.val(editor.getData());
                    textarea.trigger('change');
                });
            })
            .catch(function (e) {
                console.error(e);
            });

        function MyCustomUploadAdapterPlugin(editor) {
            editor.plugins.get('FileRepository').createUploadAdapter = (loader) => {
                return new MyUploadAdapter(loader);
            };
        }

        class MyUploadAdapter {
            constructor(loader) {
                this.loader = loader;
                this.url = '{{ route("dashboard.editor.upload", $fileUploadDir) }}';
            }

            upload() {
                return this.loader.file
                    .then(file => new Promise((resolve, reject) => {
                        var formData = new FormData();
                        formData.append('upload', file);

                        $.ajax({
                            url: this.url,
                            type: 'POST',
                            data: formData,
                            processData: false,
                            contentType: false,
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            success: function (response) {
                                resolve({
                                    default: response.url
                                });
                            },
                            error: function (response) {
                                reject(response.error);
                            }
                        });
                    }));
            }
        }
    </script>
@endpush
