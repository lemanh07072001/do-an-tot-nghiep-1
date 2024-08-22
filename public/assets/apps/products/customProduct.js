$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

$(document).ready(function () {
    $(document).on("change", ".selectProperties", function () {
        let _this = $(this);


        let attributeID = _this.val();
        if (attributeID != 0) {
            _this.parent('.col-span-2').siblings('.col-span-5').html(select2Variables(attributeID))
            initializeSelectMultiple();
        } else {
            let inputHtml = '<input type="text" name="" disabled></input>';
            _this.parent('.col-span-2').siblings('.col-span-5').html(inputHtml)
        }

        updateSelectLabels()
    })

    createProductVariables();
})

function updateSelectLabels() {
    let selectedValues = [];


    $(".repeater .selectProperties").each(function () {
        let _this = $(this);
        let selected = _this.find("option:selected").val();

        if (selected != 0) {
            selectedValues.push(selected);
        }
    });

    $('.repeater .selectProperties').find('option').removeAttr('disabled');

    for (let i = 0; i < selectedValues.length; i++) {
        $(".selectProperties")
            .find("option[value=" + selectedValues[i] + "]")
            .prop("disabled", true);
    }
}

function initializeSelectMultiple() {
    $('.selectMultiple').each(function () {
        getSelect2($(this));
    });
}

function select2Variables(attibbuteID) {
    let className = 'select selectMultiple variant-' + attibbuteID + ' bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 ';
    let html = '<select class="' + className + '" name="attribute[]" multiple data-catID="' + attibbuteID + '"></select>'
    return html;
}

function createProductVariables() {
    $(document).on('change', '.selectMultiple', function () {
        let _this = $(this);

        createVariant()
    })
}

function createVariant() {
    let attributes = [];
    let attributeTitle = [];
    $('div[data-repeater-item]').each(function () {
        let attr = [];
        let attributeSelectID = $(this).find('.selectProperties option:selected').val();
        let attributeSelectText = $.trim($(this).find('.selectProperties option:selected').text());
        let attributeSelect = $('.variant-' + attributeSelectID).select2('data')

        for (let i = 0; i < attributeSelect.length; i++) {

            let item = {};
            let itemVariant = {};

            item[attributeSelectText] = attributeSelect[i].text;
            attr.push(item);
        }

        attributeTitle.push(attributeSelectText);
        attributes.push(attr);

    })

    attributes = attributes.reduce((a, b) => a.flatMap(d => b.map(e => ({ ...d, ...e }))))

    // Render Table
    let html = renderTableHTML(attributes,attributeTitle);
    $('#renderTableAttribute').html(html)
}

function renderTableHTML(attribute, attributeTitle) {

    let html = '';

    html += '<thead class="text-xs text-white uppercase bg-gray-500 ">';
    html += '    <tr>';

    for (let index = 0; index < attributeTitle.length; index++) {
        html += '        <th scope="col" width="10%" class="px-6 py-3">' + attributeTitle[index] + '</th>';

    }
    html += '        <th scope="col" width="15%" class="px-6 py-3">Số lượng</th>';
    html += '        <th scope="col" width="15%" class="px-6 py-3">Giá bán</th>';
    html += '        <th scope="col" width="15%" class="px-6 py-3">SKU</th>';
    html += '    </tr>';
    html += '</thead>';
    html += '<tbody>';
    for (let j = 0; j < attribute.length; j++) {
        html += '    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">';

        $.each(attribute[j],function(index,value){
            html += '        <td class="px-6 py-4 text-center">'+value+'</td>';
        })
        html += '        <td class="px-6 py-4 text-center">-</td>';
        html += '        <td class="px-6 py-4 text-center">-</td>';
        html += '        <td class="px-6 py-4 text-center">-</td>';
        html += '    </tr>';
    }

    html += '</tbody>';

    return html;
}


function getSelect2(obj) {

    let option = {
        'attributeId': obj.attr('data-catID')
    }

    $(obj).select2({
        minimumInputLength: 1,

        placeholder: 'Nhập tối thiểu 1 ký tự để tìm kiếm',
        ajax: {
            type: 'POST',
            url: routeGetChildrenProperties,
            dataType: 'json',
            deley: 250,
            data: function (params) {
                return {
                    search: params.term,
                    option: option
                }
            },
            processResults: function (data) {
                return {
                    results: data.items,
                }
            },
            cache: true,

        }
    });
}

function checkMaxAttributeGroup(attribute) {
    let attributeItemLength = $("div[data-repeater-item]").length;

    let createButton = $(".repeater").find("button[data-repeater-create]");

    createButton.toggle(attributeItemLength < attribute.length);
}

// * Xử lý sự kiện 'change' trên phần tử có id 'name'.
// * Gọi hàm ChangeToSlug với giá trị hiện tại của phần tử.
$("#name").on("change", function () {
    let _this = $(this);

    ChangeToSlug(_this.val());
});

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
