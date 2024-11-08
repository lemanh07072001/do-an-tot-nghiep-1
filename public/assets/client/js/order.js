$(document).ready(function () {
    $('#order-now').click(function () {

        var name = $('#name').val();
        var email = $('#email').val();
        var phone = $('#phone').val();
        var selectProvince = $('#selectProvince option:selected').data('name');
        var selectDistrict = $('#selectDistrict option:selected').data('name');
        var selectCommune = $('#selectCommune option:selected').data('name');
        var address = $('#address').val();
        var note = $('#note').val();

        var payment_method = $('input[name="default-radio"]:checked').val();
        var voucher_code = $('#input-code').val();

        var data = {
            name,
            email,
            phone,
            selectDistrict,
            selectCommune,
            selectProvince,
            address,
            note,
            payment_method,
            voucher_code
        }


        $('.error-message').html('');

        $.ajax({
            url: '/order',
            type: "POST",
            data:{
                data
            },
            success: function (response) {
                console.log(response.type = "cash_on_delivery");
                if (response.type = "cash_on_delivery"){
                    alertbox.render({
                        alertIcon: 'success',
                        title: 'Thank You!',
                        message: response.message,
                        btnTitle: 'Xác nhận',
                        border: true
                    });

                    setTimeout(function () {
                        location.reload();
                    }, 1000)
                } else if (response.type = 'payment_transfer'){
                    window.open(response.data.data, '_blank');

                }


            },
            error: function (xhr) {
                // Xử lý lỗi xác thực

                if (xhr.status === 422) {
                    const errors = xhr.responseJSON.errors;


                    // Hiển thị thông báo lỗi cho từng trường
                    $.each(errors, function (key, messages) {
                        console.log(key);
                        $('#' + key + '-error').html(messages[0]); // Hiển thị thông báo lỗi cho trường tương ứng
                    });
                }
            }
        })


    })



})

