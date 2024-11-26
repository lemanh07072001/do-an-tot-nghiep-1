$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});


function selectProperties() {
    $(document).on("change", ".selectProperties", function () {
        let _this = $(this);



        let attributeID = _this.val();
        if (attributeID != 0) {

            _this.parent('.col-span-2').siblings('.col-span-5').html(select2Variables(attributeID))

            initializeSelectMultiple();
        } else {
            let inputHtml = '<input type="text" name="attribute[' + attributeID + '][]" class=" bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" disabled></input>';
            _this.parent('.col-span-2').siblings('.col-span-5').html(inputHtml)
        }

        updateSelectLabels()
    })
}

function updateSelectLabels() {
    let selectedValues = [];

    $(".repeater .selectProperties").each(function () {
        let selected = $(this).val();
        if (selected && selected != "0") {
            selectedValues.push(selected);
        }
    });

    $(".repeater .selectProperties").each(function () {
        let _this = $(this);
        let currentVal = _this.val();

        // Re-enable all options
        _this.find('option').prop('disabled', false);

        // Disable already selected options, except for the current one
        selectedValues.forEach(function (value) {
            if (value != currentVal) {
                _this.find("option[value=" + value + "]").prop('disabled', true);
            }
        });
    });
}

function initializeSelectMultiple() {

    $('.selectMultiple').each(function () {

        getSelect2($(this));
    });
}

function select2Variables(attibbuteID) {
    let className = ' selectMultiple variant-' + attibbuteID + ' bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 ';
    let html = '<select class="' + className + '" name="attribute[' + attibbuteID + '][]" multiple data-catID="' + attibbuteID + '"></select>'
    return html;
}

function createProductVariables() {
    $(document).on('change', '.selectMultiple', function () {
        let _this = $(this);

        createVariant()
    })
}

function checkAddForm() {
    let price = $('input[name=price]').val();
    let sku = $('input[name=sku]').val();

    if (price == '' && sku == '') {

        return false;
    }
}

function setupProductVariant() {
    if ($('.turnOnVariant').length) {

        $(document).on('click', '.turnOnVariant', function () {

            let _this = $(this);

            let price = $('input[name=price]').val();
            let sku = $('input[name=sku]').val();

            if (price == '' || sku == '') {
                Swal.fire({
                    position: "center",
                    icon: "warning",
                    title: "Vui lòng nhập ( Giá tiền ) và ( SKU )",
                    showConfirmButton: false,
                    timer: 1500,
                    width: '600px'
                });
                _this.prop('checked', false)
                return;
            }else{
                if (_this.prop('checked')) {
                    $('.add-row').prop('disabled', false);
                    $('.add-row').removeClass('cursor-not-allowed');
                    $('.attributeList').removeClass('hidden');

                } else {
                    $('.add-row').prop('disabled', true);
                    $('.add-row').addClass('cursor-not-allowed');
                    $('.attributeList').addClass('hidden');
                }
            }


        })
    }
}



function createVariant() {
    let attributes = [];
    let variants = [];
    let attributeTitle = [];
    $('div[data-repeater-item]').each(function () {
        let attr = [];
        let attrVariant = [];
        let attributeSelectID = $(this).find('.selectProperties option:selected').val();
        let attributeSelectText = $.trim($(this).find('.selectProperties option:selected').text());
        let attributeSelect = $('.variant-' + attributeSelectID).select2('data')


        if (attributeSelect && attributeSelect.length) {
            for (let i = 0; i < attributeSelect.length; i++) {
                let item = {};
                let itemVariant = {};

                item[attributeSelectText] = attributeSelect[i].text;
                itemVariant[attributeSelectID] = attributeSelect[i].id;
                attr.push(item);
                attrVariant.push(itemVariant)
            }
        } else {
            return;
        }


        attributeTitle.push(attributeSelectText);
        attributes.push(attr);
        variants.push(attrVariant);
    })


    if (attributes.length > 0) {
        attributes = attributes.reduce((a, b) => a.flatMap(d => b.map(e => ({ ...d, ...e }))))
    } else {
        attributes = [];
    }

    if (variants.length > 0) {
        variants = variants.reduce((a, b) => a.flatMap(d => b.map(e => ({ ...d, ...e }))))
    } else {
        variants = [];
    }



    //Render Table
    // let html = renderTableHTML(attributes, attributeTitle,variants);
    // if(attributes.length && variants.length > 0){
    //     $('#renderTableAttribute').html(html)
    // }else{
    //     $('#renderTableAttribute').empty()
    // }

    createTableHeader(attributeTitle)


    let trClass = [];

    attributes.forEach((item, index) => {
        let $row = createTableRow(item, variants[index]);


        let classModified = 'tr-variant-' + Object.values(variants[index]).join(', ').replace(/, /g, '-');
        trClass.push(classModified);

        if (!$('table .bodyRow tr').hasClass(classModified)) {
            $('table').find('.bodyRow').append($row);
        }

    });




    $('table .bodyRow tr').each(function () {
        const $row = $(this);

        const rowClasses = $row.attr('class');

        let trVariantClass = rowClasses.match(/\btr-variant-\S*/g)

        if (trVariantClass) {
            let joinedClass = trVariantClass.join(' ');
            const classArray = joinedClass.split(' ');
            let shouldRemove = false;
            classArray.forEach(function (className) {
                if (className == 'variant-row') {
                    return;
                } else if (!trClass.includes(className)) {
                    shouldRemove = true;
                }
            });

            if (shouldRemove) {
                $row.remove();
            }
        }
    })
}

