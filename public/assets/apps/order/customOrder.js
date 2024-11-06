function setModalOrder(id=null){
    // set the modal menu element
    const $targetEl = document.getElementById('ordermodal');

    // options with default values
    const options = {
        placement: 'center',
        backdrop: 'dynamic',
        backdropClasses:
            'bg-gray-900/50 dark:bg-gray-900/80 fixed inset-0 z-40',
        closable: true,
        onHide: () => {
            console.log('modal is hidden');
        },
        onShow: () => {
            showLoading()
            $.ajax({
                url: urlGetOrderItem,
                type: "POST",
                data: {
                    idOrderItem: id,
                },
                success: function (response) {
                    hidenLoading();
                    console.log(response);
                    $('#title-order').html(response.orderCode);

                    const dataArrayOrderItem = response.data;

                    var html = '';
                    dataArrayOrderItem.forEach(element => {
                        html += ' <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">';
                        html += '<th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap " >'+element.sku+'</th>';
                        html += '<td class="px-6 py-4">'+element.name+'</td>';
                        html += '<td class="px-6 py-4">' + element.product_variants +'</td>';
                        html += '</tr>';
                    });

                    $('#renderOrderItem').html(html)
                },
                error: function (error) {
                    hidenLoading();
                }
            });


        },
        onToggle: () => {
            console.log('modal has been toggled');
        },
    };

    // instance options object
    const instanceOptions = {
        id: 'ordermodal',
        override: true
    };

    const modal = new Modal($targetEl, options, instanceOptions);
    return modal;
}

function openModal(){
    $('#dataTables tbody').on('click','.modal-order',function(){
        const id = $(this).closest('tr').attr('id')
        const modal = new setModalOrder(id);

        modal.show();

    })

}

function closeModal(){
    $('.closeModal').click(function(){
        const modal = new setModalOrder();

        modal.hide();
    })
}


function updateStatusModal(){
    var table = $('#dataTables').DataTable();


    // Lắng nghe sự kiện change trên các select có id bắt đầu với "status-order" trong tbody
    $('#dataTables tbody').on('change', 'select[id^="status-order"]', function () {
        var dataId = $(this).data('id'); // Lấy data-id của select
        var dataValue = $(this).val();

        showLoading()
        $.ajax({
            url: urlUpdateStatusOrder,
            type: "POST",
            data: {
                idOrder: dataId,
                value: dataValue
            },
            success: function (response) {
                hidenLoading();


            },
            error: function (error) {
                hidenLoading();
            }
        });
    });
}


function exportDataOrder() {
    $(document).on('click', 'button[id="data-export"]', function () {
        var getIDs = getCheckedIds();

        console.log('Exporting data:', getIDs);

        // Show loading screen
        dataTableIndex.processing(true);

        $.ajax({
            url: urlExportOrder, // Ensure urlExportOrder is defined with the correct endpoint
            data: { id: getIDs }, // Pass the selected IDs to the server
            type: "GET",
            success: function (response) {
                // Tắt màn hình loading
                dataTableIndex.processing(false);
                // Bắt đầu tải về

                window.location.href = response.file;
                // Handle successful export (e.g., download file or show success message)
            },
            error: function (error) {
                console.error('Export failed:', error);
                // Handle error (e.g., show error message)
            },
            complete: function () {
                // Hide loading screen
                dataTableIndex.processing(false);
            }
        });
    });
}


$(document).ready(function () {
    updateStatusModal()
    openModal()

    exportDataOrder()
    closeModal()
});
