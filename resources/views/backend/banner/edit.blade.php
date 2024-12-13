<x-app-layout>

    @section('title', config('apps.banner.titleUpdate'))
    <div class="p-4 max-h-full block sm:flex items-center justify-between   dark:bg-gray-800 ">
        <div class="w-full mb-1">
            <div class="mb-4">
                {{ Breadcrumbs::render('bannerUpdate', $banner) }}
                <div class="flex items-center content-center">
                    <h1 class="text-xl font-semibold text-gray-900 sm:text-2xl dark:text-white mr-2 ">@yield('title')
                    </h1>
                    <x-badges label="Hướng dẫn" type="primary" icon="{{ @svg('css-info', 'w-4 h-4') }}" />
                </div>
            </div>
        </div>

    </div>
    <x-card>
        <form method="POST" action="{{ route('ecommerce_module.banner.update', $banner) }}">
            @csrf
            <div class="grid grid-cols-6 gap-4 gap-y-4 ">

                <div class="col-span-6 sm:col-span-3 ">
                    <x-input-label for="name" required>Tên tiêu đề</x-input-label>
                    <x-text-input name="name" :value="old('name') ?? $banner->name" id="name" placeholder="Tên tiêu đề" />
                    <x-input-error error="name" class="mt-2" />
                </div>

                <div class="col-span-6 sm:col-span-3">
                    <x-input-label for="slug" required>Slug</x-input-label>
                    <x-text-input name="slug" :value="old('slug') ?? $banner->slug" id="slug" />
                    <x-input-error error="slug" class="mt-2" />
                </div>

                <div class="col-span-6 sm:col-span-3 ">
                    <x-input-label for="link">Link</x-input-label>
                    <x-text-input name="link" :value="old('link') ?? $banner->link" id="link" placeholder="Link" />
                    <x-input-error error="link" class="mt-2" />
                </div>



                <div class="col-span-6 sm:col-span-3 ">
                    <x-input-label required>Trạng thái</x-input-label>
                    <x-select data-search="search-status" name="status">
                        @if (\App\Enums\Status::getValues())
                            <option disabled>--Chọn trạng thái--</option>
                            @foreach (\App\Enums\Status::getValues() as $status)
                                <option value="{{ $status }}" @selected(old('status', $banner->status) == $status)>
                                    {{ \App\Enums\Status::getKey($status) }}</option>
                            @endforeach
                        @endif
                    </x-select>
                </div>

                <div class="col-span-6 sm:col-span-3">
                    <x-input-label for="date_start">Ngày bắt đầu</x-input-label>
                    <div class="relative ">
                        <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                            <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z" />
                            </svg>
                        </div>
                        <input id="date_start" type="text" name="date_start" autocomplete="off"
                            value="{{ old('date_start') ?? (($banner->date_end)==null?'':\Carbon\Carbon::parse($banner->date_start)->format('d/m/Y')) }}"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            placeholder="Chọn ngày">
                    </div>
                    <x-input-error error="date_start" class="mt-2" />
                </div>


                <div class="col-span-6 sm:col-span-3 ">
                    <x-input-label for="date_end">Ngày kết thúc</x-input-label>
                    <div class="relative ">
                        <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                            <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z" />
                            </svg>
                        </div>
                        <input id="date_end" type="text" name="date_end" autocomplete="off"
                            value="{{ old('date_end') ?? (($banner->date_end)==null?'':\Carbon\Carbon::parse($banner->date_end)->format('d/m/Y')) }}"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            placeholder="Chọn ngày">
                    </div>
                    <x-input-error error="date_end" class="mt-2" />
                </div>


                <div class="col-span-6 sm:col-span-3 sm:row-span-2">
                    <x-input-label for="myDropzone" required>Hình ảnh</x-input-label>
                    <input type="hidden" id="image_id" name="image" value="">
                    <div id="myDropzone"
                        class="dropzone border-4 border-dashed border-gray-300 rounded-lg p-4 text-center flex flex-col items-center justify-center">
                        <p class="text-gray-500">Drag and drop files here or click to upload</p>
                    </div>
                    <x-input-error error="image" class="mt-2" />
                </div>

                <div class="col-span-6 sm:col-span-3">
                    <div class="flex justify-end mt-3">
                        <button type="submit"
                            class="text-white bg-gradient-to-r from-blue-500 via-blue-600 to-blue-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2">
                            <span class="saveBtn">Xác nhận</span>
                            <span class="loadingBtn" style="display: none">
                                <svg aria-hidden="true" role="status" class="inline w-4 h-4 me-3 text-gray-200 animate-spin dark:text-gray-600" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/>
                                    <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="#1C64F2"/>
                                    </svg>
                                    Loading...
                            </span>
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
        <script>
            document.addEventListener('DOMContentLoaded', function() {

                const $dateStartEl = document.getElementById('date_start');
                const $dateEndEl = document.getElementById('date_end');

                const options = {
                    defaultDatepickerId: null,
                    autohide: true,
                    format: 'dd/mm/yyyy',
                    maxDate: null,
                    minDate: null,
                    orientation: 'bottom',
                    buttons: true,
                    autoSelectToday: false,
                    title: "Flowbite datepicker",
                    rangePicker: false,
                    language: 'vi'

                };

                const dateStartEl = new Datepicker($dateStartEl, options);
                const dateEndEl = new Datepicker($dateEndEl, options);

            });
        </script>

        <script>
            $('#name').on('change', function() {
                let _this = $(this)

                ChangeToSlug(_this.val());
            })
        </script>

        <script>
            var imageUrl = @json(env('APP_URL'). $banner->image);

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

                        @if ( $banner->image)
                           // Tìm và xóa ảnh hiện tại khỏi Dropzone

                            let mockFile = {
                                name: '{{$banner->image}}',
                                size: 11213
                            };

                            this.files.push(mockFile);
                            this.displayExistingFile(mockFile, imageUrl);

                            $('form').append('<input type="hidden" name="image" value="' + @json($banner->image) + '">');

                        @endif

                        this.on("addedfile",function(file){
                            if(this.files.length > 1){
                                $('form').find('input[name="image"][value="' + this.files[0].name + '"]').remove()
                                this.removeFile(this.files[0]);

                            }
                        })
                    },

                })
            });
        </script>
    @endpush
</x-app-layout>
