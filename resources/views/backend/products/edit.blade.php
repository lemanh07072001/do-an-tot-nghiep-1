<x-app-layout>
    @section('title', config('apps.products.titleUpdate'))
    <div class="p-4 max-h-full block sm:flex items-center justify-between   dark:bg-gray-800 ">
        <div class="w-full mb-1">
            <div class="mb-4">
                {{ Breadcrumbs::render('productsUpdate', $products) }}
                <div class="flex items-center content-center">
                    <h1 class="text-xl font-semibold text-gray-900 sm:text-2xl dark:text-white mr-2 ">@yield('title')
                    </h1>
                    <x-badges label="Hướng dẫn" type="primary" icon="{{ @svg('css-info', 'w-4 h-4') }}" />
                </div>
            </div>
        </div>


    </div>
    <x-card>
        <form method="POST" action="{{ route('ecommerce_module.products.update', $products) }}" class="repeater">
            @csrf
            <div class="grid grid-cols-6 gap-4 gap-y-4 ">

                <div class="col-span-6 sm:col-span-3 ">
                    <x-input-label for="name" required>Tên sản phẩm</x-input-label>
                    <x-text-input name="name" :value="old('name') ?? $products->name" id="name" placeholder="Tên tiêu đề" />
                    <x-input-error error="name" class="mt-2" />
                </div>

                <div class="col-span-6 sm:col-span-3">
                    <x-input-label for="slug" required>Slug</x-input-label>
                    <x-text-input name="slug" :value="old('slug') ?? $products->slug" id="slug" />
                    <x-input-error error="slug" class="mt-2" />
                </div>

                <div class="col-span-6 sm:col-span-6">
                    <x-input-label for="sort_description">Mô tả ngắn</x-input-label>
                    <x-text-arena name="sort_description" :value="old('sort_description') ?? $products->sort_description" id="sort_description" />
                    <x-input-error error="sort_description" class="mt-2" />
                </div>

                <div class="col-span-6 sm:col-span-6 sm:row-span-6">
                    <x-input-label for="myDropzone_1" required>Hình ảnh</x-input-label>
                    <input type="hidden" id="image_id" name="images" value="">
                    <div id="myDropzone_1" style="max-width:100%"
                        class="dropzone border-4 border-dashed border-gray-300 rounded-lg p-4 flex-wrap text-center flex items-center justify-center">

                    </div>
                    <x-input-error error="images" class="mt-2" />
                </div>


                <div class="col-span-6 sm:col-span-6">
                    <x-input-label for="description">Nội dung</x-input-label>
                    <x-text-arena name="description" :value="old('description') ?? $products->description" id="description" />
                    <x-input-error error="description" class="mt-2" />
                </div>

                <div class="col-span-6 sm:col-span-6 sm:row-span-6">
                    <x-input-label for="myDropzone_2" required>Ảnh đại diện</x-input-label>
                    <input type="hidden" id="image_id" name="avatar" value="">
                    <div id="myDropzone_2"
                        class="dropzone border-4 border-dashed border-gray-300 rounded-lg p-4 text-center flex flex-col items-center justify-center">

                    </div>
                    <x-input-error error="avatar" class="mt-2" />
                </div>



                <div class="col-span-6 sm:col-span-2 ">
                    <x-input-label for="sku" required>SKU</x-input-label>
                    <x-text-input name="sku" :value="old('sku') ?? $products->sku" id="sku" placeholder="Mã sản phẩm" />
                    <x-input-error error="suk" class="mt-2" />
                </div>

                <div class="col-span-6 sm:col-span-2">
                    <x-input-label for="price" required>Giá</x-input-label>
                    <x-text-input class="int" name="price" :value="old('price') ?? (int) $products->price" id="price" />
                    <x-input-error error="price" class="mt-2" />
                </div>

                <div class="col-span-6 sm:col-span-2">
                    <x-input-label for="price_sale" required>Giảm giá</x-input-label>
                    <x-text-input class="int" name="price_sale" :value="old('price_sale') ?? (int) $products->price_sale" id="price_sale" />
                    <x-input-error error="price_sale" class="mt-2" />
                </div>

                <div class="col-span-6 sm:col-span-2 ">
                    <x-input-label required>Trạng thái</x-input-label>
                    <x-select data-search="search-status" name="status">
                        @if (\App\Enums\Status::getValues())
                            <option disabled>--Chọn trạng thái--</option>
                            @foreach (\App\Enums\Status::getValues() as $status)
                                <option value="{{ $status }}" @selected(old('status', $products->status) == $status)>
                                    {{ \App\Enums\Status::getKey($status) }}</option>
                            @endforeach
                        @endif
                    </x-select>
                </div>

                <div class="col-span-6 sm:col-span-2 ">
                    <x-input-label >Nhãn</x-input-label>
                    <x-select name="label_id">
                        @if (!empty($getAllLabelSelect))
                            <option value="">--Chọn nhãn--</option>
                            @foreach ($getAllLabelSelect as $label)
                                <option value="{{ $label->id }}" @selected(old('label_id', $products->label_id) == $label->id)>
                                    {{ $label->name }}</option>
                            @endforeach
                        @endif
                    </x-select>
                </div>

                <div class="col-span-6 sm:col-span-2 ">
                    <x-input-label required>Danh mục</x-input-label>
                    <x-select name="categories_id">
                        <option value="">--Chọn danh mục--</option>
                        {{ App\Helpers\GetData::showCategoriesSelect($getCategoriesSelect, $products->categories_id) }}
                    </x-select>
                    <x-input-error error="categories_id" class="mt-2" />
                </div>

                <div class="col-span-6 sm:col-span-2 ">
                    <h3 class="mb-3 text-xl font-medium text-gray-900 dark:text-white">Thêm mới thộc tính</h3>
                    <label class="inline-flex items-center me-5 cursor-pointer mb-3">
                        <input type="checkbox" name="turnOnVariant" class="sr-only peer turnOnVariant"
                            @checked(old('turnOnVariant') == 'on' || (isset($products) && count(json_decode($products->attributeCatalogue, true)) > 0))>
                        <div
                            class="relative w-11 h-6 bg-gray-200 rounded-full peer  peer-focus:ring-4 peer-focus:ring-orange-300  peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-orange-500">
                        </div>
                        <span class="ms-3 text-sm font-medium text-gray-500 ">Bấm vào đây để thêm mới thuộc tính cho sản
                            phẩm</span>
                    </label>


                    <div class="btn-foot block">
                        <button data-create type="button"
                            class="add-row  text-white bg-gradient-to-r from-green-400 via-green-500 to-green-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-green-300 dark:focus:ring-green-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2">
                            Thêm mới
                        </button>
                    </div>
                </div>

                @php
                    $variantCatalogue = old(
                        'attributeCatalogue',
                        isset($products->attributeCatalogue) ? json_decode($products->attributeCatalogue, true) : [],
                    );

                @endphp

                <div class="col-span-6 sm:col-span-6 attributeList {{ count($variantCatalogue) ? '' : 'hidden' }}">
                    <div
                        class="mb-2 text-sm font-semibold tracking-wide text-gray-900 uppercase lg:text-xs dark:text-white">
                        Thuộc tính</div>
                    <div class="data-render">

                        @if ($variantCatalogue && count($variantCatalogue))
                            @foreach ($variantCatalogue as $key => $value)
                                <div data-repeater-list="attribute">
                                    <div data-repeater-item>
                                        <div class="grid grid-cols-8 gap-4 gap-y-4">
                                            <div class="col-span-2 sm:col-span-2 mb-2">
                                                <select name="attributeCatalogue[]"
                                                    class="select selectProperties bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                                                    <option value="">--Chọn thuộc tính--</option>
                                                    @foreach ($getAllProperties as $item)
                                                        <option value="{{ $item->id }}"
                                                            @selected($value == $item->id)>{{ $item->name }}
                                                        </option>
                                                    @endforeach

                                                </select>
                                            </div>
                                            <div class="col-span-5 sm:col-span-5 mb-2">
                                                {{-- <input type="text" name="input_attribute"
                                                    class="select bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                                    disabled> --}}
                                                <select name="attribute[{{ $value }}][]" multiple
                                                    data-catID="{{ $value }}"
                                                    class="selectMultiple variant-{{ $value }} bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 "
                                                    id=""></select>
                                            </div>
                                            <div class="col-span-1 sm:col-span-1">
                                                <button type="button" data-delete
                                                    class="text-white bg-gradient-to-r from-red-400 via-red-500 to-red-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2">
                                                    Delete
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach

                        @endif
                    </div>

                </div>


                <div
                    class="attributeList col-span-6 sm:col-span-6 {{ count($variantCatalogue) ? '' : 'hidden' }}">
                    <div class="w-100">
                        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                            <table class="w-full text-sm text-left  text-gray-500 tableFull">
                                <div
                                    class="p-5 text-lg font-semibold text-left rtl:text-right text-gray-900 bg-white ">
                                    DANH SÁCH PHIÊN BẢN
                                    <p class="mt-1 text-sm font-normal text-gray-500 dark:text-gray-400">Chọn danh sách
                                        phiên bản phù hợp với sản phẩm</p>
                                </div>
                                <div id="renderTableAttribute" class="w-100" style="width:100%">
                                    <thead class="theadHeader text-xs text-white uppercase bg-gray-500"></thead>
                                    <tbody class="bodyRow"></tbody>
                                </div>
                            </table>
                        </div>

                    </div>
                </div>
            </div>

            <div class="col-span-6 sm:col-span-3">
                <div class="flex justify-end mt-3">
                    <button type="submit"
                        class="text-white bg-gradient-to-r from-blue-500 via-blue-600 to-blue-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2">
                        Xác nhận
                    </button>
                    <a href="{{ route('ecommerce_module.banner.index') }}"
                        class="text-white bg-gradient-to-r from-orange-400 via-orange-500 to-orange-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-green-300 dark:focus:ring-green-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2">
                        Quay lại
                    </a>
                </div>
            </div>

            </div>


        </form>


    </x-card>


    @push('css')
        <link href="https://cdnjs.cloudflare.com/ajax/libs/jquery.repeater/1.2.1/jquery.repeater.min.js" />
    @endpush

    @push('js')
        <script src="{{ asset('assets/apps/products/customProduct.js') }}"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.repeater/1.2.1/jquery.repeater.js"></script>

        <script>
            var getAllProperties = {{ Js::from($getAllProperties) }};

            var old = {{ Js::from(old('attributeCatalogue')) }};

            var routeGetChildrenProperties = {{ Js::from(route('ecommerce_module.ajax.getChildrenProperties')) }};
            var getAttributeAjax = {{ Js::from(route('ecommerce_module.ajax.getAttributeAjax')) }};

            var attributes = {{ Js::from(old('attribute',(isset($products->attributes) ? json_decode($products->attributes, true) : []))) }}
            var variants = {{ Js::from(old('variant',(isset($products->variants) ? json_decode($products->variants, true) : []))) }}
        </script>



        <script>
            var imageUrl = {{ Js::from(explode(', ', $products->images)) }};
            var uploadedDocumentMap = {}
            // Khởi tạo Dropzone trên phần tử có ID là myDropzone
            Dropzone.autoDiscover = false; // Tắt chế độ tự động tìm kiếm các phần tử có class dropzone

            $(document).ready(function() {
                $("#myDropzone_1").dropzone({
                    url: "/admin/upload", // Đường dẫn xử lý tệp tin sau khi tải lên
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                            'content')
                    },
                    // uploadMultiple: true,
                    maxFilesize: 2, // Dung lượng tối đa cho mỗi tệp tin (đơn vị MB)
                    acceptedFiles: ".png, .jpg", // Các loại tệp tin được chấp nhận
                    addRemoveLinks: true, // Cho phép xóa tệp tin sau khi đã tải lên
                    dictDefaultMessage: "Kéo và thả tệp tin vào đây hoặc nhấp để chọn tệp", // Tin nhắn mặc định
                    success: function(file, response) {
                        console.log(response);
                        $('form').append('<input type="hidden" name="images[]" value="' + response +
                            '">')
                        uploadedDocumentMap[file.name] = response
                    },
                    removedfile: function(file) {

                        file.previewElement.remove()
                        var name = ''
                        if (typeof file.name !== 'undefined') {
                            name = file.name
                        } else {
                            name = uploadedDocumentMap[file.name]
                        }
                        $('form').find('input[name="images[]"][value="' + name + '"]').remove()
                    },
                    init: function() {

                        @if ($products->images)
                            imageUrl.forEach(image => {
                                let mockFile = {
                                    name: image,
                                    size: 12345 // Adjust size if needed
                                };

                                this.files.push(mockFile);
                                this.displayExistingFile(mockFile, "{{ env('APP_URL') }}" + image);

                                $('form').append('<input type="hidden" name="images[]" value="' +
                                    image + '">')
                            });
                        @endif


                    }
                })
            });
        </script>

        <script>
            var imageUrlAvatar = {{ Js::from($products->avatar) }};
            var uploadedDocumentMap = {}
            // Khởi tạo Dropzone trên phần tử có ID là myDropzone
            Dropzone.autoDiscover = false; // Tắt chế độ tự động tìm kiếm các phần tử có class dropzone

            $(document).ready(function() {
                $("#myDropzone_2").dropzone({
                    url: "/admin/upload", // Đường dẫn xử lý tệp tin sau khi tải lên
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                            'content')
                    },
                    maxFiles: 1,
                    maxFilesize: 2, // Dung lượng tối đa cho mỗi tệp tin (đơn vị MB)
                    acceptedFiles: ".png, .jpg", // Các loại tệp tin được chấp nhận
                    addRemoveLinks: true, // Cho phép xóa tệp tin sau khi đã tải lên
                    dictDefaultMessage: "Kéo và thả tệp tin vào đây hoặc nhấp để chọn tệp", // Tin nhắn mặc định
                    success: function(file, response) {

                        $('form').append('<input type="hidden" name="avatar" value="' + response +
                            '">')
                        uploadedDocumentMap[file.name] = response
                    },
                    removedfile: function(file) {
                        file.previewElement.remove()
                        var name = ''
                        if (typeof file.name !== 'undefined') {
                            name = file.name
                        } else {
                            name = uploadedDocumentMap[file.name]
                        }
                        $('form').find('input[name="avatar"][value="' + name + '"]').remove()
                    },
                    init: function() {
                        @if ($products->avatar)
                            console.log('{{ $products->avatar }}');
                            let mockFile = {
                                name: "{{ $products->avatar }}",
                                size: 12345 // Adjust size if needed
                            };
                            this.files.push(mockFile);
                            this.displayExistingFile(mockFile, "{{ env('APP_URL') . $products->avatar }}");

                            $('form').append('<input type="hidden" name="avatar" value="' +
                                "{{ $products->avatar }}" + '">')
                        @endif

                        this.on("addedfile", function(file) {
                            if (this.files.length > 1) {
                                $('form').find('input[name="avatar"][value="' + this.files[0].name +
                                    '"]').remove()
                                this.removeFile(this.files[0]);

                            }
                        })
                    }
                })
            });
        </script>
    @endpush
</x-app-layout>
