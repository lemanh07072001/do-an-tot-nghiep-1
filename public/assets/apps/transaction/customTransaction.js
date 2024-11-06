$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});


function setupModal(ID) {

    const $targetEl = document.getElementById('editModal');

    // options with default values
    const options = {
        placement: 'center',
        backdrop: 'dynamic',
        backdropClasses:
            'bg-gray-900/50 dark:bg-gray-900/80 fixed inset-0 z-40',
        closable: true,
        onHide: () => {
            $('.error').text("")
            $('#spingLoad').hide();
        },
        onShow: (elm) => {

            $.ajax({
                url: getFindData,
                data: { id: ID },
                type: 'POST',
                //   Trả dữ liệu thành công
                success: function (response) {
                    console.log(response);

                    var mainBody = elm._targetEl;

                    $(mainBody).find('input[name="name"]').val($('.title').text()).attr('disabled', true)
                    $(mainBody).find('input[name="quantity"]').val(response.quantity)
                    $(mainBody).find('input[name="price_sale"]').val(parseInt(response.price_sale)).addClass('int')
                    $(mainBody).find('input[name="id"]').val(ID)

                    $('#loadingIndicator').hide();
                },
                error: function () {
                    $('#loadingIndicator').hide();
                },
                complete: function () {
                    $('#loadingIndicator').hide();
                }

            })
        },

    };

    // instance options object
    const instanceOptions = {
        id: 'modalEl',
        override: true
    };

    const modal = new Modal($targetEl, options, instanceOptions);
    return modal;
}

function openModelEdit() {
    $(document).on('click', '.btnEdit', function (e) {
        e.preventDefault(); // Ngăn chặn hành đ��ng mặc đ��nh của liên kết (nếu có)
        $('#loadingIndicator').show();
        let ID = $(this).closest("tr").attr("id");
        var modal = setupModal(ID);
        modal.show();
    })
}

function saveModal() {
    var modal = setupModal();
    $(document).on('click', '#btnSave', function (e) {
        e.preventDefault(); // Ngăn chặn hành đ��ng mặc đ��nh của liên kết (nếu có)


        var quantity = $('input[name="quantity"]').val();
        var price_sale = $('input[name="price_sale"]').val();
        var id = $('input[name="id"]').val();

        if (quantity == '' || price_sale == '') {
            Toastify({
                text: "Không được để trống số lượng hoặc giá tiền",
                duration: 3000,
                newWindow: true,
                close: true,
                gravity: "top", // `top` or `bottom`
                position: "right", // `left`, `center` or `right`
                stopOnFocus: true, // Prevents dismissing of toast on hover
                style: {
                    background: "linear-gradient(to right, #00b09b, #96c93d)",
                },

            }).showToast();
        }else{
            $.ajax({
                url: createTransaction,
                data: {
                    quantity: quantity,
                    price_sale: price_sale,
                    id : id
                 },
                type: 'POST',
                //   Trả dữ liệu thành công
                success: function (response) {

                    modal.hide();

                    window.location.reload()
                },
                error: function () {

                },
                complete: function () {

                }

            })
        }

    })
}

function cloneModal(){
    $(document).on('click', '.cloneModal', function (e) {
        e.preventDefault(); // Ngăn chặn hành đ��ng mặc đ��nh của liên kết (nếu có)

        var modal = setupModal();
        modal.hide();

    })
}


$(document).ready(function () {

    openModelEdit();
    saveModal();
    cloneModal();

})











































// tinymce.init({
//     selector: "#short_description",
//     height: 300, // Thiết lập chiều cao (đơn vị là pixel)
//     plugins: [
//         "advlist autolink lists link image charmap print preview anchor",
//         "searchreplace visualblocks code fullscreen",
//         "insertdatetime media table paste code help wordcount",
//     ],
//     toolbar:
//         "undo redo | formatselect | bold italic backcolor | \
//           alignleft aligncenter alignright alignjustify | \
//           bullist numlist outdent indent | removeformat | help",
// });

// tinymce.init({
//     selector: "#description",
//     height: 300, // Thiết lập chiều cao (đơn vị là pixel)
//     plugins: [
//         "advlist autolink lists link image charmap print preview anchor",
//         "searchreplace visualblocks code fullscreen",
//         "insertdatetime media table paste code help wordcount",
//     ],
//     toolbar:
//         "undo redo | formatselect | bold italic backcolor | \
//           alignleft aligncenter alignright alignjustify | \
//           bullist numlist outdent indent | removeformat | help",
// });