function createTableHeader(attributesTitle) {
    let html = '';
    html += '    <tr >';

    for (let index = 0; index < attributesTitle.length; index++) {
        html += '        <th width="' + 55 / (attributesTitle.length) + '%" class="px-6 py-3 text-center" >' + attributesTitle[index] + '</th>';
    }
    html += '        <th width="15%" class="px-6 py-3 text-center">Số lượng</th>';
    html += '        <th width="15%" class="px-6 py-3 text-center">Giá bán</th>';
    html += '        <th width="15%" class="px-6 py-3 text-center">Giảm giá</th>';
    html += '        <th width="15%" class="px-6 py-3 text-center">SKU</th>';
    html += '    </tr>';

    if (attributesTitle.length > 0) {
        $('.theadHeader').html(html);
    } else {
        $('.theadHeader').empty()
    }

}

function createTableRow(attributeItem, variantItem) {

    // Convert attribute and variant values to strings
    let attributeString = Object.values(attributeItem).join(', ');
    let attributeId = Object.values(variantItem).join(', ');
    let classModified = attributeId.replace(/, /g, '-');




    // Create a new table row with dynamic classes
    let $row = $('<tr>').addClass('variantRow tr-variant-' + classModified + ' bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600');

    // Loop through attributeItem and create table cells
    Object.values(attributeItem).forEach(function (value) {
        let $td = $('<td>').addClass('text-center').text(value);
        $row.append($td);
    });

    // Create a hidden cell to store hidden inputs
    let $tdHidden = $('<td>').addClass('hidden td-variant');

    let priceText = $('input[name=price]').val();
    let priceSale = $('input[name=priceSale]').val();



    let skuText = $('input[name=sku]').val();

    // Define hidden input fields
    let inputHiddenFields = [
        { name: 'variant[quantity][]', class: 'variant_quantity' },
        { name: 'variant[price][]', class: 'variant_price', value: priceText },
        { name: 'variant[priceSale][]', class: 'variant_priceSale', value: priceSale },
        { name: 'variant[sku][]', class: 'variant_sku', value: skuText + '-' + classModified },
        { name: 'productVariant[name][]', class: 'product_name', value: attributeString },
        { name: 'productVariant[id][]', class: 'product_value', value: attributeId }
    ];

    // Create and append hidden inputs to the hidden cell
    $.each(inputHiddenFields, function (_, field) {
        let $input = $('<input>')
            .attr('type', 'text')
            .attr('name', field.name)
            .addClass(field.class);

        // Set the value of the input if provided
        if (field.value) {
            $input.val(field.value);
        }

        $tdHidden.append($input);
    });

    // Append the hidden cell to the row
    $row.append($tdHidden);

    // Append other cells with placeholders
    $row.append($('<td>').addClass('px-6 py-4 text-center td-quantity').text('-'));
    $row.append($('<td>').addClass('px-6 py-4 text-center td-price').text(priceText??'-'));
    $row.append($('<td>').addClass('px-6 py-4 text-center td-priceSale').text(priceSale??'-'));
    $row.append($('<td>').addClass('px-6 py-4 text-center td-sku').text(skuText + '-' + classModified));

    return $row;
}

