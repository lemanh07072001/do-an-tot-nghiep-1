$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

function openAIAssistant(editor) {
    let content = editor.getContent(); // Lấy nội dung hiện tại của TinyMCE
    $.ajax({
        url: '/admin/policy/ai-assistant', // Route đến API AI trong Laravel
        method: 'POST',
        data: {
            content: content,

        },
        success: function (response) {

            // Xử lý kết quả từ API và chèn vào editor
            editor.setContent(response.newContent);
        },
        error: function (xhr, status, error) {
            console.error('AI Assistant error:', error);
        }
    });
}

$(document).ready(function () {

})
