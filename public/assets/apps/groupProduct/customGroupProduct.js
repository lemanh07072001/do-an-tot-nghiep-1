$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

function renderHtmlListItem(response) {
    let html = '';

    response.forEach(element => {
        html += '<li class="py-3 item-list" >';
        html += '<div class="flex items-center ">';
        html += '<div class="flex items-center mr-2">';
        html += '<input data-id="'+element.id+'" id="default-checkbox" type="checkbox" value="" class="checkBoxItem w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">';
        html += '</div>';
        html += '<div class="flex-shrink-0 border-slate-700">';
        html += '<img class="w-8 h-8 rounded-full dataAvatar" data-avatar="'+element.avatar+'" src="' + hostUrl + element.avatar + '" alt="Thomas image">';
        html += '</div>';
        html += '<div class="flex-1 min-w-0 ms-4">';
        html += '<p class="dataName text-sm font-medium" data-name="'+element.name+'"  text-gray-900 truncate dark:text-white"> ' + element.name + ' </p>';

        html += '</div>';

        html += '</div>';
        html += '</li>';
    });

    return html;
}

function setupModal() {
    const $targetEl = document.getElementById('modalEl');

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
            setTimeout(() => {
                $.ajax({
                    url: routeGetAllProduct,
                    type: 'POST',
                    //   Trả dữ liệu thành công
                    success: function (response) {
                        let html = renderHtmlListItem(response);

                        $('#listModalProduct').html(html);

                    },
                    //   Trả dữ liệu thất bại
                    error: function (error) {


                    },
                    complete: function () {

                    }
                })
            }, 150)

        },
        onToggle: () => {
            console.log('modal has been toggled');
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

function selectAllCheckBox(){
    $('#selectAllCheckBox').on('click',function(){
         // Chọn tất cả các checkbox
        //  let checkAll = $('.checkBoxItem').prop('checked', true);

         let selectedIds = [];
         $('.checkBoxItem:checked').each(function() {

            // Lấy thông tin từ thẻ cha
            let parentInfo = $(this).closest('.item-list');
            let dataId = parentInfo.find('.checkBoxItem').data('id');
            let dataAvatar = parentInfo.find('.dataAvatar').data('avatar');
            let dataName = parentInfo.find('.dataName').data('name');

            let dataObj = {
                'id' : dataId,
                'avatar' : dataAvatar,
                'name' : dataName
            };

            selectedIds.push(dataObj);
        });

        console.log(selectedIds);

    })
}

function openModelEdit() {
    $('#simple-search').on('click', function () {
        console.log('da');
        let modal = setupModal();
        modal.show();
    })
}



$(document).ready(function () {
    openModelEdit();
    selectAllCheckBox();
})
