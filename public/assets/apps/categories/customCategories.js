$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

function setupModal(ID) {

    const $targetEl = document.getElementById('detaiProductCategories');

    // options with default values
    const options = {
        placement: 'center',
        backdrop: 'dynamic',
        backdropClasses:
            'bg-gray-900/50 dark:bg-gray-900/80 fixed inset-0 z-40',
        closable: true,
        onHide: () => {
            $('#loadingIndicator').hide();

        },
        onShow: (elm) => {
            $('#loadingIndicator').show();
            $.ajax({
                url: detaiProductCategories,
                data: { id: ID },
                type: 'GET',
                //   Trả dữ liệu thành công
                success: function (response) {
                    $('#loadingIndicator').hide();
                    console.log(response);
                    let html ='';
                    if(response.length > 0){
                        response.forEach(value => {

                            html += '<li class="py-3 sm:py-4">';
                            html += '    <div class="flex items-center">';
                            html += '        <div class="flex-shrink-0">';
                            html += '            <img class="w-12 h-12 rounded-full" src="'+hostUrl+value.avatar+'" alt="Neil image">';
                            html += '        </div>';
                            html += '        <div class="flex-1 min-w-0 ms-4">';

                             html +='            <p class="text-sm font-medium text-gray-900 truncate dark:text-white">';
                             html +='                '+value.name+'';
                             html +='            </p>';

                            html += '        </div>';
                            html += '        <a href="' + hostUrl + 'admin/products/edit/' + value.id +'" class="loadingHref text-white bg-gradient-to-r from-purple-500 via-purple-600 to-purple-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-purple-300 dark:focus:ring-purple-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2">';
                            html += '            Chi tiết';
                            html += '        </a>';
                            html += '    </div>';
                            html += '</li>';

    // /admin/products/edit/1

                        });
                    }else{
                        html += '<p class="text-center text-gray-900 dark:text-white">Chưa có dữ liệu</p>';
                    }

                    $('#listProduct').html(html);


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

function handleOpenModelDetai(){

    $(document).on('click','.detaiProductCategories',function(){
        let ID = $(this).closest("tr").attr("id");

        let modal = setupModal(ID);
        modal.show();
    })
}




$(document).ready(function () {
handleOpenModelDetai();

})




