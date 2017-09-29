<?php

require __DIR__.'/vendor/autoload.php';

use BAB\Player;
use BAB\Utils;

$player = new Player();
$files = $player->findAll();
sort($files);

?>

<html>
<head>
    <title>La boite à beauf</title>

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="assets/lib/basscss.min.css">
    <link rel="stylesheet" href="assets/style.css?v=<?php echo uniqid(); ?>">
</head>
<body>
    <div class="mx-auto max-width-5">
        <div class="flex flex-wrap px2">
            <div id="upload-message" class="col-12"></div>
            <div class="col-6 sm-col-3 md-col-2 flex items-center justify-start">
                <button id="button-random" type="button" class="js-play-random justify-center bold">Random</button>
            </div>
            <div class="col-6 sm-col-3 md-col-2 flex items-center justify-start">
                <button id="button-record" type="button" class="justify-center bold">Enregistrer</button>
            </div>
            <div class="col-12 sm-col-6 md-col-5">
                <h1 class="px2 py3">La boite à beauf</h1>
            </div>
            <div class="col-12 md-col-3 flex items-center">
                <input id="search" class="js-search py2 px1" placeholder="Chercher..." autofocus>
            </div>
        </div>
        <div class="flex flex-wrap">
            <?php foreach ($files as $file) : ?>
                <div class="col-6 md-col-4 lg-col-3 border-box wrap">
                    <a href="#" class="js-play btn-sound bold text-decoration-none center block flex items-center justify-center" data-sound="<?php echo Utils::getPublicPath($file); ?>">
                        <span><?php echo Utils::humanizePath($file); ?></span>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <div id="record-modal" class="modal">
        <div class="modal-content">
            <div class="flex flex-wrap">
                <div class="col-12 border-box">
                    <h3>Enregistrer un son</h3>
                </div>
                <div class="col-6 border-box px2">
                    <a href="#" id="start" class="flex items-center center block justify-center">Start</a>
                </div>
                <div class="col-6 border-box wrap">
                    <a href="#" id="stop" class="flex items-center center block justify-center">Stop</a>
                </div>
                <div class="col-12 border-box wrap">
                    <label for="sound-name" class="bold">Nom du fichier</label>
                    <input id="sound-name" placeholder="Nom du fichier">
                </div>
                <div class="col-12 border-box wrap">
                    <a href="#" id="upload" class="flex items-center center justify-center">Upload</a>
                </div>
                <span class="modal-close" title="Fermer">&times;</span>
                <div id="recording" class="col-12">
                    Recording
                    <img src="assets/recording.gif">
                </div>
            </div>
        </div>
    </div>

    <script src="assets/lib/jquery-3.2.1.min.js"></script>
    <script src="assets/lib/soundjs-0.6.2.min.js"></script>
    <script src="assets/play.js"></script>
    <script src="assets/record.js"></script>
</body>
</html>
