

function activeAttribute(){
    let activeAttributes = []; // Mảng chứa các data-id của các phần tử active

    $('.attribute').each(function (key, value) {
        // Tự động active thuộc tính đầu tiên khi trang được load
        $(value).find('.attribute-style:first').addClass('opacity-20 border-red-500 active');

        // Kiểm tra xem có phần tử nào đã có class 'active' chưa
        var activeItem = $(value).find('.attribute-style.active');
        if (activeItem.length > 0) {
            activeAttributes[key] = $(activeItem).attr('data-id'); // Thêm data-id vào mảng
        } else {
            console.log('Chưa có thuộc tính nào được active');
        }


        $(value).find('.attribute-style').each(function (index, item) {

            $(item).on('click', function () {

                // Xóa class 'active' khỏi tất cả các '.attribute-style'
                $(value).find('.attribute-style').removeClass('opacity-20 border-red-500 active');

                // Thêm class 'active' cho phần tử được click
                $(this).addClass('opacity-20 border-red-500 active');

                // Cập nhật mảng chỉ chứa id của phần tử vừa được click
                activeAttributes[key] = $(this).attr('data-id');


                getProductAjax(activeAttributes)

            })
        })
    });
    getProductAjax(activeAttributes)
}

function getProductAjax(data){
    var idProduct = $('#main-product-id').attr('data-id');
    // Convert mảng thành chuỗi
    var attributeString = data.join(', ');
    $.ajax({
        url: getAttributeAjax,
        type: "GET",
        data: {
            data: attributeString,
            idProduct : idProduct
        },
        success: function (response){
            var nameProduct = response.nameProduct;
            var dataProduct = response.dataVariant;
            console.log(dataProduct);

            $('#title-product').html(nameProduct);
            // $('#quantity-title').html(dataProduct.quantity);
            // $('#sku-title').html(dataProduct.sku)

        }
    })

}


$(document).ready(function(){

    activeAttribute()

})
