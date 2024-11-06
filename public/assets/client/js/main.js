


function openMenuMobile() {
    $('#buttonOpenMenuMobile').on('click', function () {
        let _menu = $('#menu');

        _menu.removeClass('hidden');
        $('body').addClass('overflow-hidden');
    })
}

function closeMenuMobile() {
    $('#buttonCloseMenuMobile').on('click', function () {
        let _menu = $('#menu');

        _menu.addClass('hidden');
        $('body').removeClass('overflow-hidden');
    })
}

function openSupMenuMobile() {
    $('#openSupMenuMobile').on('click', function () {
        let _supMenuMobile = $('#supMenuMobile');

        _supMenuMobile.toggleClass('hidden');
        $(this).toggleClass('rotate-180 transition duration-500');


        if ($(this).hasClass('rotate-180')) {
            $(this).removeClass('rotate-0 transition duration-500').addClass('rotate-180 transition duration-500');
        } else {
            $(this).removeClass('rotate-180 transition duration-500').addClass('rotate-0 transition duration-500');
        }

    });
}

function timeDown() {
    // Thời gian đếm ngược ban đầu (tính bằng giây)
    var countdownTime = 60 * 60 * 2; // 2 giờ


    // Hàm cập nhật đồng hồ đếm ngược
    function updateCountdown() {
        // Tính toán số giờ, phút và giây còn lại
        var hours = Math.floor(countdownTime / 3600);
        var minutes = Math.floor((countdownTime % 3600) / 60);
        var seconds = countdownTime % 60;

        // Thêm số 0 nếu số phút hoặc giây dưới 10
        if (minutes < 10) {
            minutes = "0" + minutes;
        }
        if (seconds < 10) {
            seconds = "0" + seconds;
        }


        // Hiển thị thời gian trong phần tử HTML
        $('#hours').text(hours)
        $('#minutes').text(minutes)
        $('#seconds').text(seconds)


        // Giảm thời gian đi 1 giây
        countdownTime--;

        // Nếu thời gian hết thì dừng đồng hồ
        if (countdownTime < 0) {
            clearInterval(countdownInterval);
            alert("Hết giờ!");
        }
    }

    // Cập nhật đồng hồ mỗi giây
    var countdownInterval = setInterval(updateCountdown, 1000);
}


function swiper(elmClass = '') {
    var swiper = new Swiper(elmClass, {
        navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev",
        },
    });
}


function addLoading(){
    $('#loading').show(); // Hiển thị spinner
    // $('body').addClass('overflow-hidden');
}

function hideLoading(){
    $('#loading').hide(); // Hiển thị spinner
    // $('body').addClass('overflow-hidden');
}


$(document).ready(function () {
    openMenuMobile();
    closeMenuMobile();
    openSupMenuMobile();
    timeDown();

    // $('#menu a').on('click', function(){
    //     console.log('da');
    // })
})
