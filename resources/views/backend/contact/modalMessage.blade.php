<div id="modalMessage" tabindex="-1" aria-hidden="true"
    class="fixed left-0 right-0 top-0 z-50 hidden h-[calc(100%-1rem)] max-h-full w-full overflow-y-auto overflow-x-hidden p-4 md:inset-0">
    <div class="relative max-h-full w-full max-w-2xl">
        <!-- Modal content -->
        <div class="relative rounded-lg bg-white shadow dark:bg-gray-700">
            <!-- Modal header -->
            <div class="flex items-start justify-between rounded-t border-b p-5 dark:border-gray-600">
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white lg:text-2xl">
                    Bình luận: <span id="title"></span>
                </h3>

            </div>
            <!-- Modal body -->
            <div class="space-y-6 p-6">
                <div class="overflow-hidden text-base font-normal truncate "><span class="font-semibold text-black">Họ
                        tên</span>: <span id="name"></span></div>
                <div class="overflow-hidden text-base font-normal truncate "><span
                        class="font-semibold text-black">Email</span>: <span id="email"></span></div>
                <div class="overflow-hidden text-base font-normal truncate "><span class="font-semibold text-black">Số
                        điện thoại</span>: <span id="phone"></span></div>

                <div  class="overflow-hidden text-base font-normal truncate "><span class="font-semibold text-black">Tin
                        nhắn:
                        <div class="block p-2.5 w-full text-sm min-h- text-gray-900 bg-gray-50 rounded-lg border border-gray-300 "
                            id="boxMessage">
                            <span id="message" class="text-wrap"></span>
                        </div>
                </div>

                <div id="alertMessae" class="overflow-hidden text-base font-normal truncate "><span class="font-semibold text-black">Tin
                    nhắn trả lời:
                    <div class="block p-2.5 w-full text-sm min-h- text-gray-900 bg-gray-50 rounded-lg border border-gray-300 "
                        id="boxRepMessage">
                        <span id="repMessage" class="text-wrap"></span>
                    </div>
            </div>

                <input type="hidden" id="id_modal" name="id_modal" value=""/>

            </div>
            <!-- Modal footer -->
            <div
                class="flex justify-end space-x-2 rtl:space-x-reverse rounded-b border-t border-gray-200 p-6 dark:border-gray-600">
                <button type="button" id="sendMessageOpen"
                    class="rounded-lg bg-blue-700 px-5 py-2.5 text-center text-sm font-medium text-white hover:bg-blue-800 focus:outline-none focus:ring-4 focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                    Trả lời
                </button>

            </div>

            <div class="absolute inset-x-0 inset-y-0 bg-gray-400 opacity-80" id="loadingIndicator">
                <div class="fixed top-0 left-0 z-50 w-screen h-screen flex items-center justify-center"
                    style="background: rgba(0, 0, 0, 0.3);">
                    <div class="bg-white border py-2 px-5 rounded-lg flex items-center flex-col">
                        <div class="loader-dots block relative w-20 h-5 mt-2">
                            <div class="absolute top-0 mt-1 w-3 h-3 rounded-full bg-green-500"></div>
                            <div class="absolute top-0 mt-1 w-3 h-3 rounded-full bg-green-500"></div>
                            <div class="absolute top-0 mt-1 w-3 h-3 rounded-full bg-green-500"></div>
                            <div class="absolute top-0 mt-1 w-3 h-3 rounded-full bg-green-500"></div>
                        </div>
                        <div class="text-gray-500 text-xs font-medium mt-2 text-center">
                            Loading...
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="modalSendMessage" tabindex="-1" aria-hidden="true"
    class="fixed left-0 right-0 top-0 z-50 hidden h-[calc(100%-1rem)] max-h-full w-full overflow-y-auto overflow-x-hidden p-4 md:inset-0">
    <div class="relative max-h-full w-full max-w-2xl">
        <!-- Modal content -->
        <div class="relative rounded-lg bg-white shadow dark:bg-gray-700">
            <!-- Modal header -->
            <div class="flex items-start justify-between rounded-t border-b p-5 dark:border-gray-600">
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white lg:text-2xl">
                    Trả lời tin nhắn
                </h3>

            </div>
            <!-- Modal body -->
            <div class="space-y-6 p-6">


                <div class="overflow-hidden text-base font-normal truncate "><span class="font-semibold text-black">Tin
                        nhắn:
                        <textarea id="messageSend" rows="4" required
                            class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            placeholder="Nhập nội dung tin nhắn..."></textarea>
                </div>

            </div>
            <!-- Modal footer -->
            <div
                class="flex justify-end space-x-2 rtl:space-x-reverse rounded-b border-t border-gray-200 p-6 dark:border-gray-600">
                <button type="button" id="sendMessage"
                    class="rounded-lg bg-blue-700 px-5 py-2.5 text-center text-sm font-medium text-white hover:bg-blue-800 focus:outline-none focus:ring-4 focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                    Trả lời
                </button>

            </div>

            <div class="absolute inset-x-0 inset-y-0 bg-gray-400 opacity-80" id="loadingIndicatorSend">
                <div class="fixed top-0 left-0 z-50 w-screen h-screen flex items-center justify-center"
                    style="background: rgba(0, 0, 0, 0.3);">
                    <div class="bg-white border py-2 px-5 rounded-lg flex items-center flex-col">
                        <div class="loader-dots block relative w-20 h-5 mt-2">
                            <div class="absolute top-0 mt-1 w-3 h-3 rounded-full bg-green-500"></div>
                            <div class="absolute top-0 mt-1 w-3 h-3 rounded-full bg-green-500"></div>
                            <div class="absolute top-0 mt-1 w-3 h-3 rounded-full bg-green-500"></div>
                            <div class="absolute top-0 mt-1 w-3 h-3 rounded-full bg-green-500"></div>
                        </div>
                        <div class="text-gray-500 text-xs font-medium mt-2 text-center">
                            Loading...
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