function updateVariant() {
    $(document).on('click', '.variantRow', function () {
        let _this = $(this);
        let variantData = {};
        _this.find(".td-variant input[type=text][class^='variant_']").each(function () {
            let className = $(this).attr('class');

            variantData[className] = $(this).val();
        })

        if ($('.updateVariantTr').length == 0) {
            let updateVariantBox = updateVariantHTML(variantData);
            _this.after(updateVariantBox)
        }



    })
}

// function renderTableHTML(attribute, attributeTitle, variants) {

//     let html = '';

//     html += '<thead class="text-xs text-white uppercase bg-gray-500" >';
//     html += '    <tr >';

//     for (let index = 0; index < attributeTitle.length; index++) {
//         html += '        <th width="' + 100 / (attributeTitle.length) + '%" class="px-6 py-3" >' + attributeTitle[index] + '</th>';

//     }
//     html += '        <th width="15%" class="px-6 py-3">Số lượng</th>';
//     html += '        <th width="15%"  class="px-6 py-3">Giá bán</th>';
//     html += '        <th width="15%"  class="px-6 py-3">SKU</th>';
//     html += '    </tr>';
//     html += '</thead>';
//     html += '<tbody>';


//     for (let j = 0; j < attribute.length; j++) {
//         html += '    <tr class="variantRow bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">';

//         let attributeArray = [];
//         let attributeIdArray = [];
//         $.each(attribute[j], function (index, value) {
//             html += '        <td class="px-6 py-4 text-center">' + value + '</td>';
//             attributeArray.push(value)
//         })

//         $.each(variants[j], function (index, value) {

//             attributeIdArray.push(value)
//         })

//         let attributeString = attributeArray.join(', ')
//         let attributeIDString = attributeIdArray.join(', ')

//         html += '        <td class="px-6 py-4 text-center td-quantity">-</td>';
//         html += '        <td class="px-6 py-4 text-center td-price">-</td>';
//         html += '        <td class="px-6 py-4 text-center td-sku">-</td>';
//         html += '        <td class="hidden td-variant">';
//         html += '        <input type="text" name="variant[quantity][]" class="variant_quantity"/>';
//         html += '        <input type="text" name="variant[price][]" class="variant_price"/>';
//         html += '        <input type="text" name="variant[sku][]" class="variant_sku"/>';
//         html += '        <input type="text" name="attribute[name][]" class="attribute-name" value="' + attributeString + '"/>';
//         html += '        <input type="text" name="attribute[value][]" class="attribute-value" value="' + attributeIDString + '"/>';
//         html += '        </td>';
//         html += '    </tr>';

//     }

//     html += '</tbody>';

//     return html;


// }


function updateVariantHTML(variantData) {

    let html = '';

    html += '<tr class="updateVariantTr w-100">';
    html += '    <td colspan="10">';
    html += '        <div class="bg-white rounded-lg shadow p-4 w-100">';
    html += '            <div class="flex items-center justify-between">';
    html += '                <span class="text-1xl font-bold text-gray-900">Cập nhật thông tin phiên bản</span>';
    html += '                <div>';
    html += '                    <button id="saveUpdate" type="button" class="text-white bg-gradient-to-r from-cyan-400 via-cyan-500 to-cyan-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-cyan-300  font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2">Save</button>';
    html += '                    <button id="cancleUpdate" type="button" class="text-white bg-gradient-to-r from-purple-500 via-purple-600 to-purple-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-purple-300font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2">Exit</button>';
    html += '                </div>';
    html += '            </div>';
    html += '            <div>';
    html += '                <div class="grid grid-cols-8 gap-4 gap-y-4">';

    html += '                    <div class="col-span-6 sm:col-span-2">';
    html += '                        <label for="quantity1" class="inline-flex items-center cursor-pointer mb-2 text-sm font-medium text-gray-900">Số lượng</label>';
    html += '                        <input name="variant_quantity" type="number" min="0 id="quantity1" value="' + variantData.variant_quantity + '"   variant_quantity class="quantity  bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" placeholder="Số lượng">';
    html += '                    </div>';
    html += '                    <div class="col-span-6 sm:col-span-2">';
    html += '                        <label for="price" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Giá bán</label>';
    html += '                        <input name="variant_price" type="text" id="price" value="' + variantData.variant_price + '" class="int variant_price bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" placeholder="Giá bán">';
    html += '                    </div>';
    html += '                    <div class="col-span-6 sm:col-span-2">';
    html += '                        <label for="priceSale" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Giảm giá</label>';
    html += '                        <input name="variant_priceSale" type="text" id="priceSale" value="' + variantData.variant_priceSale + '" class="int variant_priceSale bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" placeholder="Giảm giá">';
    html += '                    </div>';
    html += '                    <div class="col-span-6 sm:col-span-2">';
    html += '                        <label for="sku" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">SKU</label>';
    html += '                        <input name="variant_sku" type="text" id="sku" value="' + variantData.variant_sku + '" class="variant_sku bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" placeholder="SKU">';
    html += '                    </div>';

    html += '                </div>';
    html += '            </div>';
    html += '        </div>';
    html += '    </td>';
    html += '</tr>';

    return html;
}

