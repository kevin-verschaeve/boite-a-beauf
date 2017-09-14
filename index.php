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
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <div class="mx-auto max-width-5">
        <div class="flex flex-wrap">
            <div class="col-12 sm-col-6 md-col-3 flex items-center justify-start pl2">
                <button id="button-random" type="button" class="js-play-random justify-center bold">Random</button>
            </div>
            <div class="col-12 sm-col-6">
                <h1 class="px2 py3">La boite à beauf</h1>
            </div>
        </div>
        <div class="flex flex-wrap">
            <?php foreach ($files as $file) : ?>
                <div class="col-6 md-col-4 lg-col-3 border-box wrap">
                    <a href="#" class="js-play bold text-decoration-none center block flex items-center justify-center" data-sound="<?php echo Utils::getPublicPath($file); ?>">
                        <span><?php echo Utils::humanizePath($file); ?></span>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <script src="assets/lib/jquery-3.2.1.min.js"></script>
    <script src="assets/lib/soundjs-0.6.2.min.js"></script>
    <script src="assets/play.js"></script>
</body>
</html>
