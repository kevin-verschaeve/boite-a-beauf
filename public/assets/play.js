$(function() {
    // play sound when it is registered
    createjs.Sound.on('fileload', function(e) {
        doPlay(e.src);
    }, this);

    // register or play sound on button click
    $(document).on('click', '.js-play', function(e) {
        e.preventDefault();
        playSound($(this).data('sound'));
    });

    $('.js-play-random').on('click', function (e) {
        e.preventDefault();
        // play array rand
        playSound(sounds[Math.floor(Math.random() * sounds.length)]);
    });

    var cron = false,
      interval;
    $('.js-cron').on('click', function(e) {
        e.preventDefault();
        if (false === cron) {
            interval = setInterval(function() {
                playSound(sounds[Math.floor(Math.random() * sounds.length)]);
            }, parseInt($(this).data('cron-time')) * 60 * 1000);
            cron = true;
            $(this).addClass('cron-enabled').removeClass('cron-disabled');
        } else {
            clearInterval(interval);
            cron = false;
            $(this).addClass('cron-disabled').removeClass('cron-enabled');
        }
    });

    function playSound(path) {
        createjs.Sound.stop();

        // register sound if it is not
        if (false === createjs.Sound.loadComplete(path)) {
            createjs.Sound.registerSound(path);

            return;
        }

        doPlay(path);
    }

    function doPlay(path) {
        createjs.Sound.play(path, {
            interrupt: createjs.Sound.INTERRUPT_ANY,
            volume: 1
        });
    }
});
