$(function() {
    $(document).on('click', '.js-play', function(e) {
        e.preventDefault();

        $.ajax({
            url: $('#sound-container').data('player-url'),
            type: 'POST',
            dataType: 'json',
            data: {
                sound: $(this).data('sound')
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
    });
});
