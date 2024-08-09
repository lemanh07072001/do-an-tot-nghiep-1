<x-app-layout>
    @section('title', config('apps.user.titleUpdate'))
    <div class="p-4 max-h-full block sm:flex items-center justify-between   dark:bg-gray-800 ">
        <div class="w-full mb-1">
            <div class="mb-4">
                {{ Breadcrumbs::render('userUpdate', $user) }}
                <div class="flex items-center content-center">
                    <h1 class="text-xl font-semibold text-gray-900 sm:text-2xl dark:text-white mr-2 ">@yield('title')
                    </h1>
                    <x-badges label="Hướng dẫn" type="primary" icon="{{ @svg('css-info', 'w-4 h-4') }}" />
                </div>
            </div>
        </div>


    </div>
    <x-card>
        <form method="POST" action="{{ route('account_module.user.update', $user) }}">
            @csrf
            <div class="grid grid-cols-6 gap-4 gap-y-4">
                {{--  Email  --}}
                <div class="col-span-6 sm:col-span-3">
                    <x-input-label for="email" required>Email</x-input-label>
                    <x-text-input name="email" :value="old('email') ?? $user->email" id="email" placeholder="name@flowbite.com"
                        icon="heroicon-o-envelope" />
                    <x-input-error error="email" class="mt-2" />
                </div>

                {{--  Name  --}}
                <div class="col-span-6 sm:col-span-3">
                    <x-input-label for="name" required>Họ tên</x-input-label>
                    <x-text-input name="name" id="name" :value="old('name') ?? $user->name" placeholder="Nhập họ tên"
                        icon="heroicon-o-user" />
                    <x-input-error error="name" class="mt-2" />
                </div>

                {{--  Password  --}}
                <div class="col-span-6 sm:col-span-3">
                    <x-input-label for="password" required>Mật khẩu</x-input-label>
                    <x-text-input-password name="password" id="password" placeholder="********"
                        icon="heroicon-o-key" />
                    <x-input-error error="password" class="mt-2" />
                </div>

                {{--  Password  --}}
                <div class="col-span-6 sm:col-span-3">
                    <x-input-label for="password_confirmation" required>Nhập mật khẩu</x-input-label>
                    <x-text-input-password name="password_confirmation" id="password_confirmation"
                        placeholder="********" icon="heroicon-o-key" />
                    <x-input-error error="password_confirmation" class="mt-2" />
                </div>

            </div>

            <div class="flex justify-end mt-3">
                <button type="submit"
                    class="text-white bg-gradient-to-r from-blue-500 via-blue-600 to-blue-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2">
                    Xác nhận
                </button>
                <a href="{{ route('account_module.user.index') }}"
                    class="text-white bg-gradient-to-r from-orange-400 via-orange-500 to-orange-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-green-300 dark:focus:ring-green-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2">
                    Quay lại
                </a>
            </div>
        </form>
    </x-card>

    @push('js')
        <script src="{{ asset('assets/user/dropzone.js') }}"></script>
    @endpush
</x-app-layout>
