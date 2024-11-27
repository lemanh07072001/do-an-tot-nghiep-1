<x-app-layout>
    @section('title', config('apps.setting.titleLabel'))
    <div class="p-4 max-h-full bg-white block sm:flex items-center justify-between   dark:bg-gray-800 ">

        <div class="w-full mb-1">
            <div class="mb-4">
                {{ Breadcrumbs::render('setting') }}
                <div class="flex items-center content-center">
                    <h1 class="text-xl font-semibold text-gray-900 sm:text-2xl dark:text-white mr-2 ">@yield('title')
                    </h1>
                    <x-badges label="Hướng dẫn" type="primary" icon="{{ @svg('css-info', 'w-4 h-4') }}" />
                </div>
            </div>

        </div>



    </div>

    <div>
        <form method="POST" action="{{ route('setting_module.setting.updateOrCreate') }}">
            @csrf
            <div class="grid grid-cols-12 ">
                <div class="col-span-4 ">
                    <div class="my-0 m-4">
                        <h5 class="mb-1 text-lg font-bold tracking-tight text-green-900 dark:text-white">Thông tin
                            website
                        </h5>
                        <p class="mb-3 text-xs text-green-700">Dưới đây là các thông tin chi tiết về cửa hàng như logo,
                            tên website, .
                        </p>
                    </div>
                </div>

                <div class="col-span-8 ">
                    <x-card class="my-0">

                        <div class="col-span-6 sm:col-span-3 ">
                            <x-input-label for="setting_name" required>Tên website</x-input-label>
                            <x-text-input name="setting_name" :value="old('setting_name') ?? $settings['setting_name']" id="setting_name"
                                placeholder="Tên website" />
                            <x-input-error error="setting_name" class="mt-2" />
                        </div>

                        <div class="col-span-6 sm:col-span-3 sm:row-span-2">
                            <x-input-label for="logo" required>Logo</x-input-label>
                            <input type="hidden" id="setting_logo" name="setting_logo" value="">
                            <div id="logo"
                                class="dropzone border-4 border-dashed border-gray-300 rounded-lg p-4 text-center flex flex-col items-center justify-center">
                            </div>
                            <x-input-error error="setting_logo" class="mt-2" />
                        </div>

                    </x-card>
                </div>
            </div>

            <div class="grid grid-cols-12 mt-4">
                <div class="col-span-4 ">
                    <div class="my-0 m-4">
                        <h5 class="mb-1 text-lg font-bold tracking-tight text-green-900 dark:text-white">Thông tin liên
                            hệ
                        </h5>
                        <p class="mb-3 text-xs text-green-700">Dưới đây là các thông tin chi tiết về địa chỉ, số điện
                            thoại, email, .
                    </div>



                </div>

                <div class="col-span-8 ">
                    <x-card class="my-0">
                        <div class="col-span-6 sm:col-span-3 ">
                            <x-input-label for="setting_address" required>Địa chỉ</x-input-label>
                            <x-text-input name="setting_address" :value="old('setting_address') ?? $settings['setting_address']" id="setting_address"
                                placeholder="Nhập địa chỉ cửa hàng" />
                            <x-input-error error="setting_address" class="mt-2" />
                        </div>

                        <div class="col-span-6 sm:col-span-3 ">
                            <x-input-label for="setting_phone" required>Số điện thoại</x-input-label>
                            <x-text-input name="setting_phone" :value="old('setting_phone') ?? $settings['setting_phone']" id="setting_phone"
                                placeholder="Nhập số điện thoại" />
                            <x-input-error error="setting_phone" class="mt-2" />
                        </div>

                        <div class="col-span-6 sm:col-span-3 ">
                            <x-input-label for="setting_email" required>Email</x-input-label>
                            <x-text-input name="setting_email" :value="old('setting_email') ?? $settings['setting_email']" id="setting_email"
                                placeholder="Nhập địa chỉ Email" />
                            <x-input-error error="setting_email" class="mt-2" />
                        </div>
                    </x-card>
                </div>

            </div>

            {{-- Box AI --}}
            <div class="grid grid-cols-12 mt-4">
                <div class="col-span-4 ">
                    <div class="my-0 m-4">
                        <h5 class="mb-1 text-lg font-bold tracking-tight text-green-900 dark:text-white">AI API KEY
                        </h5>
                        <p class="mb-3 text-xs text-green-700">Dưới đây là thông tin AI API KEY hỗ trợ
                    </div>



                </div>

                <div class="col-span-8 ">
                    <x-card class="my-0">
                        <div class="col-span-6 sm:col-span-3 ">
                            <x-input-label for="setting_ai_key" required>AI KEY</x-input-label>
                            <x-text-input name="setting_ai_key" :value="old('setting_ai_key') ?? $settings['setting_ai_key']" id="setting_ai_key"
                                placeholder="Nhập key AI" />
                            <x-input-error error="setting_ai_key" class="mt-2" />
                        </div>


                    </x-card>
                </div>

            </div>

            {{-- Social Network --}}
            <div class="grid grid-cols-12 mt-4">
                <div class="col-span-4 ">
                    <div class="my-0 m-4">
                        <h5 class="mb-1 text-lg font-bold tracking-tight text-green-900 dark:text-white">Mạng xã hội
                        </h5>
                        <p class="mb-3 text-xs text-green-700">Dưới đây là thông tin Facebook, Zalo,...
                    </div>



                </div>

                <div class="col-span-8 ">
                    <x-card class="my-0">
                        <div class="col-span-6 sm:col-span-3 ">
                            <x-input-label for="setting_facebook">Facebook</x-input-label>
                            <x-text-input name="setting_facebook" :value="old('setting_facebook') ?? $settings['setting_facebook']" id="setting_facebook"
                                placeholder="Nhập link Facebook" />
                            <x-input-error error="setting_facebook" class="mt-2" />
                        </div>

                        <div class="col-span-6 sm:col-span-3 ">
                            <x-input-label for="setting_zalo">Zalo</x-input-label>
                            <x-text-input name="setting_zalo" :value="old('setting_zalo') ?? $settings['setting_zalo']" id="setting_zalo"
                                placeholder="Nhập link Zalo" />
                            <x-input-error error="setting_zalo" class="mt-2" />
                        </div>

                        <div class="col-span-6 sm:col-span-3 ">
                            <x-input-label for="setting_twitter">Twitter</x-input-label>
                            <x-text-input name="setting_twitter" :value="old('setting_twitter') ?? $settings['setting_twitter']" id="setting_twitter"
                                placeholder="Nhập link Twitter" />
                            <x-input-error error="setting_twitter" class="mt-2" />
                        </div>

                        <div class="col-span-6 sm:col-span-3 ">
                            <x-input-label for="setting_instagram">Instagram</x-input-label>
                            <x-text-input name="setting_instagram" :value="old('setting_instagram') ?? $settings['setting_instagram']" id="setting_instagram"
                                placeholder="Nhập link Instagram" />
                            <x-input-error error="setting_instagram" class="mt-2" />
                        </div>

                    </x-card>
                </div>

            </div>

            {{-- Gmail --}}
            <div class="grid grid-cols-12 mt-4">
                <div class="col-span-4 ">
                    <div class="my-0 m-4">
                        <h5 class="mb-1 text-lg font-bold tracking-tight text-green-900 dark:text-white">Email
                        </h5>
                        <p class="mb-3 text-xs text-green-700">Dưới đây là thông tin phân trang
                    </div>



                </div>

                <div class="col-span-8 ">
                    <x-card class="my-0">
                        <div class="col-span-6 sm:col-span-3 ">
                            <x-input-label for="setting_paginate">Số lượng sản phẩm trên 1 trang</x-input-label>
                            <x-text-input name="setting_paginate" :value="old('setting_paginate') ?? $settings['setting_paginate']" id="setting_email_address"
                                placeholder="Nhập số lượng" />
                            <x-input-error error="setting_paginate" class="mt-2" />
                        </div>
                    </x-card>
                </div>

            </div>

            <div class="col-span-6 sm:col-span-3">
                <div class="flex justify-end mt-3">
                    <button type="submit"
                        class="text-white bg-gradient-to-r from-blue-500 via-blue-600 to-blue-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2">
                        <span class="saveBtn">Xác nhận</span>
                        <span class="loadingBtn" style="display: none">
                            <svg aria-hidden="true" role="status"
                                class="inline w-4 h-4 me-3 text-gray-200 animate-spin dark:text-gray-600"
                                viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z"
                                    fill="currentColor" />
                                <path
                                    d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z"
                                    fill="#1C64F2" />
                            </svg>
                            Loading...
                        </span>

                </div>

        </form>

    </div>

    @push('js')
        <script>
            var imageUrl = {{ Js::from(env('APP_URL') . $settings['setting_logo']) }};


            var uploadedDocumentMap = {}
            // Khởi tạo Dropzone trên phần tử có ID là myDropzone
            Dropzone.autoDiscover = false; // Tắt chế độ tự động tìm kiếm các phần tử có class dropzone

            $(document).ready(function() {
                $("#logo").dropzone({
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
                        $('form').append('<input type="hidden" name="setting_logo" value="' + response +
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
                        $('form').find('input[name="setting_logo"][value="' + name + '"]').remove()
                    },
                    init: function() {
                        @if (old('setting_logo') || $settings['setting_logo'])

                            let mockFile = {
                                name: "{{ old('setting_logo') ?? $settings['setting_logo'] }}",
                                size: 12345 // Adjust size if needed
                            };
                            console.log(
                                "{{ env('APP_URL') . (old('setting_logo') ?? $settings['setting_logo']) }}"
                                );
                            this.files.push(mockFile);
                            this.displayExistingFile(mockFile,
                                "{{ env('APP_URL') . (old('setting_logo') ?? $settings['setting_logo']) }}"
                                );

                            $('form').append('<input type="hidden" name="setting_logo" value="' +
                                "{{ old('setting_logo') ?? $settings['setting_logo'] }}" + '">')
                        @endif

                        this.on("addedfile", function(file) {
                            if (this.files.length > 1) {
                                $('form').find('input[name="setting_logo"][value="' + this.files[0]
                                    .name + '"]').remove()
                                this.removeFile(this.files[0]);

                            }
                        })
                    }
                })
            });
        </script>
    @endpush
</x-app-layout>