function cancleVariantUpdate() {
    $(document).on('click', '#cancleUpdate', function () {
        $(this).closest('.updateVariantTr').remove();
    })
}

function saveVariantUpdate() {
    $(document).on('click keyup', '#saveUpdate', function (e) {
        if (e.type === 'click' || (e.type === 'keyup' && e.keyCode === 13)) {
            e.preventDefault();

            var inputQuantity = $('.quantity').val();
            var inputPriceSale = $('#priceSale').val();
            var inputPrice = $('#price').val();

            if(inputPriceSale == ''){
                alert('Vui lòng nhập giá khuyến mãi hoặc giá trị bằng 0')
                return
            }else if(inputQuantity == ''){
                alert('vui lòng nhập số lượng')
                return
            } else if (inputPriceSale > inputPrice){
                alert('Giá khuyến mãi đanh nhỏ hơn giá bán')
            }

            let variantObj = {
                'quantity': $('input[name="variant_quantity"]').val(),
                'price': $('input[name="variant_price"]').val(),
                'priceSale': $('input[name="variant_priceSale"]').val(),
                'sku': $('input[name="variant_sku"]').val(),
            };

            // Cập nhật các giá trị của variantObj vào hàng trước đó của .updateVariantTr
            $.each(variantObj, function (index, value) {
                $('.updateVariantTr').prev().find('.variant_' + index).val(value);
            });

            // Gọi hàm updateTrPreviewBox với đối tượng variantObj
            updateTrPreviewBox(variantObj);

            // Xóa phần tử chứa class .updateVariantTr
            $(this).closest('.updateVariantTr').remove();
        }
    })
}

function updateTrPreviewBox(variantObj) {
    let optionObj = {
        'quantity': variantObj.quantity,
        'price': variantObj.price,
        'priceSale': variantObj.priceSale,
        'sku': variantObj.sku
    };

    $.each(optionObj, function (index, value) {
        $('.updateVariantTr').prev().find('.td-' + index).html(value);
    });

}

function checkToggleQuantity() {
    $(document).on('change', '.checkquantity', function () {
        let checked = $(this).is(":checked");
        let quantityInput = $('.quantity');

        if (checked) {
            quantityInput.prop('disabled', false);
            quantityInput.removeClass('cursor-not-allowed')
        } else {
            quantityInput.prop('disabled', true);
            quantityInput.addClass('cursor-not-allowed')
            quantityInput.val('');
        }
    })
}

function Select2() {
    $('.select').select2({
        width: '100%',
        minimumResultsForSearch: Infinity
    });
}


function handleCreateRow() {
    $(document).on('click', 'button[data-create]', function () {

        let htmlRender = renderVariantItem(getAllProperties);

        $('.data-render').append(htmlRender)
        Select2();

        updateSelectLabels();
        checkMaxAttributeGroup(getAllProperties);
    })
}

function handleDeleteRow() {
    $(document).on('click', 'button[data-delete]', function (e) {
        e.preventDefault(); // Ngăn chặn hành vi mặc định của nút (nếu có)

        const $row = $(this).closest('[data-repeater-item]'); // Lấy phần tử hàng (row) gần nhất chứa thuộc tính data-repeater-item

        Swal.fire({
            title: "Bạn muốn xoá hàng này?",
            text: "Xoá không thể khôi phục lại được!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Đồng ý!"
        }).then((result) => {
            if (result.isConfirmed) {
                $row.remove(); // In ra thông tin về hàng để kiểm tra
                createVariant();
                updateSelectLabels();
                checkMaxAttributeGroup(getAllProperties);
            }
        });

    })
}


