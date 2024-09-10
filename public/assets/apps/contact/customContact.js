$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

function setUpModal(ID) {

    // set the modal menu element
    const $targetEl = document.getElementById('modalMessage');

    // options with default values
    const options = {
        placement: 'center',
        backdrop: 'dynamic',
        backdropClasses:
            'bg-gray-900/50 dark:bg-gray-900/80 fixed inset-0 z-40',
        closable: true,
        onHide: () => {
            $('#loadingIndicatorSend').hide();
        },
        onShow: () => {

            $('#loadingIndicator').show();
            $.ajax({
                url: routeGetMessage,
                data: {
                    id: ID,
                },
                type: "GET",
                success: function (response) {


                    // Tắt màn hình loading
                    $('#loadingIndicator').hide();

                    $('#title').text(response.email);
                    $('#name').text(response.name);
                    $('#email').text(response.email);
                    $('#phone').text(response.phone);
                    $('#message').text(response.message);

                    if (response.repMessage == '' || response.repMessage == null) {
                        $('#alertMessae').hide();
                    }else{
                        $('#alertMessae').show();
                        $('#repMessage').text(response.repMessage);
                    }
                    $('#id_modal').val(ID)
                },
                error: function (error) {

                    // Tắt màn hình loading
                    $('#loadingIndicator').hide();

                    Swal.fire(
                        swalConfig1ButtonConfirm(error.responseJSON.message, 'error')
                    )
                }
            })
        },

    };

    // instance options object
    const instanceOptions = {
        id: 'modalMessage',
        override: true
    };

    const modal = new Modal($targetEl, options, instanceOptions);

    return modal;
}

function setUpSendModal(ID) {

    // set the modal menu element
    const $targetEl = document.getElementById('modalSendMessage');

    // options with default values
    const options = {
        placement: 'center',
        backdrop: 'dynamic',
        backdropClasses:
            'bg-gray-900/50 dark:bg-gray-900/80 fixed inset-0 z-40',
        closable: true,
        onHide: () => {
            console.log('modal is hidden 1');
        },
    };

    // instance options object
    const instanceOptions = {
        id: 'modalSendMessage',
        override: true
    };

    const modal = new Modal($targetEl, options, instanceOptions);

    return modal;
}

function sendMessageModal() {


    $('#sendMessageOpen').on('click', function () {
        $(this).text('Xác nhận');


        var modalSendMessage = setUpSendModal();


        var modal = setUpModal();

        modal.hide();
        modalSendMessage.show();
    })
}

function sendMessageNoti() {
    $('#sendMessage').on('click', function () {
        var modalSendMessage = setUpSendModal();


        let value = $('#messageSend').val();
        let ID = $("#modalMessage").find('#id_modal').val();

        $('#loadingIndicatorSend').show();
        $.ajax({
            url: routeSendMessage,
            data: {
                value: value,
                id: ID
            },
            type: "POST",
            success: function (response) {

                // Tắt màn hình loading
                $('#loadingIndicatorSend').hide();
                modalSendMessage.hide();
                Swal.fire(
                    swalConfig1ButtonConfirm(response.message, 'success')
                )



            },
            error: function (error) {

                // Tắt màn hình loading
                $('#loadingIndicatorSend').hide();

                Swal.fire(
                    swalConfig1ButtonConfirm(error.responseJSON.message, 'error')
                )
            }
        })

    });
}

function openModalMessage() {
    $(document).on('click', '.openModalMessage', function () {
        let ID = $(this).closest("tr").attr("id");

        var modal = setUpModal(ID);

        modal.show();
    })
}

$(document).ready(function () {
    openModalMessage();
    sendMessageModal();
    sendMessageNoti();
})
