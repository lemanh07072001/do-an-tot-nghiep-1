$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

let selectedIds = [];

if (typeof getGroupProduct !== 'undefined' && getGroupProduct.length > 0) {
    selectedIds = getGroupProduct;
    renderHtmlTableItem(selectedIds)
} else {
    selectedIds = [];
}

console.log(hostUrl);
function renderHtmlListItem(response, dataIds) {

    let html = '';

    response.forEach(element => {
         let isChecked = dataIds.some(item => item.id === element.id) ? 'checked' : ''

        html += '<li class="py-3 item-list" >';
        html += '<div class="flex items-center ">';
        html += '<div class="flex items-center mr-2">';
        html += '<input data-id="' + element.id + '" id="default-checkbox" type="checkbox" value="" class="checkBoxItem w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600" ' + isChecked + '>';
        html += '</div>';
        html += '<div class="flex-shrink-0 border-slate-700">';
        html += '<img class="w-8 h-8 rounded-full dataAvatar" data-avatar="' + element.avatar + '" src="' + hostUrl + element.avatar + '" alt="Thomas image">';
        html += '</div>';
        html += '<div class="flex-1 min-w-0 ms-4">';
        html += '<p class="dataName text-sm font-medium" data-name="' + element.name + '"  text-gray-900 truncate dark:text-white"> ' + element.name + ' </p>';
        html += '</div>';

        html += '</div>';
        html += '</li>';


    });


    html += '<input type="hidden" name="idDatas" value="' + dataIds.join(',') + '"/>';
    // Clear the existing list and append the new HTML
    $('#listModalProduct').empty().append(html);

}

function renderHtmlTableItem(response) {

    let html = '';

    console.log(hostUrl);

    response.forEach((element, index) => {



        html += '<li class="py-3 item-list" data-id="' + element.id + '">';
        html += '<div class="flex items-center ">';
        html += '<div class="flex items-center mr-2">';
        html += index + 1;
        html += '</div>';
        html += '<div class="flex-shrink-0 border-slate-700">';
        html += '<img class="w-8 h-8 rounded-full dataAvatar" data-avatar="' + element.avatar + '" src="' + hostUrl + element.avatar + '" alt="Thomas image">';
        html += '</div>';
        html += '<div class="flex-1 min-w-0 ms-4">';
        html += '<p class="dataName text-sm font-medium" data-name="' + element.name + '"  text-gray-900 truncate dark:text-white"> ' + element.name + ' </p>';

        html += '</div>';

        html += '<button type="button" class="deleteList ms-auto -mx-1.5 -my-1.5 bg-white text-gray-400 hover:text-gray-900 rounded-lg focus:ring-2 focus:ring-gray-300 p-1.5 hover:bg-gray-100 inline-flex items-center justify-center h-8 w-8 dark:text-gray-500 dark:hover:text-white dark:bg-gray-800 dark:hover:bg-gray-700" data-dismiss-target="#toast-success" aria-label="Close">';
        html += '<span class="sr-only">Close</span>';
        html += '<svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">';
        html += '<path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>';
        html += '</svg>';
        html += '</button>';

        html += '</div>';
        html += '<input type="hidden" name="idArray[]" value="' + element.id + '"/>';
        html += '</li>';
    });



    // Clear the existing list and append the new HTML
    $('#listTable').empty().append(html);

}

function setupModal(dataIds) {
    const $targetEl = document.getElementById('modalEl');

    // options with default values
    const options = {
        placement: 'center',
        backdrop: 'dynamic',
        backdropClasses:
            'bg-gray-900/50 dark:bg-gray-900/80 fixed inset-0 z-40',
        closable: true,
        onHide: () => {

        },
        onShow: () => {
            $('#loadingIndicator').show();
            setTimeout(() => {
                $.ajax({
                    url: routeGetAllProduct,
                    type: 'POST',
                    //   Trả dữ liệu thành công
                    success: function (response) {
                        let html = renderHtmlListItem(response, dataIds);

                        $('#loadingIndicator').hide();

                    },
                    //   Trả dữ liệu thất bại
                    error: function (error) {
                        $('#loadingIndicator').hide();

                    },
                    complete: function () {
                        $('#loadingIndicator').hide();
                    }
                })
            }, 150)

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


function selectAllCheckBox() {
    $('#selectAllCheckBox').on('click', function () {

        $('.checkBoxItem').each(function () {
            let isChecked = $(this).prop('checked');

             // Lấy thông tin từ thẻ cha
             let parentInfo = $(this).closest('.item-list');
             let dataId = parentInfo.find('.checkBoxItem').data('id');
             let dataAvatar = parentInfo.find('.dataAvatar').data('avatar');
             let dataName = parentInfo.find('.dataName').data('name');

            let dataObj = {
                'id': dataId,
                'avatar': dataAvatar,
                'name': dataName
            };

            if (isChecked) {
                if (!selectedIds.some(obj => obj.id === dataObj.id)) {
                    selectedIds.push(dataObj);
                }
            }else{
                selectedIds = selectedIds.filter(obj => obj.id !== dataObj.id);
            }

        });

        let modal = setupModal();
        modal.hide();

        renderHtmlTableItem(selectedIds)


    })
}

function openModelEdit() {
    $('#simple-search').on('click', function () {

        let modal = setupModal(selectedIds);
        modal.show();

    })


}

function searchModal() {
    $('#search-modal').on('keyup', function () {

        var value = $(this).val();



        $('#loadingIndicator').show();
        setTimeout(() => {
            $.ajax({
                url: routeSearchProduct,
                type: 'GET',
                data: { search: value },

                //   Trả dữ liệu thành công
                success: function (response) {
                    let html = renderHtmlListItem(response, selectedIds);
                    $('#listModalProduct').html(html);
                    $('#loadingIndicator').hide();

                },
                //   Trả dữ liệu thất bại
                error: function (error) {
                    $('#loadingIndicator').hide();

                },
                complete: function () {
                    $('#loadingIndicator').hide();
                }
            })
        }, 150)
    })
}


function deleteList(){
    $(document).on('click', '.deleteList',function(){
        var id = $(this).closest('.item-list').data('id');

        selectedIds = selectedIds.filter(obj => obj.id !== id);

        $(this).closest('.item-list').remove();
    })
}

$(document).ready(function () {
    openModelEdit();
    selectAllCheckBox();
    searchModal();
    deleteList();
})
