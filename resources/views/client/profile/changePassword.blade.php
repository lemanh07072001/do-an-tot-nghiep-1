<td class="md:h-[300px] md:align-top">
    <div class="bg-white overflow-hidden shadow rounded-lg border">
        <div class="px-4 py-5 sm:px-6">
            <h3 class="text-lg leading-6 font-medium text-gray-900">
                Đổi mật khẩu
            </h3>
            <p class="mt-1 max-w-2xl text-sm text-gray-500">
                Cập nhật mật khẩu mới
            </p>
        </div>
        <div class="border-t border-gray-200 px-4 py-5 sm:p-0">
            <form class="max-w-sm mx-auto my-5" action="{{ route('changePassword') }}" method="POST">
                @csrf
                <div class="mb-5">
                    <label for="current_password" class="block mb-2 text-sm font-medium text-gray-900">
                        Mật khẩu cũ
                    </label>
                    <input type="password" id="current_password" name="current_password"
                        class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2 "
                        placeholder="********" />
                        @error('current_password')
                        <div class="text-red-600 text-[12px]">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-5">
                    <label for="new_password" class="block mb-2 text-sm font-medium text-gray-900">
                        Mật khẩu mới
                    </label>
                    <input type="password" id="new_password" name="new_password"
                        class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2 "
                        placeholder="********" />
                    @error('new_password')
                        <div class="text-red-600 text-[12px]">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-5">
                    <label for="new_password_confirmation" class="block mb-2 text-sm font-medium text-gray-900">
                        Xác nhận mật khẩu
                    </label>
                    <input type="password" id="new_password_confirmation" name="new_password_confirmation"
                        class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2 "
                        placeholder="********" />
                        @error('new_password_confirmation')
                        <div class="text-red-600 text-[12px]">{{ $message }}</div>
                    @enderror
                </div>
                <button type="submit"
                    class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                    Cập nhật
                </button>
            </form>
        </div>
    </div>

</td>
