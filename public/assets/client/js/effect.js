function jsonDecode(json) {
    try {
        return JSON.parse(json);
    } catch (error) {
        console.error("Invalid JSON string:", error);
        return null; // Hoặc xử lý lỗi theo cách khác nếu cần
    }
}

function formatToVND(amount) {
    return amount.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".") ;
}

function formatPriceVND(price) {
    return new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(price);
}

function tinhPhanTramGiam(originalPrice, salePrice) {
    // Nếu giá gốc hoặc giá giảm bằng 0 hoặc giá giảm lớn hơn giá gốc, trả về 0%
    if (originalPrice <= 0 || salePrice <= 0 || salePrice >= originalPrice) return 0;

    const discount = ((originalPrice - salePrice) / originalPrice) * 100;
    return discount.toFixed(0); // Giữ 2 chữ số thập phân
}

function findMaxMin(prices) {
    // Kiểm tra xem mảng có tồn tại và không rỗng
    if (!Array.isArray(prices) || prices.length === 0) {
        return { max: null, min: null };
    }

    // Tìm giá trị lớn nhất và nhỏ nhất
    const maxPrice = Math.max(...prices);
    const minPrice = Math.min(...prices);

    return { max: maxPrice, min: minPrice };
}

function hostUrl(path) {
    var baseUrl =
        window.location.protocol +
        "//" +
        window.location.hostname +
        (window.location.port ? ":" + window.location.port : "");

    // Nếu có path, nối vào baseUrl
    if (path) {
        baseUrl += "/" + path.replace(/^\/+/, ""); // Xóa dấu '/' ở đầu nếu có
    }

    return baseUrl;
}
