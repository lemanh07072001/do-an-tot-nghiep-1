$(document).ready(function() {

    handleCheckBox();
    select2();
    formatInt();
    loadFormatPrice();
});

let activeSelector = () => {
    $('.select').each(function(index, value) {
        $(value).attr('id', 'select_' + index).niceSelect();
    })
}

function handleCheckBox() {
    // Xử lý sự kiện khi click vào checkbox "selectAll"
    $("#selectAll").change(function() {
        var isChecked = $(this).prop("checked");

        $(".childCheckbox").prop("checked", isChecked);
        updateCheckedCount();

        updateToggleButtonDelete();
    });

    // Xử lý sự kiện khi click vào checkbox con
    $(document).on("change", ".childCheckbox", function() {

        // Kiểm tra xem tất cả các checkbox con đã được chọn hay chưa
        var allChecked = $(".childCheckbox").length === $(".childCheckbox:checked").length;

        // Nếu tất cả các checkbox con đã được chọn, kiểm tra checkbox "selectAll"
        $("#selectAll").prop("checked", allChecked);

        updateCheckedCount();
        updateToggleButtonDelete();
    });


}

// Cập nhật số lượng checkbox đã được chọn và đưa vào textbox
function updateCheckedCount() {
    var checkedCount = $(".childCheckbox:checked").length;

    $("#countUpdate").html(checkedCount);
}

// Lấy những id đã được checked trong checkbox
function getCheckedIds() {
    var checkedIds = [];
    $(".childCheckbox:checked").each(function(index, element) {

        var id = $(this).val();
        checkedIds.push(id);
    });
    return checkedIds;
}

function checkAllFalse() {
    $("#selectAll").prop("checked", false);
}

// Update thanh xóa

function updateToggleButtonDelete(_this) {
    var anyChecked = $(".childCheckbox:checked").length > 0;
    if (anyChecked) {

        $('#handleAdd').addClass('hidden');
        $('#handleDelete').removeClass('hidden');
    } else {
        $('#handleAdd').removeClass('hidden');
        $('#handleDelete').addClass('hidden');
    }
}

// Select2
function select2(){
    $('.select2').each(function(){
        $(this).select2({
            width : '100%',
            minimumResultsForSearch: Infinity
        });
    })
}

function formatInt() {
    $(document).on('change keyup blur', '.int', function() {
        let _this = $(this);
        let value = _this.val();

        // If the value is empty, set it to '0'
        if (value === '') {
            _this.val('');
            return;
        }

        // Remove existing commas or dots and format the number
        value = value.replace(/[.,]/g, "");

        // Check if the value is a valid number
        if (isNaN(value)) {
            _this.val('');
            return;
        }

        // Add commas for thousands separators
        _this.val(addCommas(value));
    });
}

function addCommas(nStr) {
    nStr = String(nStr);
    return nStr.replace(/\B(?=(\d{3})+(?!\d))/g, ".");
}

function loadFormatPrice(){
    $('.int').each(function(index,item){
        let value = $(item).val();

        // If the value is empty, set it to '0'
        if (value === '') {
            $(item).val('');
            return;
        }

        // Remove existing commas or dots and format the number
        value = value.replace(/[.,]/g, "");

        // Check if the value is a valid number
        if (isNaN(value)) {
            $(item).val('');
            return;
        }

        // Add commas for thousands separators
        $(item).val(addCommas(value));
    })
}

// Button Import Excel
$('#fileSelect').on('click', function() {
    $('#fileElem').click();
});

function ChangeToSlug(title) {

    var title, slug;

    //Lấy text từ thẻ input title

    //Đổi chữ hoa thành chữ thường
    slug = title.toLowerCase();

    //Đổi ký tự có dấu thành không dấu
    slug = slug.replace(/á|à|ả|ạ|ã|ă|ắ|ằ|ẳ|ẵ|ặ|â|ấ|ầ|ẩ|ẫ|ậ/gi, 'a');
    slug = slug.replace(/é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ/gi, 'e');
    slug = slug.replace(/i|í|ì|ỉ|ĩ|ị/gi, 'i');
    slug = slug.replace(/ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ/gi, 'o');
    slug = slug.replace(/ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự/gi, 'u');
    slug = slug.replace(/ý|ỳ|ỷ|ỹ|ỵ/gi, 'y');
    slug = slug.replace(/đ/gi, 'd');
    //Xóa các ký tự đặt biệt
    slug = slug.replace(/\`|\~|\!|\@|\#|\||\$|\%|\^|\&|\*|\(|\)|\+|\=|\,|\.|\/|\?|\>|\<|\'|\"|\:|\;|_/gi, '');
    //Đổi khoảng trắng thành ký tự gạch ngang
    slug = slug.replace(/ /gi, "-");
    //Đổi nhiều ký tự gạch ngang liên tiếp thành 1 ký tự gạch ngang
    //Phòng trường hợp người nhập vào quá nhiều ký tự trắng
    slug = slug.replace(/\-\-\-\-\-/gi, '-');
    slug = slug.replace(/\-\-\-\-/gi, '-');
    slug = slug.replace(/\-\-\-/gi, '-');
    slug = slug.replace(/\-\-/gi, '-');
    //Xóa các ký tự gạch ngang ở đầu và cuối
    slug = '@' + slug + '@';
    slug = slug.replace(/\@\-|\-\@|\@/gi, '');
    //In slug ra textbox có id “slug”
    document.getElementById('slug').value = slug;
}


function handleClickCopy() {
    $(document).on("click", ".btnCopyJs", function(e) {
        // Lấy giá trị của input
        var copyText = $(".inputHiddenCopy").val();

        // Tạo một thẻ input tạm thời
        var tempInput = $("<input>");

        // Gán giá trị của input tạm thời bằng giá trị của input cần sao chép
        tempInput.val(copyText);

        // Đưa input tạm thời vào trong body
        $("body").append(tempInput);

        // Chọn nội dung trong input tạm thời
        tempInput.select();

        // Sao chép nội dung đã chọn vào clipboard
        document.execCommand("copy");

        // Xóa input tạm thời
        tempInput.remove();

        // Thông báo khi đã sao chép xong
        alertOption("Đã sao chép!");
    });
}



// Css Buttoon
let confirmButton = 'text-white bg-gradient-to-br from-purple-600 to-blue-500 hover:bg-gradient-to-bl focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2'
let cancelButton = 'text-gray-900 bg-gradient-to-r from-red-200 via-red-300 to-yellow-200 hover:bg-gradient-to-bl focus:ring-4 focus:outline-none focus:ring-red-100 dark:focus:ring-red-400 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2'
