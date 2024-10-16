function jsonDecode(json) {
    try {
        return JSON.parse(json);
    } catch (error) {
        console.error("Invalid JSON string:", error);
        return null; // Hoặc xử lý lỗi theo cách khác nếu cần
    }
}

function formatToVND(amount) {
    return amount.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".") + " ₫";
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
