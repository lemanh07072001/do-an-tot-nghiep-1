<x-app-layout>
    @section('title', config('apps.client.titleUpdate'))
    <div class="p-4 max-h-full block sm:flex items-center justify-between   dark:bg-gray-800 ">
        <div class="w-full mb-1">
            <div class="mb-4">
                {{ Breadcrumbs::render('clientUpdate',$client) }}
                <div class="flex items-center content-center">
                    <h1 class="text-xl font-semibold text-gray-900 sm:text-2xl dark:text-white mr-2 ">@yield('title')
                    </h1>
                    <x-badges label="Hướng dẫn" type="primary" icon="{{ @svg('css-info', 'w-4 h-4') }}" />
                </div>
            </div>
        </div>


    </div>

    <x-card>
        <form method="POST" action="{{ route('account_module.client.update',$client) }}">
            @csrf
            <div class="grid grid-cols-6 gap-4 gap-y-4">
                {{--  Email  --}}
                <div class="col-span-6 sm:col-span-3">
                    <x-input-label for="email" required>Email</x-input-label>
                    <x-text-input name="email" :value="old('email')??$client->email" id="email" placeholder="name@flowbite.com"
                        icon="heroicon-o-envelope" />
                    <x-input-error error="email" class="mt-2" />
                </div>

                {{--  Name  --}}
                <div class="col-span-6 sm:col-span-3">
                    <x-input-label for="name" required>Họ tên</x-input-label>
                    <x-text-input name="name" id="name" :value="old('name')??$client->name" placeholder="Nhập họ tên"
                        icon="heroicon-o-user" />
                    <x-input-error error="name" class="mt-2" />
                </div>

                {{--  Phone  --}}
                <div class="col-span-6 sm:col-span-3">
                    <x-input-label for="phone" required>Điện thoại</x-input-label>
                    <x-text-input name="phone" id="phone" :value="old('phone') ?? $client->profiles->phone" placeholder="Nhập số điện thoại"
                        icon="heroicon-o-phone" />
                    <x-input-error error="phone" class="mt-2" />
                </div>

                {{--  Address  --}}
                <div class="col-span-6 sm:col-span-3">
                    <x-input-label for="address" required>Địa chỉ</x-input-label>
                    <x-text-input name="address" id="address" :value="old('address') ?? $client->profiles->address" placeholder="Nhập địa chỉ"
                        icon="heroicon-o-fire" />
                    <x-input-error error="address" class="mt-2" />
                </div>



            </div>

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
            </button>
                <a href="{{ route('account_module.client.index') }}"
                    class="text-white bg-gradient-to-r from-orange-400 via-orange-500 to-orange-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-green-300 dark:focus:ring-green-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2">
                    Quay lại
                </a>
            </div>
        </form>
    </x-card>

    @push('js')




    @endpush
</x-app-layout>
