

function openBoxChatGpt(){
    $('[data-tooltip-target="tooltip-chatgpt"]').on('click', function(){
        $('#box-chatGpt').removeClass('hidden');
        $('#dialButton').addClass('hidden');
        $(this).addClass('hidden');
    });
}

function cloneBoxChatGpt(){
    $('#cloneBoxChatGpt').on('click', function(){
        $('#box-chatGpt').addClass('hidden');
        $('#dialButton').removeClass('hidden');
        $('[data-tooltip-target="tooltip-chatgpt"]').removeClass('hidden');

    });
}

function getTime() {
    var now = new Date();
    var hours = now.getHours();
    var minutes = now.getMinutes();

    // Thêm số 0 trước giờ hoặc phút nếu cần
    hours = (hours < 10 ? "0" : "") + hours;
    minutes = (minutes < 10 ? "0" : "") + minutes;

    var formattedTime = hours + ":" + minutes;

    return formattedTime;
}

function renderHtmlMe(time,input){
    let html = '';
    html += '<div class="flex justify-end gap-2.5 mt-5 pr-2">';
    html +=
        '<div class="flex flex-col justify-items-end w-full max-w-[320px] leading-1.5 p-4 border-gray-200 bg-gray-100 rounded-s-xl rounded-ss-xl ">';
    html += '<div class="flex items-center space-x-2 rtl:space-x-reverse">';
    html += '<span class="text-sm font-semibold text-gray-900 dark:text-white">Tôi</span>';
    html += '<span class="text-sm font-normal text-gray-500 dark:text-gray-400">'+time+'</span>';
    html += '</div>';
    html +=
        '<p class="text-sm font-normal py-2.5 text-gray-900 dark:text-white">'+input+'</p>';
    html += '</div>';
    html += '</div>';

    $('.client-chat').append(html);
}

function renderHtmlAi(response,time){
    console.log(response);

    let html = '';

    html += '<div class="flex items-start gap-2.5 mt-5 boxitem">';
    html += '<img class="w-8 h-8 rounded-full" src="'+linkLogoGemini+'" alt="Jese image">';
    html += '<div class="flex flex-col w-full max-w-[320px] leading-1.5 p-4 border-gray-200 bg-gray-100 rounded-e-xl rounded-es-xl dark:bg-gray-700">';
    html += '<div class="flex items-center space-x-2 rtl:space-x-reverse">';
    html += '<span class="text-sm font-semibold text-gray-900 dark:text-white">Genmini</span>';
    html += '<span class="text-sm font-normal text-gray-500 dark:text-gray-400">'+time+'</span>';
    html += '</div>';
    html += '<p class="text-sm font-normal py-2.5 text-gray-900 dark:text-white">' +formatTextWithNewlines(response.result)+'</p>';
    html += '</div>';
    html += '</div>';

    $('.client-chat').append(html);
}

function formatTextWithNewlines(text) {
    // Thay thế ** bằng dấu ngắt dòng và giữ lại nội dung bên trong **
    return text.replace(/\*\*(.*?)\*\*/g, '\n$1\n');
}

function sendMessageAi(){
    $('#searchBtn').on('click', function(e) {

        e.preventDefault();
        ajaxSearch();

    })

    $('#searchBtn').on('keypress', function (event) {
        if (event.key === 'Enter') {
            console.log('ds');

            ajaxSearch();
        }
    });
}

function ajaxSearch(){
    let searchInput = $('#search').val();

    let time = getTime();

    renderHtmlMe(time, searchInput)

    scrollToBottom();

    $('#search').val('');

    $('#loadingAi').show();

    $(this).find('#btnLoadingSearch').removeClass('hidden');
    $(this).find('#textSearch').hide();
    $(this).attr('disabled', true);
    $(this).addClass('cursor-not-allowed');

    $.ajax({
        url: sendMessage,
        data: {
            valueData: searchInput,
        },
        type: "POST",
        dataType: "json",

        success: function (response) {

            renderHtmlAi(response, time)
            scrollToBottom();
            $('#loadingAi').hide();

            $('#btnLoadingSearch').addClass('hidden');
            $('#textSearch').show();
            $('#searchBtn').attr('disabled', false);
            $('#searchBtn').removeClass('cursor-not-allowed');
        },
        error: function (xhr, status, error) {
            $(this).find('#btnLoadingSearch').addClass('hidden');
            $(this).find('#textSearch').show();
        }

    })
}

function scrollToBottom() {
    var chatContainer = $('#chat-container'); // Thay đổi theo ID của container chứa tin nhắn
    var boxHieght = chatContainer.find('.boxitem').height();

    console.log(boxHieght);
    var paddingBottom = parseInt(chatContainer.css('padding-bottom'), 10); // Lấy giá trị padding-bottom
    console.log(chatContainer[0].scrollHeight - chatContainer.height() + paddingBottom);
    chatContainer.scrollTop(chatContainer[0].scrollHeight - chatContainer.height() + paddingBottom + boxHieght);
}

$(document).ready(function(){

    openBoxChatGpt();
    cloneBoxChatGpt();
    sendMessageAi();
})
