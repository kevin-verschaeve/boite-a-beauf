$(function() {
    // play sound when it is registered
    createjs.Sound.on('fileload', function(e) {
        createjs.Sound.play(e.src);
    }, this);

    // register or play sound on button click
    $('.js-play').on('click', function(e) {
        e.preventDefault();
        var path = $(this).data('sound');

        playSound(path);
    });

    $('.js-play-random').on('click', function (e) {
        // get all sounds list
        var sounds = $('.js-play').map(function() {
            return $(this).data('sound');
        }).get();

        // play array rand
        playSound(sounds[Math.floor(Math.random() * sounds.length)]);
    });

    function playSound(path) {
        createjs.Sound.stop();

        // register sound if it is not
        if (false === createjs.Sound.loadComplete(path)) {
            createjs.Sound.registerSound(path);

            return;
        }

        createjs.Sound.play(path, {
            interrupt: createjs.Sound.INTERRUPT_ANY,
            volume: 1
        });
    }
});
