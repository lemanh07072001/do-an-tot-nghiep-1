function handleDisInput() {
    $('.unlimited').on('change', function () {
        let _this = $(this)

        let inputChecked = $('input[type="number"][name="limit"]');
        if (_this.prop('checked') == true) {

            inputChecked.removeClass('cursor-not-allowed disabled')
        } else {

            inputChecked.addClass('cursor-not-allowed disabled')
            inputChecked.val('');
        }
    })
}

function handleCodeRandom() {
    $('#codeRandom').on('click', function () {
        const randomString = generateRandomString(8);

        let inputRandom = $('input[type="text"][name="name"]');

        inputRandom.val(randomString);
    })
}

function handleToggleTime() {
    $('#time').on('click', function () {
        let _this = $(this);

        if (_this.prop('checked') === true) {
            $('#timeMain').addClass('hidden');
        } else {
            $('#timeMain').removeClass('hidden');
        }

    })
}

function generateRandomString(length) {
    if (length > 36) {
        throw new Error('Length cannot be greater than 36');
    }

    const characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
    let result = '';
    const usedCharacters = new Set();

    while (result.length < length) {
        const randomIndex = Math.floor(Math.random() * characters.length);
        const randomChar = characters[randomIndex];

        if (!usedCharacters.has(randomChar)) {
            usedCharacters.add(randomChar);
            result += randomChar;
        }
    }

    return result;
}


$(document).ready(function () {
    handleDisInput();
    handleCodeRandom();
    handleToggleTime();

})
