<section>
    <div class="container max-w-[1170px] mx-auto   items-center h-full px-2.5 pb-6">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2">
            <div class="col-span-1">
                <img src="{{ asset('images/client/Untitled-design-14.png') }}">
            </div>
            <div class="col-span-1">
                <div class="p-2">
                    <h4 class="uppercase font-bold text-[17px] lg:text-[20px] pl-3 leading-10">
                        GỬI TIN NHẮN NGAY CHO MONAFASHION
                        <br>
                        KHI BẠN CẦN HỖ TRỢ HOẶC CÓ THẮC MẮC NHÉ!
                    </h4>
                </div>

                <div class="p-5">
                    <form id="hotlineAjax">
                        @csrf
                        <div class="pt-5">
                            <input type="text" id="name" name="name"
                                class=" border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-[#f8b742] focus:border-[#f8b742] focus:shadow-[inset_0_1px_1px_rgba(0, 0, 0, 0.075),0_0_8px_rgba(248, 183, 66, 0.6)] block w-full p-2.5 "
                                placeholder="Họ và tên *"  />
                        </div>

                        <div class="pt-5">
                            <input type="text" id="email" name="email"
                                class=" border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-[#f8b742] focus:border-[#f8b742] focus:shadow-[inset_0_1px_1px_rgba(0, 0, 0, 0.075),0_0_8px_rgba(248, 183, 66, 0.6)] block w-full p-2.5 "
                                placeholder="Email *"  />
                        </div>

                        <div class="pt-5">
                            <input type="text" id="phone" name="phone"
                                class=" border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-[#f8b742] focus:border-[#f8b742] focus:shadow-[inset_0_1px_1px_rgba(0, 0, 0, 0.075),0_0_8px_rgba(248, 183, 66, 0.6)] block w-full p-2.5 "
                                placeholder="Số điện thoại *"  />
                        </div>

                        <div class="pt-5">
                            <textarea type="text" id="message" rows="5" name="message"
                                class=" border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-[#f8b742] focus:border-[#f8b742] focus:shadow-[inset_0_1px_1px_rgba(0, 0, 0, 0.075),0_0_8px_rgba(248, 183, 66, 0.6)] block w-full p-2.5 "
                                placeholder="Lời nhắn"></textarea>

                        </div>

                        <div class="pt-5">
                            <p class="w-full mt-3 flex justify-center lg:justify-start">
                                <button type="submit" class="w-[13rem] flex  items-center relative">
                                    <span
                                        class="w-[3rem] h-[3rem] bg-[#ff5b26] flex justify-center items-center rounded-full ">
                                        <ion-icon name="chevron-forward-outline" class="text-lg text-white"></ion-icon>
                                    </span>
                                    <span
                                        class="bg-[#ff5b262e] absolute inset-0 py-[0.75rem] text-center ml-[1.85rem] rounded-r-[50px] font-semibold uppercase text-[#ff5b26]">
                                        Gửi hỗ trợ
                                    </span>
                                </button>
                            </p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>


@push('js')
    <script>


        $('#hotlineAjax').on('submit', function(event) {
                event.preventDefault(); // Ngăn chặn hành động mặc định

                $.ajax({
                    url: "{{ route('hotlineAjax') }}", // Đường dẫn tới route
                    type: 'POST',
                    data: $(this).serialize(), // Serialize dữ liệu form
                    success: function(response) {
                        if(response.status == 'success'){
                            alert(response.message);
                            $('#hotlineAjax')[0].reset();
                        }else{


                        }
                    },
                    error: function(xhr) {
                        var errors = xhr.responseJSON.errors;

                        console.log(errors);

                         $.each(errors, function(key, value) {
                        // Thêm thẻ span chứa lỗi ngay dưới input
                        $('#' + key).after('<span class="text-red-300 text-sm">' + value[0] + '</span>');
                    });


                    }
                });
            });
    </script>
@endpush
