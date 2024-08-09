 var uploadedDocumentMap = {}
     // Khởi tạo Dropzone trên phần tử có ID là myDropzone
 Dropzone.autoDiscover = false; // Tắt chế độ tự động tìm kiếm các phần tử có class dropzone

 $(document).ready(function() {
     $("#myDropzone").dropzone({
         url: "/admin/upload", // Đường dẫn xử lý tệp tin sau khi tải lên
         headers: {
             'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                 'content')
         },
         maxFiles: 1,
         maxFilesize: 5, // Dung lượng tối đa cho mỗi tệp tin (đơn vị MB)
         acceptedFiles: ".png, .jpg, .gif, .svg", // Các loại tệp tin được chấp nhận
         addRemoveLinks: true, // Cho phép xóa tệp tin sau khi đã tải lên
         dictDefaultMessage: "Kéo và thả tệp tin vào đây hoặc nhấp để chọn tệp", // Tin nhắn mặc định
         init: function() {

             this.on("maxfilesexceeded", function(file) {
                 this.removeAllFiles();
                 this.addFile(file);
             });
         },
         success: function(file, response) {

             $('.dropzone').append('<input type="hidden" name="image" value="' + response
                 .name +
                 '">')
             uploadedDocumentMap[file.name] = response.name
         },
         removedfile: function(file) {
             file.previewElement.remove()
             var name = ''
             if (typeof file.file_name !== 'undefined') {
                 name = file.file_name
             } else {
                 name = uploadedDocumentMap[file.name]
             }
             $('.dropzone').find('input[name="image"][value="' + name + '"]').remove()
         },
     })
 });