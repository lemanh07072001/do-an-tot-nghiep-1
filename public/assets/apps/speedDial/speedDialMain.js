

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

$(document).ready(function(){

    openBoxChatGpt();
    cloneBoxChatGpt();
})
