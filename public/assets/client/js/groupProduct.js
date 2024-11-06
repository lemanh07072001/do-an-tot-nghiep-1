

let currentPage = 1; // Trang hiện tại
let lastPage = false; // Kiểm tra nếu là trang cuối cùng

// Hàm gọi AJAX để lấy dữ liệu sản phẩm
function fetchProducts(page = 1, sort = "") {
    var slug = $(".box-product").attr("data-slug-product");
    addLoading();

    $.ajax({
        url: getGroupProductAjax,
        type: "GET",
        data: {
            page: page,
            sort: sort,
            slug: slug,
        },
        success: function (response) {
            hideLoading();
            // Render sản phẩm mới lên giao diện


            $dataRender = renderHtmlProduct(response.data);
            $("#product-list").append($dataRender);
            currentPage = response.current_page;

            // Nếu là trang cuối cùng, ẩn nút "Tải thêm"
            if (currentPage >= response.last_page) {
                $("#load-more").hide();
                lastPage = true;
            } else {
                $("#load-more").show();
            }
        },
        error: function (error) {
            hideLoading();
            if (error.status == 404) {
                var dataRender = renderNoProduct();
                $("#product-list").removeClass('grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5')
                $("#product-list").html(dataRender);
            }
        }
    });
}


$(document).ready(function () {
    fetchProducts();
    sortSelect();
    loadMore();
});
