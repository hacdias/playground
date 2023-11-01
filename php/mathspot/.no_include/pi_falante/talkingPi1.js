$(document).ready(function () {

    var num  = 0;
    var isRunning = false;
    var auto = false;

    $('#talk-0').fadeIn(500);

    $('.blackboard').click(function() {
        if (!window.isRunning) {
            next(false);
        }
    });

    $('.choice-yes').click(function() {
        if (!window.isRunning) {
            next(true);
        }
    });

    $('.choice-no').click(function() {
        var item = $('#talk-' + num);

        item.fadeOut(500, function() {
           $('#talkNo').fadeIn(500);

           $('.choice-yes').fadeOut(500);
           $('.choice-no').fadeOut(500);
        });
    });


    function next(choice) {

        var item = $('#talk-' + num);

        window.isRunning = true;

        if (!choice && item.hasClass('talk-choice'))  {
            window.isRunning = false;
            return false;
        }

        if (choice) {
            $('.choice-yes').fadeOut(500);
            $('.choice-no').fadeOut(500);
        }

        var nextItem = '#talk-' + (num + 1);

        if ($(nextItem).length > 0) {
            item.fadeOut(500, function() {
                num++;
                item = $('#talk-' + num);

                item.fadeIn(500);

                if (item.hasClass('start-auto')) {
                    window.auto = true;
                }

                if (item.hasClass('stop-auto'))  {
                    window.auto = false;
                }

                if (item.hasClass('talk-choice') && !choice) {
                    $('.choice-yes').fadeIn(500);
                    $('.choice-no').fadeIn(500);
                }

                window.isRunning = false;

                if (window.auto) {
                    setTimeout(next, 5000);
                }

            });
        }

        return false;
    }

});

$(function() {

    setInterval( function() {
        var seconds = new Date().getSeconds();
        var sdegree = seconds * 6;
        var srotate = "rotate(" + sdegree + "deg)";

        $("#sec").css({ "transform": srotate });

    }, 1000 );

    setInterval( function() {
        var hours = new Date().getHours();
        var mins = new Date().getMinutes();
        var hdegree = hours * 30 + (mins / 2);
        var hrotate = "rotate(" + hdegree + "deg)";

        $("#hour").css({ "transform": hrotate});

    }, 1000 );

    setInterval( function() {
        var mins = new Date().getMinutes();
        var mdegree = mins * 6;
        var mrotate = "rotate(" + mdegree + "deg)";

        $("#min").css({ "transform" : mrotate });

    }, 1000 );

});
