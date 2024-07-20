(function() {
    'use strict';

    var sTime = new Date().getTime();
    var countDown = 10; // Number of seconds to count down from.                   

    // Update CountDown Time
    function UpdateCountDownTime() {
        var cTime = new Date().getTime();
        var diff = cTime - sTime;
        var timeStr = '';
        var seconds = countDown - Math.floor(diff / 1000);
        if (seconds >= 0) {
            var hours = Math.floor(seconds / 3600);
            var minutes = Math.floor((seconds - (hours * 3600)) / 60);
            seconds -= (minutes * 60);

            if (seconds < 10) {
                timeStr = timeStr + "" + seconds;
            } else {
                timeStr = timeStr + "" + seconds;
            }
            document.getElementById("downloadfile").innerHTML = 'Please Wait ' + timeStr + 's';
            document.getElementById("downloadfile2").innerHTML = 'Please Wait ' + timeStr + 's';
        } else {
            $('.downloadfile').addClass('btn-green');
            $('.downloadfile').removeClass('text-dark');
            document.getElementById("downloadfile").innerHTML = DOWN_TXT;
            document.getElementById("downloadfile").href = DOWN_URL;
            $('.downloadfile2').addClass('btn-green');
            $('.downloadfile2').removeClass('text-dark');
            document.getElementById("downloadfile2").innerHTML = DOWN_TXT;
            document.getElementById("downloadfile2").href = DOWN_URL;
            clearInterval(counter);
            // Download btn on desktop
            $("#downloadfile").on("click", function() {
                $('.downloadfile').remove();
                $('.downloading_btn').removeClass('d-none')
            });

            // download btn on mobile
            $("#downloadfile2").on("click", function() {
                $('.downloadfile2').remove();
                $('.mobiledownloading_btn').removeClass('d-none')
            });
        }
    }
    UpdateCountDownTime();
    var counter = setInterval(UpdateCountDownTime, 500);

    $(document).ready(function() {
        // Copy URL
        $("#copy").on("click", function() {
            var copyText = document.getElementById("sharelink");
            copyText.select();
            copyText.setSelectionRange(0, 99999);
            document.execCommand("copy");
        });
    });
})(jQuery);