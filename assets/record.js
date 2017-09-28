$(function() {
    var $start = $('#start'),
        $stop = $('#stop'),
        $upload = $('#upload'),
        $recording = $('#recording'),
        $modal = $('#record-modal'),
        recorder,
        chunks = []
    ;

    $('#button-record').on('click', function(e) {
        e.preventDefault();
        $modal.show();
    });

    $('.modal-close').on('click', function(e) {
        e.preventDefault();
        $modal.hide();
    });

    $modal.on('click', function (e) {
        if ($(e.target).get(0) === $modal.get(0)) {
            $modal.hide();
        }
    });

    navigator.mediaDevices.getUserMedia({audio: true}).then(function(stream) {
        $start.on('click', startRecording);
        $stop.on('click', stopRecording);
        $upload.on('click', upload);

        recorder = new MediaRecorder(stream);
        recorder.addEventListener('dataavailable', doRecord);
    });

    function startRecording() {
        chunks = [];
        recorder.start();
        $recording.show();
    }

    function stopRecording() {
        if ('inactive' === recorder.state) {
            return;
        }

        recorder.stop();
        $recording.hide();
    }

    function doRecord(e) {
        chunks.push(e.data);
    }

    function upload() {
        stopRecording();
        doUpload();
    }

    function doUpload() {
        if (chunks.length === 0) {
            alert('Rien a uploader');

            return false;
        }

        var blob = new Blob(chunks, {type: 'audio/ogg'});
        var name = $('#sound-name').val();

        if (name.trim() === '') {
            alert('Met un nom connard !');

            return false;
        }

        var formData = new FormData();
        formData.append('sound', blob, name+'.ogg');

        $.post({
            url: 'upload.php',
            type: 'POST',
            data: formData,
            processData: false,
            cache: false,
            contentType: false
        }).done(function(data) {
            data = $.parseJSON(data);

            let cssClass = data.success === true ? 'success' : 'error';
            $('#upload-message').append($('<p/>', {
                'class': 'alert ' + cssClass,
                text: data.message
            })).fadeIn(1000).fadeOut({
                duration: 4000,
                complete: function() {
                    $('.alert').remove();
                }
            });

            $modal.hide();
        });
    }
});
