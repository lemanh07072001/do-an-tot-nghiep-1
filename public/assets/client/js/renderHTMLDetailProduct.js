

function activeAttribute() {
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

function getProductAjax(data) {
    var idProduct = $('#main-product-id').attr('data-id');
    var avatarProduct = $('#main-product-id').attr('data-avatar');
    // Convert mảng thành chuỗi
    var attributeString = data.join(', ');



    addLoading();
    $.ajax({
        url: getAttributeAjax,
        type: "GET",
        data: {
            data: attributeString,
            idProduct: idProduct,
            avatar:avatarProduct
        },
        success: function (response) {
            console.log(response);

            hideLoading();

            var nameProduct = response.nameProduct;
            var dataProduct = response.dataVariant;

            $('#title-product').html(nameProduct);
            $('#quantity-title').html(dataProduct.product_variants);
            $('#sku-title').html(dataProduct.sku).attr('data-price-sale', dataProduct.price_sale)

            console.log(dataProduct.price_sale);

            if (dataProduct.price_sale == 0 || dataProduct.price_sale === "") {

                $('.price').html(formatPriceVND(dataProduct.price)).attr('data-price', dataProduct.price)
                $('.price-sale').html(formatPriceVND(0)).attr('data-price-sale', 0)
                $('.price-sale').addClass('hidden')
            } else {
                $('.price').html(formatPriceVND(dataProduct.price_sale)).attr('data-price', dataProduct.price)
                $('.price-sale').html(formatPriceVND(dataProduct.price)).attr('data-price-sale', dataProduct.price_sale)
            }

            var phanTram = tinhPhanTramGiam(dataProduct.price, dataProduct.price_sale);
            $('#sale').html('-' + phanTram + '%')

            if (dataProduct.product_variants == 0) {
                $('#quantity').addClass('hidden')
                $('#alert-quantity').removeClass('hidden')
            } else {
                $('#quantity').removeClass('hidden')
                $('#alert-quantity').addClass('hidden')
            }

        },
        error: function (error) {
            hideLoading();
        }
    })

}


// function getOrder() {
//     $(document).on('click', '#btnSaveOrder', function () {
//         var price = $('.price').attr('data-price');
//         var priceSale = $('.price-sale').attr('data-price-sale');
//         var nameProduct = $('.product-name').data('name');
//         var idProduct = $('.id-product').data('id-product')

//         var attributesObject = {}; // Đối tượng để chứa các thuộc tính đã được kích hoạt

//         var countQuantity = $('.count-quantity').val();

//         var attributeId = $('.attribute'); // Chọn tất cả các phần tử có class 'attribute'
//         $(attributeId).each(function (index, value) {
//             var idAttr = $(value).find('.attribute-id').data('id'); // Lấy id của thuộc tính
//             var activeStyles = []; // Mảng để lưu các ID style đã được kích hoạt cho thuộc tính này

//             // Tìm tất cả các style trong thuộc tính này
//             var styleId = $(value).find('.attribute-style');

//             // Duyệt qua các style và kiểm tra class 'active'
//             $(styleId).each(function (key, item) {
//                 if ($(item).hasClass('active')) {
//                     var id = $(item).data('id'); // Lấy data-id của style đang active
//                     activeStyles.push(id); // Thêm vào mảng activeStyles
//                 }
//             });

//             // Chỉ thêm vào attributesObject nếu có style đã được kích hoạt
//             if (activeStyles.length > 0) {
//                 attributesObject[idAttr] = activeStyles; // Gán mảng activeStyles cho thuộc tính cha
//             }
//         });

//         // Chuyển đổi đối tượng attributesObject sang định dạng JSON
//         var jsonAttributesObject = JSON.stringify(attributesObject);

//         // In ra đối tượng chứa các thuộc tính và style đã được kích hoạt dưới dạng JSON

//         var data = {
//             'id' : idProduct,
//             'price' : price,
//             'name' : nameProduct,
//             'priceSale' : priceSale,
//             'quantity' : countQuantity,
//             'attribute' : jsonAttributesObject
//         }

//         $.ajax({
//             url: getAttribute,
//             type: "POST",
//             data: {
//                 data:data
//             },
//             success: function (response){

//             }
//         })

//     });
// }


function getOrder() {
    $(document).on('click', '#btnSaveOrder', function () {
        var price = $('.price').attr('data-price');
        var priceSale = $('.price-sale').attr('data-price-sale');
        var nameProduct = $('.product-name').data('name');
        var idProduct = $('.id-product').data('id-product');
        var avatar = $('#main-product-id').data('avatar');


        var attributesObjectName = {}; // Đối tượng để chứa các name thuộc tính đã được kích hoạt
        var attributesObjectID = {};  // Đối tượng để chứa các id thuộc tính đã được kích hoạt
        var countQuantity = $('.count-quantity').val();

        var attributeId = $('.attribute'); // Chọn tất cả các phần tử có class 'attribute'
        $(attributeId).each(function (index, value) {

            var attributeName = $(value).find('.attribute-id').data('name'); // Lấy tên thuộc tính (ví dụ: Màu sắc, Kích thước) var activeStyles = {}; // Đối tượng để lưu các ID style đã được kích hoạt cho thuộc tính này

            // Tìm tất cả các style trong thuộc tính này
            var styleId = $(value).find('.attribute-style');

            // Duyệt qua các style và kiểm tra class 'active'
            $(styleId).each(function (key, item) {


                if ($(item).hasClass('active')) {
                    var styleName = $(item).data('name'); // Lấy tên của style đang active
                    var styleID = $(item).data('id'); // Lấy tên của style đang active
                    attributesObjectName[attributeName] = styleName; // Thêm vào attributesObject với tên thuộc tính là key và giá trị là style đang active
                    attributesObjectID[attributeName] = styleID; // Thêm vào attributesObject với tên thuộc tính là key và giá trị là style đang active
                }
            });
        });

        // Kết quả của attributesObject sẽ là dạng:
        // { "Màu sắc": "Đỏ", "Kích thước": "X" }

        // Kết quả của logic
        var data = {
            'id': idProduct,
            'price': price,
            'avatar': avatar,
            'name': nameProduct,
            'priceSale': priceSale,
            'quantity': countQuantity,
            'attribute': attributesObjectName, // Gán attributesObject vào data
            'attributeID': attributesObjectID // Gán attributesObject vào data
        };
        $.ajax({
            url: addCart,
            type: "POST",
            data: {
                data: data
            },
            success: function (response) {


                alert('Thêm sản phẩm vào giỏ hàng thành công!');
            }
        });
    });
}



$(document).ready(function () {

    activeAttribute()
    getOrder();
})
