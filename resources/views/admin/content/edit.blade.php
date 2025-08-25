<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Edit Artikel</title>
    <script src="https://cdn.ckeditor.com/ckeditor5/41.2.1/classic/ckeditor.js"></script>
    <link rel="stylesheet" href="https://cdn.ckeditor.com/ckeditor5/42.0.1/ckeditor5.css" />

    <style type="text/css">
        .ck-editor__editable_inline {
            height: 600px;
            padding-left: 50px;
        }
    </style>
    @vite('resources/css/app.css')
</head>

<body>
    <div class="container mx-auto py-8">
        <form action="{{ route('artikel.update', $artikel->id) }}" method="POST"
            class="max-w-4xl mx-auto bg-white p-8 rounded-lg shadow-lg transition-transform transform hover:scale-105"
            enctype="multipart/form-data">
            <h1 class="text-3xl font-bold mb-6 text-center text-indigo-600">Edit Artikel</h1>
            @if ($errors->any())
                <div class="alert alert-danger mb-4 p-4 rounded-lg bg-red-100 text-red-700">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            @csrf
            <div class="mb-6">
                <label for="judul" class="block text-lg font-medium text-gray-700">Judul<span
                        class="text-red-500">*</span></label>
                <input type="text" name="judul" id="judul" value="{{ old('judul', $artikel->judul) }}"
                    class="mt-2 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md p-2 transition-colors duration-300 ease-in-out hover:bg-gray-100">
            </div>
            <div class="mb-6">
                <label for="judul" class="block text-lg font-medium text-gray-700">Head</label>
                <input type="text" name="head" id="judul" value="{{ old('head', $artikel->header) }}"
                    class="mt-2 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md p-2 transition-colors duration-300 ease-in-out hover:bg-gray-100">
            </div>
            <div class="mb-6">
                <label class="block text-lg font-medium text-gray-700">Type Sampul<span
                        class="text-red-500">*</span></label>
                <div class="mt-2 flex items-center space-x-4">
                    <input type="radio" id="uploadImage" name="uploadType" value="image"
                        {{ $artikel->sampul && !str_contains($artikel->sampul, 'embed/') ? 'checked' : '' }}
                        class="focus:ring-indigo-500 focus:border-indigo-500">
                    <label for="uploadImage" class="text-gray-700">Foto</label>
                    <input type="radio" id="uploadYoutube" name="uploadType" value="youtube"
                        {{ str_contains($artikel->sampul, 'embed/') ? 'checked' : '' }}
                        class="focus:ring-indigo-500 focus:border-indigo-500">
                    <label for="uploadYoutube" class="text-gray-700">YouTube Link</label>
                </div>
            </div>

            <div id="imageUpload"
                class="mb-6 {{ $artikel->sampul && !str_contains($artikel->sampul, 'embed/') ? '' : 'hidden' }}">
                <label for="image" class="block text-lg font-medium text-gray-700">Foto Sampul<span
                        class="text-red-500">*</span></label>
                <input type="file" id="image" name="sampul"
                    class="mt-2 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md p-2 transition-colors duration-300 ease-in-out hover:bg-gray-100">
                @if (isset($artikel->sampul) && !str_contains($artikel->sampul, 'embed/'))
                    <div class="flex justify-center mt-4">
                        <img src="{{ asset('img/' . $artikel->sampul) }}" alt="Image Preview"
                            class="mt-2 ring-2 ring-black rounded-lg" style="max-width: 200px; max-height: 200px;">
                    </div>
                @endif
                <div class="flex justify-center mt-4">
                    <img id="preview" src="" alt="Image Preview" class="mt-2 ring-2 ring-black rounded-lg"
                        style="max-width: 200px; max-height: 200px; display: none;">
                </div>
            </div>

            <div id="youtubeLink" class="mb-6 {{ str_contains($artikel->sampul, 'embed/') ? '' : 'hidden' }}">
                <label for="youtube" class="block text-lg font-medium text-gray-700">YouTube Link<span
                        class="text-red-500">*</span></label>
                <input type="url" id="youtube" name="sampul"
                    value="{{ old('sampul', str_replace('embed/', 'watch?v=', $artikel->sampul)) }}"
                    class="mt-2 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md p-2 transition-colors duration-300 ease-in-out hover:bg-gray-100"
                    placeholder="Enter YouTube Link">
            </div>

            <div class="mb-6">
                <label for="kategori" class="block text-lg font-medium text-gray-700">Kategori</label>
                <select name="kategori" id="kategori"
                    class="mt-2 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm transition-colors duration-300 ease-in-out hover:bg-gray-100">
                    @foreach ($kategori as $k)
                        <option value="{{ $k->id }}" {{ old('kategori', $artikel->kategori) == $k->id ? 'selected' : '' }}>
                            {{ $k->judul }}
                        </option>
                    @endforeach

                    <option value="" {{ old('kategori',$artikel->kategori) == '' ? 'selected' : '' }}>lainnya</option>
                </select>
            </div>

            <div class="mb-6">
                <label for="content" class="block text-lg font-medium text-gray-700">Deskripsi</label>
                <textarea name="content" id="content"
                    class="mt-2 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md p-2 transition-colors duration-300 ease-in-out hover:bg-gray-100"
                    rows="10">{{ old('content', $artikel->deskripsi) }}</textarea>
            </div>

            <div class="mb-6">
                <label for="status" class="block text-lg font-medium text-gray-700">Status</label>
                <select name="status" id="status"
                    class="mt-2 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md p-2 transition-colors duration-300 ease-in-out hover:bg-gray-100">
                    <option value="1" {{ $artikel->status == 1 ? 'selected' : '' }}>Publish</option>
                    <option value="0" {{ $artikel->status == 0 ? 'selected' : '' }}>Draft</option>
                </select>
            </div>

            <div class="text-center">
                <button type="submit"
                    class="w-full bg-indigo-600 text-white p-3 rounded-lg font-semibold text-lg shadow-md transition-transform transform hover:scale-105">Update
                    Artikel</button>
            </div>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const imageUpload = document.getElementById('imageUpload');
            const youtubeLink = document.getElementById('youtubeLink');
            const uploadImageRadio = document.getElementById('uploadImage');
            const uploadYoutubeRadio = document.getElementById('uploadYoutube');

            uploadImageRadio.addEventListener('change', function() {
                if (uploadImageRadio.checked) {
                    imageUpload.classList.remove('hidden');
                    youtubeLink.classList.add('hidden');
                }
            });

            uploadYoutubeRadio.addEventListener('change', function() {
                if (uploadYoutubeRadio.checked) {
                    youtubeLink.classList.remove('hidden');
                    imageUpload.classList.add('hidden');
                }
            });

            const imageInput = document.getElementById('image');
            const preview = document.getElementById('preview');

            imageInput.addEventListener('change', function(event) {
                const reader = new FileReader();
                reader.onload = function() {
                    preview.src = reader.result;
                    preview.style.display = 'block';
                };
                reader.readAsDataURL(event.target.files[0]);
            });

            ClassicEditor.create(document.querySelector('#content'), {
                toolbar: {
                    items: [
                        'exportPDF', 'exportWord', '|',
                        'findAndReplace', 'selectAll', '|',
                        'heading', '|',
                        'bold', 'italic', 'strikethrough', 'underline', 'code', 'subscript', 'superscript',
                        'removeFormat', '|',
                        'bulletedList', 'numberedList', 'todoList', '|',
                        'outdent', 'indent', '|',
                        'undo', 'redo',
                        '-',
                        'fontSize', 'fontFamily', 'fontColor', 'fontBackgroundColor', 'highlight', '|',
                        'alignment', '|',
                        'link', 'uploadImage', 'blockQuote', 'insertTable', 'mediaEmbed', 'codeBlock', 'htmlEmbed',
                        '|',
                        'specialCharacters', 'horizontalLine', 'pageBreak', '|',
                        'textPartLanguage', '|',
                        'sourceEditing'
                    ],
                    shouldNotGroupWhenFull: true
                },


                // Changing the language of the interface requires loading the language file using the <script> tag.
                // language: 'es',
                list: {
                    properties: {
                        styles: true,
                        startIndex: true,
                        reversed: true
                    }
                },
                // https://ckeditor.com/docs/ckeditor5/latest/features/headings.html#configuration
                heading: {
                    options: [{
                            model: 'paragraph',
                            title: 'Paragraph',
                            class: 'ck-heading_paragraph'
                        },
                        {
                            model: 'heading1',
                            view: 'h1',
                            title: 'Heading 1',
                            class: 'ck-heading_heading1'
                        },
                        {
                            model: 'heading2',
                            view: 'h2',
                            title: 'Heading 2',
                            class: 'ck-heading_heading2'
                        },
                        {
                            model: 'heading3',
                            view: 'h3',
                            title: 'Heading 3',
                            class: 'ck-heading_heading3'
                        },
                        {
                            model: 'heading4',
                            view: 'h4',
                            title: 'Heading 4',
                            class: 'ck-heading_heading4'
                        },
                        {
                            model: 'heading5',
                            view: 'h5',
                            title: 'Heading 5',
                            class: 'ck-heading_heading5'
                        },
                        {
                            model: 'heading6',
                            view: 'h6',
                            title: 'Heading 6',
                            class: 'ck-heading_heading6'
                        }
                    ]
                },
                // https://ckeditor.com/docs/ckeditor5/latest/features/editor-placeholder.html#using-the-editor-configuration
                placeholder: 'isi Konten',
                // https://ckeditor.com/docs/ckeditor5/latest/features/font.html#configuring-the-font-family-feature
                fontFamily: {
                    options: [
                        'default',
                        'Arial, Helvetica, sans-serif',
                        'Courier New, Courier, monospace',
                        'Georgia, serif',
                        'Lucida Sans Unicode, Lucida Grande, sans-serif',
                        'Tahoma, Geneva, sans-serif',
                        'Times New Roman, Times, serif',
                        'Trebuchet MS, Helvetica, sans-serif',
                        'Verdana, Geneva, sans-serif'
                    ],
                    supportAllValues: true
                },
                // https://ckeditor.com/docs/ckeditor5/latest/features/font.html#configuring-the-font-size-feature
                fontSize: {
                    options: [10, 12, 14, 'default', 18, 20, 22],
                    supportAllValues: true
                },
                // Be careful with the setting below. It instructs CKEditor to accept ALL HTML markup.
                // https://ckeditor.com/docs/ckeditor5/latest/features/general-html-support.html#enabling-all-html-features
                htmlSupport: {
                    allow: [{
                        name: /.*/,
                        attributes: true,
                        classes: true,
                        styles: true
                    }]
                },
                // Be careful with enabling previews
                // https://ckeditor.com/docs/ckeditor5/latest/features/html-embed.html#content-previews
                htmlEmbed: {
                    showPreviews: true
                },
                // https://ckeditor.com/docs/ckeditor5/latest/features/link.html#custom-link-attributes-decorators
                link: {
                    decorators: {
                        addTargetToExternalLinks: true,
                        defaultProtocol: 'https://',
                        toggleDownloadable: {
                            mode: 'manual',
                            label: 'Downloadable',
                            attributes: {
                                download: 'file'
                            }
                        }
                    }
                },
                // https://ckeditor.com/docs/ckeditor5/latest/features/mentions.html#configuration
                mention: {
                    feeds: [{
                        marker: '@',
                        feed: [
                            '@apple', '@bears', '@brownie', '@cake', '@cake', '@candy', '@canes',
                            '@chocolate', '@cookie', '@cotton', '@cream',
                            '@cupcake', '@danish', '@donut', '@dragée', '@fruitcake', '@gingerbread',
                            '@gummi', '@ice', '@jelly-o',
                            '@liquorice', '@macaroon', '@marzipan', '@oat', '@pie', '@plum', '@pudding',
                            '@sesame', '@snaps', '@soufflé',
                            '@sugar', '@sweet', '@topping', '@wafer'
                        ],
                        minimumCharacters: 1
                    }]
                },
                ckfinder: {
                    uploadUrl: "{{ route('img.upload', ['_token' => csrf_token()]) }}",
                }
            })
            .catch(error => {
                console.error(error);
            });
        });
    </script>
</body>

</html>