function renderVariantItem(getAllProperties) {
    let html = '';

    html += '<div>';
    html += '    <div data-repeater-item>';
    html += '        <div class="grid grid-cols-8 gap-4 gap-y-4">';
    html += '            <div class="col-span-2 sm:col-span-2 mb-2">';
    html += '                <select name="attributeCatalogue[]" class=" selectProperties bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">';
    html += '                    <option value="">--Chọn thuộc tính--</option>';
    $.each(getAllProperties, function (index, value) {
        html += '<option value="' + value.id + '">' + value.name + '</option>';
    });
    html += '                </select>';
    html += '            </div>';
    html += '            <div class="col-span-5 sm:col-span-5 mb-2">';
    html += '                <input type="text" name="input_attribute" class=" bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" disabled>';
    html += '            </div>';
    html += '            <div class="col-span-1 sm:col-span-1">';
    html += '                <button type="button" data-delete class="text-white bg-gradient-to-r from-red-400 via-red-500 to-red-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2">';
    html += '                    Delete';
    html += '                </button>';
    html += '            </div>';
    html += '        </div>';
    html += '    </div>';
    html += '</div>';

    return html;
}



function getSelect2(obj) {

    let option = {
        'attributeId': obj.attr('data-catID')
    }

    $(obj).select2({


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

    let createButton = $(".repeater").find("button[data-create]");

    createButton.toggle(attributeItemLength < attribute.length);
}

function handleChangeSlug() {
    // * Xử lý sự kiện 'change' trên phần tử có id 'name'.
    // * Gọi hàm ChangeToSlug với giá trị hiện tại của phần tử.
    $("#name").on("change", function () {
        let _this = $(this);

        ChangeToSlug(_this.val());
    });
}

function setupSelectMultiple(callback) {
    if ($('.selectMultiple').length) {

        let count = $('.selectMultiple').length;

        $('.selectMultiple').each(function () {
            let _this = $(this);
            let attributeId = _this.attr('data-catid');

            if (attributes != '') {
                $.ajax({
                    type: 'POST',
                    url: getAttributeAjax,
                    dataType: 'json',
                    deley: 250,
                    data: {
                        attributes: attributes,
                        attributeId: attributeId
                    }, success: function (json) {


                        if (json.items != 'undefined' && json.items.length) {
                            for (let index = 0; index < json.items.length; index++) {
                                var option = new Option(json.items[index].name, json.items[index].id, true, true);
                                _this.append(option).trigger('change');;
                            }
                        }

                        if (--count == 0 && callback) {
                            callback();
                        }
                    }

                })

            }

            getSelect2(_this)
        })


    }
}

function productVariant() {


    $('.variantRow').each(function (index, value) {
        let _this = $(this);

        let inputHiddenFields = [
            { name: 'variant[quantity][]', id: 'quantity', class: 'variant_quantity', value: variants.quantity[index] },
            { name: 'variant[price][]', id: 'price', class: 'variant_price', value: variants.price[index] },
            { name: 'variant[priceSale][]', id: 'priceSale', class: 'variant_priceSale', value: variants.priceSale[index] },
            { name: 'variant[sku][]', id: 'sku', class: 'variant_sku', value: variants.sku[index] },
        ];

        for (let index = 0; index < inputHiddenFields.length; index++) {
            _this.find('.' + inputHiddenFields[index].class).val(inputHiddenFields[index].value)
        }

        _this.find('.td-quantity').html(variants.quantity[index]);
        _this.find('.td-price').html(addCommas(variants.price[index]));
        _this.find('.td-priceSale').html(addCommas(variants.priceSale[index]));
        _this.find('.td-sku').html(variants.sku[index]);
    })
}

$(document).ready(function () {

    setupSelectMultiple(function () {
        productVariant();
    });
    handleCreateRow();
    handleDeleteRow();
    handleChangeSlug();
    selectProperties();
    createProductVariables();
    checkToggleQuantity();
    updateVariant();
    cancleVariantUpdate();
    saveVariantUpdate();
    setupProductVariant();


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
