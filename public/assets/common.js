$(function() {
    // get all sounds
    window.sounds = $('.js-play').map(function() {
        return $(this).data('sound');
    }).get();

    $('.js-search').on('keyup', function() {
        let search = $(this).val();
        let sound = '';

        $('.wrap').show();
        $('.js-play').each(function() {
            let _this = $(this);
            sound = _this.text().trim();
            if (sound.toLocaleLowerCase().indexOf(search.toLowerCase()) < 0) {
                _this.parents('.wrap').hide();
            }
        });
    });

    window.notify = function(type, message) {
        $('#result-message').append($('<p/>', {
            'class': 'alert ' + type,
            text: message
        })).fadeIn(1000).fadeOut({
            duration: 4000,
            complete: function() {
                $('.alert').remove();
            }
        });
    }
});
