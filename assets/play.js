$(function() {
    // play sound when it is registered
    createjs.Sound.on('fileload', function(e) {
        createjs.Sound.play(e.src);
    }, this);

    // register or play sound on button click
    $('.js-play').on('click', function(e) {
        e.preventDefault();
        var path = $(this).data('sound');

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
    });
});
