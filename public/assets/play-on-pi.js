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
                $('#result-message').append($('<p/>', {
                    'class': 'alert success',
                    text: 'Success'
                })).fadeIn(1000).fadeOut({
                    duration: 4000,
                    complete: function() {
                        $('.alert').remove();
                    }
                });
            } else {
                $('#result-message').append($('<p/>', {
                    'class': 'alert error',
                    text: result.message
                })).fadeIn(1000).fadeOut({
                    duration: 4000,
                    complete: function() {
                        $('.alert').remove();
                    }
                });
            }
        });
    }
});
