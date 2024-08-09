<x-app-layout>
    @section('title', config('apps.products.titleCreate'))
    <div class="p-4 max-h-full block sm:flex items-center justify-between   dark:bg-gray-800 ">
        <div class="w-full mb-1">
            <div class="mb-4">
                {{ Breadcrumbs::render('productsCreate') }}
                <div class="flex items-center content-center">
                    <h1 class="text-xl font-semibold text-gray-900 sm:text-2xl dark:text-white mr-2 ">@yield('title')
                    </h1>
                    <x-badges label="Hướng dẫn" type="primary" icon="{{ @svg('css-info', 'w-4 h-4') }}" />
                </div>
            </div>
        </div>


    </div>
    <x-card>
        <form method="POST" action="{{ route('ecommerce_module.banner.store') }}">
            @csrf
            <div class="grid grid-cols-6 gap-4 gap-y-4 ">

                <div class="col-span-6 sm:col-span-3 ">
                    <x-input-label for="name" required>Tên sản phẩm</x-input-label>
                    <x-text-input name="name" :value="old('name')" id="name" placeholder="Tên tiêu đề" />
                    <x-input-error error="name" class="mt-2" />
                </div>

                <div class="col-span-6 sm:col-span-3">
                    <x-input-label for="slug" required>Slug</x-input-label>
                    <x-text-input name="slug" :value="old('slug')" id="slug" />
                    <x-input-error error="slug" class="mt-2" />
                </div>

                <div class="col-span-6 sm:col-span-6">
                    <x-input-label for="short_description">Mô tả ngắn</x-input-label>
                    <x-text-arena name="short_description" :value="old('short_description')" id="short_description" />
                    <x-input-error error="short_description" class="mt-2" />
                </div>

                <div class="col-span-6 sm:col-span-6 sm:row-span-6">
                    <x-input-label for="myDropzone_1" required>Hình ảnh</x-input-label>
                    <input type="hidden" id="image_id" name="image" value="">
                    <div id="myDropzone_1" style="max-width:100%"
                        class="dropzone border-4 border-dashed border-gray-300 rounded-lg p-4 flex-wrap text-center flex items-center justify-center">

                    </div>
                    <x-input-error error="image" class="mt-2" />
                </div>


                <div class="col-span-6 sm:col-span-6">
                    <x-input-label for="description">Nội dung</x-input-label>
                    <x-text-arena name="description" :value="old('description')" id="description" />
                    <x-input-error error="description" class="mt-2" />
                </div>

                <div class="col-span-6 sm:col-span-6 sm:row-span-6">
                    <x-input-label for="myDropzone_2" required>Ảnh đại diện</x-input-label>
                    <input type="hidden" id="image_id" name="image" value="">
                    <div id="myDropzone_2"
                        class="dropzone border-4 border-dashed border-gray-300 rounded-lg p-4 text-center flex flex-col items-center justify-center">

                    </div>
                    <x-input-error error="image" class="mt-2" />
                </div>

                <div class="col-span-6 sm:col-span-2 ">
                    <x-input-label for="suk" required>SUK</x-input-label>
                    <x-text-input name="suk" :value="old('suk')" id="suk" placeholder="Mã sản phẩm" />
                    <x-input-error error="suk" class="mt-2" />
                </div>

                <div class="col-span-6 sm:col-span-2">
                    <x-input-label for="price" required>Giá</x-input-label>
                    <x-text-input name="price" :value="old('price')" id="price" />
                    <x-input-error error="price" class="mt-2" />
                </div>

                <div class="col-span-6 sm:col-span-2">
                    <x-input-label for="discount" required>Giảm giá</x-input-label>
                    <x-text-input name="discount" :value="old('discount')" id="discount" />
                    <x-input-error error="discount" class="mt-2" />
                </div>

                <div class="col-span-6 sm:col-span-2 ">
                    <x-input-label required>Trạng thái</x-input-label>
                    <x-select data-search="search-status" name="status">
                        @if (\App\Enums\Status::getValues())
                            <option disabled>--Chọn trạng thái--</option>
                            @foreach (\App\Enums\Status::getValues() as $status)
                                <option value="{{ $status }}">
                                    {{ \App\Enums\Status::getKey($status) }}</option>
                            @endforeach
                        @endif
                    </x-select>
                </div>

                <div class="col-span-6 sm:col-span-2 ">
                    <x-input-label required>Nhãn</x-input-label>
                    <x-select name="label">
                        @if (!empty($getAllLabelSelect))
                            <option value="">--Chọn nhãn--</option>
                            @foreach ($getAllLabelSelect as $label)
                                <option value="{{ $label->id }}">
                                    {{ $label->name }}</option>
                            @endforeach
                        @endif
                    </x-select>
                </div>

                <div class="col-span-6 sm:col-span-2 ">
                    <x-input-label required>Thương hiệu</x-input-label>
                    <x-select name="brand">
                        @if (!empty($getAllBrandSelect))
                            <option value="">--Chọn thương hiệu--</option>
                            @foreach ($getAllBrandSelect as $brand)
                                <option value="{{ $brand->id }}">
                                    {{ $brand->name }}</option>
                            @endforeach
                        @endif
                    </x-select>
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

    @push('js')


        <script src="{{ asset('assets/apps/products/customPrduct.js') }}"></script>

        <script>
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
                    uploadMultiple: true,
                    maxFilesize: 2, // Dung lượng tối đa cho mỗi tệp tin (đơn vị MB)
                    acceptedFiles: ".png, .jpg", // Các loại tệp tin được chấp nhận
                    addRemoveLinks: true, // Cho phép xóa tệp tin sau khi đã tải lên
                    dictDefaultMessage: "Kéo và thả tệp tin vào đây hoặc nhấp để chọn tệp", // Tin nhắn mặc định
                    success: function(file, response) {
                        console.log(file, response);
                        $('form').append('<input type="hidden" name="images[]" value="' + response +
                            '">')
                        uploadedDocumentMap[file.name] = response
                    },
                    removedfile: function(file) {
                        file.previewElement.remove()
                        var name = ''
                        if (typeof file.file_name !== 'undefined') {
                            name = file.file_name
                        } else {
                            name = uploadedDocumentMap[file.name]
                        }
                        $('form').find('input[name="images[]"][value="' + name + '"]').remove()
                    },
                    init: function() {
                        @if (old('image'))
                            let mockFile = {
                                name: "{{ old('image') }}",
                                size: 12345 // Adjust size if needed
                            };
                            this.files.push(mockFile);
                            this.displayExistingFile(mockFile, "{{ env('APP_URL') . old('image') }}");

                            $('form').append('<input type="hidden" name="images[]" value="' +
                                "{{ old('image') }}" + '">')
                        @endif


                    }
                })
            });
        </script>

        <script>
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
                        $('form').append('<input type="hidden" name="image" value="' + response +
                            '">')
                        uploadedDocumentMap[file.name] = response
                    },
                    removedfile: function(file) {
                        file.previewElement.remove()
                        var name = ''
                        if (typeof file.file_name !== 'undefined') {
                            name = file.file_name
                        } else {
                            name = uploadedDocumentMap[file.name]
                        }
                        $('form').find('input[name="image"][value="' + name + '"]').remove()
                    },
                    init: function() {
                        @if (old('image'))
                            let mockFile = {
                                name: "{{ old('image') }}",
                                size: 12345 // Adjust size if needed
                            };
                            this.files.push(mockFile);
                            this.displayExistingFile(mockFile, "{{ env('APP_URL') . old('image') }}");

                            $('form').append('<input type="hidden" name="image" value="' +
                                "{{ old('image') }}" + '">')
                        @endif

                        this.on("addedfile",function(file){
                            if(this.files.length > 1){
                                $('form').find('input[name="image"][value="' + this.files[0].name + '"]').remove()
                                this.removeFile(this.files[0]);

                            }
                        })
                    }
                })
            });
        </script>
    @endpush
</x-app-layout>
