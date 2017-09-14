$(function() {
    // play sound when it is registered
    createjs.Sound.on('fileload', function(e) {
        createjs.Sound.play(e.src);
    }, this);

    // get all sounds list
    var sounds = $('.js-play').map(function() {
        return $(this).data('sound');
    }).get();


    // register or play sound on button click
    $('.js-play').on('click', function(e) {
        e.preventDefault();
        playSound($(this).data('sound'));
    });

    $('.js-play-random').on('click', function (e) {
        e.preventDefault();
        // play array rand
        playSound(sounds[Math.floor(Math.random() * sounds.length)]);
    });

    $('.js-search').on('keyup', function() {
        var search = $(this).val();
        var sound = '';
        $('.wrap').show();
        $('.js-play').each(function() {
            let _this = $(this);
            sound = _this.text().trim();
            if (sound.toLocaleLowerCase().indexOf(search.toLowerCase()) < 0) {
                _this.parents('.wrap').hide();
            }
        });
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
