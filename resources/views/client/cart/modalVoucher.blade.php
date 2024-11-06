<div id="voucher-modal" tabindex="-1" aria-hidden="true"
    class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-lg max-h-full">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow ">
            <!-- Modal header -->
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t ">
                <h3 class="text-lg font-semibold text-gray-900">
                    Chọn Voucher
                </h3>
                <button type="button"
                    class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm h-8 w-8 ms-auto inline-flex justify-center items-center "
                    data-modal-toggle="voucher-modal">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>
            <!-- Modal body -->
            <div class="p-2 md:p-2">

                <div class="mt-3">
                    <p class="text-[#222222] text-[13px]">Voucher có thể áp dụng</p>
                    <div class="mt-3">
                        @if (count($getVouchers) > 0)
                            @foreach ($getVouchers as $voucher)
                                <div class="flex w-full mt-3 ">
                                    <div data-discount-type="{{ $voucher->discount_type }}"
                                        data-value-reduction="{{ $voucher->value_reduction }}"
                                        data-name="{{ $voucher->name }}"
                                        class="
                                    p-[12px_16px_4px] bg-[#fd5a26] w-full rounded-[10px] text-white relative  cursor-pointer list-voucher
                                    after:content-[''] after:absolute after:w-[10px] after:h-[10px] after:rounded-full after:bg-white after:top-1/2 after:translate-y-[-50%] after:left-[-5px]
                                    before::content-[''] before:absolute before:w-[10px] before:h-[10px] before:rounded-full before:bg-white before:top-1/2 before:translate-y-[-50%] before:right-[-5px]
                                    ">
                                        <div class="code-voucher" data-code="{{ $voucher->name }}">{{ $voucher->name }}
                                        </div>
                                        <div class="ml-3">
                                            <p class="text-white text-[12px]">Giảm
                                                {{ $voucher->value_reduction }}{{ $voucher->discount_type }} khi mua sản
                                                phẩm </p>
                                            @if ($voucher->date_start != null && $voucher->date_end != null)
                                                <p class="text-white text-[12px]">HSD: {{ $voucher->date_start }} - {{ $voucher->date_end }}</p>
                                            @else
                                                <p class="text-white text-[12px]">HSD: Vĩnh viễn</p>
                                            @endif

                                        </div>
                                    </div>

                                </div>
                            @endforeach
                        @else
                            <div class="flex w-full">
                                sda
                            </div>

                    </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</div>
</div>
