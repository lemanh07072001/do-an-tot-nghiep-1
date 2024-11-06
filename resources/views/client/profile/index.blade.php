@extends('client.layout.layoutMatter')

@section('content')
    <!-- Break -->
    <section>
        <div class="container max-w-[1170px] mx-auto items-center h-full px-2.5 pt-6 ">
            <div class="grid md:grid-cols-1 lg:grid-cols-5 grid-cols-1">
                <div class="col-span-1 md:col-span-1 lg:col-span-3 mx-auto lg:m-0">
                    <nav class="flex items-center h-full w-full" aria-label="Breadcrumb">
                        <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
                            <li class="inline-flex items-center">
                                <a href="{{ route('index') }}"
                                    class="inline-flex items-center text-md font-medium text-gray-700 hover:text-[#ff5b26] ">
                                    <svg class="w-3 h-3 me-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                        fill="currentColor" viewBox="0 0 20 20">
                                        <path
                                            d="m19.707 9.293-2-2-7-7a1 1 0 0 0-1.414 0l-7 7-2 2a1 1 0 0 0 1.414 1.414L2 10.414V18a2 2 0 0 0 2 2h3a1 1 0 0 0 1-1v-4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v4a1 1 0 0 0 1 1h3a2 2 0 0 0 2-2v-7.586l.293.293a1 1 0 0 0 1.414-1.414Z" />
                                    </svg>
                                    Trang chủ
                                </a>
                            </li>
                            <li aria-current="page">
                                <div class="flex items-center">
                                    <svg class="rtl:rotate-180 w-3 h-3 text-gray-400 mx-1" aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2" d="m1 9 4-4-4-4" />
                                    </svg>
                                    <span class="ms-1 text-md font-medium text-gray-500 md:ms-2">Tài khoản</span>
                                </div>
                            </li>
                        </ol>
                    </nav>
                </div>

                <div class="col-span-1 mt-3 md:mt-3 lg:mt-0 md:col-span-1 lg:col-span-2 mx-auto lg:m-0">

                </div>
            </div>
        </div>
    </section>
    <!-- End -->
    <div>
        <div class="container max-w-[1170px] mx-auto   items-center h-full px-2.5 pb-6 ">
            <div class="mt-5">
                <div class="shadow-[0px_4px_30px_0px_rgba(0,0,0,0.1)] rounded-[10px] p-[20px] border-[1px] border-solid">
                    @if (session('success'))
                        <div class="p-4 mb-2 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400"
                            role="alert">
                            <div id="alert-3"
                                class="flex items-center  text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400"
                                role="alert">
                                <svg class="flex-shrink-0 w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                    fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
                                </svg>
                                <span class="sr-only">Info</span>
                                <div class="ms-3 text-sm font-medium">
                                    {{ session('success') }}
                                </div>
                                <button type="button"
                                    class="ms-auto -mx-1.5 -my-1.5 bg-green-50 text-green-500 rounded-lg focus:ring-2 focus:ring-green-400 p-1.5 hover:bg-green-200 inline-flex items-center justify-center h-8 w-8 dark:bg-gray-800 dark:text-green-400 dark:hover:bg-gray-700"
                                    data-dismiss-target="#alert-3" aria-label="Close">
                                    <span class="sr-only">Close</span>
                                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                        fill="none" viewBox="0 0 14 14">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    @endif
                    <table class="w-full">
                        <tbody>
                            <tr>
                                <td class="md:w-1/6 md:pr-[30px] align-top">
                                    <dl class="mb-2">
                                        <dt class=" md:font-bold md:text-[16px] ">
                                            Đơn hàng đặt mua
                                        </dt>
                                        <dd>
                                            <a class="loadingHref text-[#383838] md:text-[14px] hover:text-[#ff5b26] {{ $activeTab === 'danh-sach-don-hang' ? 'md:text-[#ff5b26]' : '' }}"
                                                href="{{ route('showTabs', ['view' => 'danh-sach-don-hang']) }}">
                                                Danh sách đơn hàng
                                            </a>
                                        </dd>
                                    </dl>
                                    <dl class="mb-2">
                                        <dt class=" md:font-bold md:text-[16px] ">
                                            Thông tin tài khoản
                                        </dt>
                                        <dd>
                                            <a class="loadingHref text-[#383838] md:text-[14px] hover:text-[#ff5b26] {{ $activeTab === 'thong-tin-ca-nhan' ? 'md:text-[#ff5b26]' : '' }}"
                                                href="{{ route('showTabs', ['view' => 'thong-tin-ca-nhan']) }}">
                                                Thông tin cá nhân
                                            </a>
                                        </dd>
                                        <dd>
                                            <a class="loadingHref text-[#383838] md:text-[14px] hover:text-[#ff5b26] {{ $activeTab === 'doi-mat-khau' ? 'md:text-[#ff5b26]' : '' }}"
                                                href="{{ route('showTabs', ['view' => 'doi-mat-khau']) }}">
                                                Thay đổi mật khẩu
                                            </a>
                                        </dd>
                                        <dd>
                                           <form method="POST" action="{{ route('logout') }}">
                                            @csrf
                                             <button type="submit" class="text-[#383838] md:text-[14px] hover:text-[#ff5b26]"
                                                href="?view=account-order">
                                                Đăng xuất
                                            </button>
                                           </form>
                                        </dd>
                                    </dl>
                                </td>
                                @if ($activeTab === 'danh-sach-don-hang')
                                    @include('client.profile.listCart', ['getOders' => $getOders])
                                @elseif($activeTab === 'thong-tin-ca-nhan')
                                    @include('client.profile.profile', ['getProfile' => $getProfile])
                                @elseif($activeTab === 'doi-mat-khau')
                                    @include('client.profile.changePassword')
                                @endif

                            </tr>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
@endpush
