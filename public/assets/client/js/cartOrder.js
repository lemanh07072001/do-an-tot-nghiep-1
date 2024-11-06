function updateCart(){
    $('#btnUpdateCart').click(function(){
        var rowCart = $('#tableCartProduct').find('.rowCart');

        var dataCartArray = [];

        $(rowCart).each(function(key,item){
            var id = $(item).data('id');

            var quantity = $(item).find('.input-quantity').val()

            dataCartArray.push({ 'id': id, 'quantity': quantity });
        })

        $.ajax({
            url: updateCartUrl,
            type: "POST",

            data: {
                data:dataCartArray,
            },
            success: function (response){
                console.log(response);

                location.reload();

            }
        })

    })
}

function deleteCart(){
    $('.delete-cart').each(function(key,value){
        $(value).on('click',function(){
            var id = $(this).data('id');

            $.ajax({
                url: deleteCartUrl,
                type: "POST",

                data: {
                    id: id
                },
                success: function (response) {
                    location.reload();

                }
            })

        })

    })
}

function checkVoucherAjax(name = '') {
    $.ajax({
        url: '/check-voucher',
        type: "GET",
        data: { name: name },
        success: function (response) {
            console.log("Response:", response);

            if(response.status == false){
                $('#input-code').val('')
                $('#errorVoucerUnique').html('<p class="text-red-600 text-[12px] mt-3">'+response.message+'</p>')
            }else{

                if (response.voucher.discount_type == 'vnd'){
                    $('#voucherSale').html(formatPriceVND(response.voucher.value_reduction))
                }else{
                    $('#voucherSale').html(response.voucher.value_reduction+'%')
                }
                console.log(formatPriceVND(response.total));

                $('.totalNumber').html(formatPriceVND(response.total) )
                $('.totalNumber').attr('data-total', response.total)
                $('#errorVoucerUnique').html('')
            }
        },
        error: function (xhr, status, error) {
            console.log("Error:", xhr.responseText);
        }
    });
}


function changeInputVoucher(){
    $('#input-code').change(function(){

        var value = $(this).val().trim();
        if(value !== ''){
            checkVoucherAjax(value)
        }
    })
}

function handleClickVoucher() {

    $('.list-voucher').each(function () {
        $(this).click(function () {
            var voucher = $(this).find('.code-voucher').data('code'); // Lấy mã voucher
            var name = $(this).data('name'); // Lấy tên voucher

            // Đặt giá trị voucher vào input
            $('#input_voucher').val(voucher);
            $('#input_voucher').attr('data-name', name);
            $('#input-code').val(voucher);
            // Gọi hàm kiểm tra voucher
            checkVoucherAjax(name);

            $(this).attr('data-modal-toggle', 'voucher-modal')
        });
    });
}



$(document).ready(function(){
    updateCart();
    deleteCart();
    changeInputVoucher();
    handleClickVoucher();

    $.ajax({
        url: 'http://127.0.0.1:8000/api/provinces/',
        type: 'GET',
        success: function (response) {
            var data = response.data;

            data.forEach(function (province) {
                $('#selectProvince').append(
                    `<option data-name="${province.name}" value="${province.id}">${province.name}</option>`
                );
            });
        }
    });

    $('#selectProvince').change(function () {
        var provinceId = $(this).val();

        // Reset quận/huyện và phường/xã khi tỉnh thành thay đổi
        $('#selectDistrict').empty().append('<option value="">Chọn Quận/Huyện</option>').prop('disabled', true);
        $('#selectCommune').empty().append('<option value="">Chọn Phường/Xã</option>').prop('disabled', true);

        // Kiểm tra nếu có chọn tỉnh/thành phố
        if (provinceId) {
            // Gọi API lấy danh sách quận/huyện
            $.ajax({
                url: `http://127.0.0.1:8000/api/districts/${provinceId}`, // Thay bằng URL thực tế của bạn
                type: 'GET',
                success: function (response) {
                    var dataDistrict = response.data;

                    // Thêm các quận/huyện vào select
                    dataDistrict.forEach(function (district) {
                        $('#selectDistrict').append(
                            `<option data-name="${district.name}"  value="${district.id}">${district.name}</option>`
                        );
                    });

                    // Kích hoạt select quận/huyện
                    $('#selectDistrict').prop('disabled', false);
                }
            });
        }
    });

    $('#selectDistrict').change(function () {
        var districtId = $(this).val(); // Lấy giá trị ID quận/huyện
        $('#selectCommune').empty().append('<option value="">Chọn Phường/Xã</option>').prop('disabled', true);

        // Kiểm tra nếu có chọn quận/huyện
        if (districtId) {
            // Gọi API lấy danh sách phường/xã
            $.ajax({
                url: `http://127.0.0.1:8000/api/communes/${districtId}`, // Thay bằng URL thực tế của bạn
                type: 'GET',
                success: function (response) {
                    var dataCommune = response.data;

                    // Thêm các phường/xã vào select
                    dataCommune.forEach(function (commune) {
                        $('#selectCommune').append(
                            `<option data-name="${commune.name}" value="${commune.id}">${commune.name}</option>`
                        );
                    });

                    // Kích hoạt select phường/xã
                    $('#selectCommune').prop('disabled', false);
                }
            });
        } else {
            // Nếu không chọn quận/huyện, vô hiệu hóa select phường/xã
            $('#selectCommune').empty().append('<option value="">Chọn Phường/Xã</option>').prop('disabled', true);
        }
    });
})
