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
});
