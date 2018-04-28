$(function() {
    $(document).on('click', '.js-play', function(e) {
        e.preventDefault();
        playSoundOnPi($(this).data('sound'));
    });

    $('.js-play-random').on('click', function (e) {
        e.preventDefault();
        playSoundOnPi(sounds[Math.floor(Math.random() * sounds.length)]);
    });

    function playSoundOnPi(sound) {
        $.ajax({
            url: $('#sound-container').data('player-url'),
            type: 'POST',
            dataType: 'json',
            data: {
                sound: sound
            }
        }).done(function(result) {
            if (true === result.success) {
                notify('success', 'Success');
            } else {
                notify('error', result.message);
            }
        });
    }
});
