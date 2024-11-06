function renderHtmlLabel(url) {
    var html = "";

    html +=
        '        <div class="absolute top-3 left-3 z-40 h-[2.8em] w-[2.8em] rounded-full">';
    html += '          <img class="h-full" src="' + hostUrl(url) + '"/>';
    html += "        </div>";

    if (url === undefined) {
        return html ="";
    } else {
        return html;
    }

}

function renderNoProduct() {
    let html = "";
    html +=
        '<div class="flex items-center justify-center h-64 bg-gray-100 rounded-lg">';
    html += '    <div class="text-center p-6 bg-white shadow-lg rounded-lg">';
    html +=
        '        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-red-500 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor">';
    html +=
        '            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6m2 6H7a2 2 0 01-2-2V7a2 2 0 012-2h10a2 2 0 012 2v10a2 2 0 01-2 2z" />';
    html += "        </svg>";
    html +=
        '        <h2 class="mt-4 text-xl font-semibold text-gray-800">Không có sản phẩm</h2>';
    html +=
        '        <p class="mt-2 text-gray-600">Hiện tại không có sản phẩm nào trong danh mục này. Vui lòng quay lại sau.</p>';
    html += "    </div>";
    html += "</div>";

    return html;
}

function renderHtmlProduct(data) {


    let html = "";


    $(data).each(function (key, value) {
        let urlRoute = hostUrl()+'/san-pham/' + value.slug


        if (value.variants == "") {
            return;
        }

        var jsonPrice = jsonDecode(value.variants);
        var prices = jsonPrice.price;
        var numericPrices = prices.map((price) =>
            parseFloat(price.replace(/\./g, ""))
        );

        // Tìm giá trị lớn nhất và nhỏ nhất
        var maxPrice = Math.max(...numericPrices);
        var minPrice = Math.min(...numericPrices);

        html += '<div class="col-span-1 ">';
        html += '  <div class="px-2 pb-3 group ">';
        html +=
            '    <div class="border-[#e0e0e0] border-[1px] relative pt-1 rounded-[20px] overflow-hidden shadow-[0_1px_3px_-2px_rgba(0,0,0,0.12),0_1px_2px_rgba(0,0,0,0.24)] group-hover:shadow-[0_3px_6px_-4px_rgba(0,0,0,0.16),0_3px_6px_rgba(0,0,0,0.23)] duration-300">';
        html += '      <a class="loadingHref" href="' + urlRoute +'">';

        switch (value.label) {


            case 1:
                html += renderHtmlLabel("images/client/label/hot.png");
                break;
            case 2:
                html += renderHtmlLabel("images/client/label/new.png");
                break;
            case 3:
                html += renderHtmlLabel("images/client/label/sale.png");
                break;
            default:
                html += renderHtmlLabel();
        }

        html += '        <div class="relative min-h-[210px]">';
        html += '          <img src="' + hostUrl(value.avatar) + '"';
        html +=
            '               class="absolute block w-full -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2" alt="...">';
        html += "        </div>";
        html += '        <div class="px-4 pb-5 pt-2 text-[.9em]">';
        html += "          <p class='truncate'>" + value.name + "</p>";
        html += '          <p class="my-[6px]">';
        html += '          <div class="flex font-bold text-[#111]">';
        html += "            <span>" + formatToVND(minPrice) + "</span>";
        html += "            &nbsp;-&nbsp;";
        html += "            <span>" + formatToVND(maxPrice) + "</span>";
        html += "          </div>";
        html += "          </p>";
        html += "        </div>";
        html += "      </a>";
        html += "    </div>";
        html += "  </div>";
        html += "</div>";
    });

    return html;
}

function sortSelect() {
    // Lắng nghe sự kiện thay đổi trên dropdown
    $("#sort-select").change(function () {
        let sortValue = $(this).val();

        currentPage = 1; // Reset lại trang về trang đầu
        $("#product-list").empty(); // Xóa danh sách sản phẩm cũ
        fetchProducts(1, sortValue); // Gọi hàm fetch để lấy dữ liệu sắp xếp
    });
}

function loadMore() {
    $("#load-more").click(function () {
        if (!lastPage) {
            let sortValue = $("#sort-select").val();
            fetchProducts(currentPage + 1, sortValue); // Gọi trang tiếp theo khi nhấn "Tải thêm"
        }
    });
}
