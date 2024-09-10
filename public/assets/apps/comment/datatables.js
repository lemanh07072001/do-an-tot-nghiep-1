$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

var IDDatatables = "dataTables";

function initializeDataTable(
    url,
    arrayColumns,
    custom = {
        PAGING: true,
    },
    dataTable = IDDatatables
) {
    /* Get input search */
    let searchInput = $('input[data-search="search-input"]');
    /* Get select status */
    let searchStatus = $('select[data-search="search-status"]');
  /* Get select user */
  let searchUser = $('select[data-search="search-user"]');

    /* Get data  */

    var datatables = $("#" + dataTable + "").DataTable({
        ajax: {
            url: url,
            data: function(data) {
                data.searchInput = searchInput.val();
                data.searchStatus = searchStatus.val();
                data.searchUser = searchUser.val();
            },
        },
        processing: true,
        serverSide: true,
        select: {
            style: 'multi',
            selector: 'td:first-child input[type="checkbox"]',
            className: 'row-selected'
        },
        pagingType: 'simple_numbers',
        language: {
            info: 'Đang hiển thị trang _PAGE_ trong số _PAGES_',
            infoEmpty: 'Không có dữ liệu nào',
            infoFiltered: '(được lọc từ tổng số bản ghi _MAX_)',
            lengthMenu: 'Hiển thị bản ghi _MENU_ trên mỗi trang ',
            zeroRecords: 'Không tìm thấy gì - xin lỗi',
            emptyTable: '<div class="flex align-item justify-center">' +
                '<img src="/images/noData.png" >' +
                '</div>'
        },
        "bFilter": false,
        "bInfo": false,
        "paging": custom.PAGING,
        ordering: false,
        //   scrollCollapse: true,
        //   scrollY: 700,
        lengthChange: true,
        rowId: "id",
        columnDefs: [{
            orderable: false,
            targets: custom.TARGETS
        }],
        layout: {
            bottomStart: 'pageLength',
            topStart: null,
        },

        columns: arrayColumns,
        columnDefs: [{
            targets: 0,
            orderable: false,
            render: function(data) {

                return `
                          <div class="flex items-center">
                          ${data}
                          </div>`;
            }
        }, ],

    });

    /* Search Input */
    if (searchInput !== undefined) {
          // Hiển thị màn hình loading


        searchInput.on("keyup", function() {
            showLoading();
            datatables.ajax.reload(function(){

                hidenLoading();
            });
        });
    }

    /* Search status */
    if (searchStatus !== undefined) {
        searchStatus.on("change", function() {
            showLoading();
            datatables.ajax.reload(function(){

                hidenLoading();
            });
        });
    }

     /* Search user */
     if (searchUser !== undefined) {
        searchUser.on("change", function() {
            showLoading();
            datatables.ajax.reload(function(){
                hidenLoading();
            });
        });
    }


    return datatables;
}
//NOTE - Hàm xử lý update trạng thái Status
let toggleStatus = (url, dataTableIndex, type = "toast ") => {
    // Xử lý đoạn code tương tự như trên
    $(document).on('click', 'input[type="checkbox"][data-toggle="status"]', function() {
        // Lấy data-id trên dòng đã chọn
        let ID = $(this).closest("tr").attr("id");
        // Lấy value trên dòng đã chọn
        let value = $(this).val();
        //   Gọi ajax

        // Hiển thị màn hình loading
        showLoading();

        $.ajax({
            url: url,
            data: { id: ID, value: value },
            type: 'POST',
            //   Trả dữ liệu thành công
            success: function(response) {
                // Tắt màn hình loading
                hidenLoading();

                //   Hiện thông báo thành công
                Swal.fire(
                    swalConfig1ButtonConfirm(response.message, 'success')
                )

                dataTableIndex.draw();
            },
            //   Trả dữ liệu thất bại
            error: function(error) {

                // Tắt màn hình loading
                hidenLoading();


                //   Hiện thông báo thất bại
                Swal.fire(
                    swalConfig1ButtonConfirm(response.message, 'success')
                )


                dataTableIndex.draw();
            },
            complete: function() {

            }
        })
    });
}

//NOTE - Xóa tất cả dữ liệu được chọn
let deleteAll = function(url, dataTableIndex, ) {
    $(document).on('click', '#data-delete', function() {
        let selectedRows = dataTableIndex.rows({ selected: true }).data();
        if (selectedRows.length === 0) {
            Swal.fire(
                swalConfig1ButtonConfirm("Không có dữ liệu nào được chọn để xóa.", 'warning')
            );
            return;
        }

        // Lấy tát cả ID được chọn
        var getIDs = getCheckedIds();

        // Tắt màn hình loading
        showLoading();
        Swal.fire(
            swalConfig2ButtonConfirm("Bạn có chắc chắn muốn xóa tài khoản này?")
        ).then(function(result) {

            if (result.isConfirmed) {
                //NOTE - Gửi Ajax
                $.ajax({
                    url: url,
                    data: {
                        id: getIDs,
                    },
                    type: "DELETE",
                    success: function(response) {

                        // Tắt màn hình loading
                        hidenLoading();
                        Swal.fire(
                            swalConfig1ButtonConfirm(response.message, 'success')
                        )
                        checkAllFalse();
                        $('#handleAdd').removeClass('hidden');
                        $('#handleDelete').addClass('hidden');
                        dataTableIndex.ajax.reload(function() {}, false);
                    },
                    error: function(error) {

                        // Tắt màn hình loading
                        hidenLoading();

                        Swal.fire(
                            swalConfig1ButtonConfirm(error.responseJSON.message, 'error')
                        )

                        checkAllFalse();

                    }
                })


            } else if (result.dismiss === 'cancel') {
                Swal.fire(
                    swalConfig1ButtonConfirm("Tài khoản chưa bị xóa!.", 'error')
                );
            }
        });
    })
}

//NOTE - Xóa tất cả dữ liệu được chọn
let deleteRow = function(url, dataTableIndex, ) {
    $(document).on('click', '.deleteRow', function() {
        let ID = $(this).closest("tr").attr("id");

        // Tắt màn hình loading
        showLoading();
        Swal.fire(
            swalConfig2ButtonConfirm("Bạn có chắc chắn muốn xóa tài khoản này?")
        ).then(function(result) {

            if (result.isConfirmed) {

                //NOTE - Gửi Ajax
                $.ajax({
                    url: url,
                    data: {
                        id: ID,
                    },
                    type: "DELETE",
                    success: function(response) {

                        // Tắt màn hình loading
                        hidenLoading();
                        Swal.fire(
                            swalConfig1ButtonConfirm(response.message, 'success')
                        )

                        dataTableIndex.row(`#${ID}`).remove().draw();

                    },
                    error: function(error) {

                        // Tắt màn hình loading
                        hidenLoading();
                        console.log(error.responseJSON.message);
                        Swal.fire(
                            swalConfig1ButtonConfirm(error.responseJSON.message, 'error')
                        )
                    }
                })


            }
        });
    })
}

