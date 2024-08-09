
// * Xử lý sự kiện 'change' trên phần tử có id 'name'.
// * Gọi hàm ChangeToSlug với giá trị hiện tại của phần tử.
$('#name').on('change', function() {
    let _this = $(this)

    ChangeToSlug(_this.val());
})


tinymce.init({
    selector: '#short_description',
    height: 300, // Thiết lập chiều cao (đơn vị là pixel)
    plugins: [
        'advlist autolink lists link image charmap print preview anchor',
        'searchreplace visualblocks code fullscreen',
        'insertdatetime media table paste code help wordcount'
    ],
    toolbar: 'undo redo | formatselect | bold italic backcolor | \
          alignleft aligncenter alignright alignjustify | \
          bullist numlist outdent indent | removeformat | help'
});

tinymce.init({
    selector: '#description',
    height: 300, // Thiết lập chiều cao (đơn vị là pixel)
    plugins: [
        'advlist autolink lists link image charmap print preview anchor',
        'searchreplace visualblocks code fullscreen',
        'insertdatetime media table paste code help wordcount'
    ],
    toolbar: 'undo redo | formatselect | bold italic backcolor | \
          alignleft aligncenter alignright alignjustify | \
          bullist numlist outdent indent | removeformat | help'
});
