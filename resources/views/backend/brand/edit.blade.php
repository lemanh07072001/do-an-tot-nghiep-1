<x-app-layout>
    @section('title', config('apps.brand.titleUpdate'))
    <div class="p-4 max-h-full block sm:flex items-center justify-between   dark:bg-gray-800 ">
        <div class="w-full mb-1">
            <div class="mb-4">
                {{ Breadcrumbs::render('brandUpdate',$brand) }}
                <div class="flex items-center content-center">
                    <h1 class="text-xl font-semibold text-gray-900 sm:text-2xl dark:text-white mr-2 ">@yield('title')
                    </h1>
                    <x-badges label="Hướng dẫn" type="primary" icon="{{ @svg('css-info', 'w-4 h-4') }}" />
                </div>
            </div>
        </div>


    </div>
    <x-card>
        <form method="POST" action="{{ route('ecommerce_module.brand.update',$brand) }}">
            @csrf
            <div class="grid grid-cols-6 gap-4 gap-y-4 ">

                <div class="col-span-6 sm:col-span-3 ">
                    <x-input-label for="name" required>Tên thương hiệu</x-input-label>
                    <x-text-input name="name" :value="old('name') ?? $brand->name" id="name" placeholder="Tên thương hiệu" />
                    <x-input-error error="name" class="mt-2" />
                </div>

                <div class="col-span-6 sm:col-span-3">
                    <x-input-label for="slug" required>Slug</x-input-label>
                    <x-text-input name="slug" :value="old('slug')??$brand->slug" id="slug" />
                    <x-input-error error="slug" class="mt-2" />
                </div>

                <div class="col-span-6 sm:col-span-3 ">
                    <x-input-label required>Trạng thái</x-input-label>
                    <x-select data-search="search-status" name="status">
                        @if (\App\Enums\Status::getValues())
                            <option disabled>--Chọn trạng thái--</option>
                            @foreach (\App\Enums\Status::getValues() as $status)
                                <option value="{{ $status }}" @selected(old('status', $brand->status) == $status)>
                                    {{ \App\Enums\Status::getKey($status) }}</option>
                            @endforeach
                        @endif
                    </x-select>
                </div>


                <div class="col-span-6 sm:col-span-3 sm:row-span-2">
                    <x-input-label for="myDropzone" required>Hình ảnh</x-input-label>
                    <input type="hidden" id="image_id" name="image" value="">
                    <div id="myDropzone"
                        class="dropzone border-4 border-dashed border-gray-300 rounded-lg p-4 text-center flex flex-col items-center justify-center">
                    </div>
                    <x-input-error error="image" class="mt-2" />
                </div>

                <div class="col-span-6 sm:col-span-3">
                    <div class="flex justify-end mt-3">
                        <button type="submit"
                            class="text-white bg-gradient-to-r from-blue-500 via-blue-600 to-blue-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2">
                            Xác nhận
                        </button>
                        <a href="{{ route('ecommerce_module.brand.index') }}"
                            class="text-white bg-gradient-to-r from-orange-400 via-orange-500 to-orange-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-green-300 dark:focus:ring-green-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2">
                            Quay lại
                        </a>
                    </div>
                </div>

            </div>


        </form>
    </x-card>

    @push('js')


        <script>
            $('#name').on('change', function() {
                let _this = $(this)

                ChangeToSlug(_this.val());
            })
        </script>

        <script>
             var imageUrl = @json(env('APP_URL'). $brand->image);

            var uploadedDocumentMap = {}
            // Khởi tạo Dropzone trên phần tử có ID là myDropzone
            Dropzone.autoDiscover = false; // Tắt chế độ tự động tìm kiếm các phần tử có class dropzone

            $(document).ready(function() {
                $("#myDropzone").dropzone({
                    url: "/upload", // Đường dẫn xử lý tệp tin sau khi tải lên
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
                        if (typeof file.name !== 'undefined') {
                            name = file.name
                        } else {
                            name = uploadedDocumentMap[file.name]
                        }
                        $('form').find('input[name="image"][value="' + name + '"]').remove()
                    },
                    init: function() {
                        @if ($brand->image)
                        // Tìm và xóa ảnh hiện tại khỏi Dropzone

                            let mockFile = {
                                name: '{{$brand->image}}',
                                size: 11213
                            };

                            this.files.push(mockFile);
                            this.displayExistingFile(mockFile, imageUrl);

                            $('form').append('<input type="hidden" name="image" value="' + @json($brand->image) + '">');

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
