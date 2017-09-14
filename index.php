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
    <link rel="stylesheet" href="assets/lib/basscss.min.css">
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <div class="mx-auto max-width-4">
        <h1>La boite a beauf</h1>
        <div class="flex flex-wrap">
            <?php foreach ($files as $file) : ?>
                <div class="sm-col-6 md-col-4 border-box wrap">
                    <a href="#" class="js-play bold text-decoration-none center block" data-sound="<?php echo Utils::getPublicPath($file); ?>">
                        <?php echo Utils::humanizePath($file); ?>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <script src="assets/lib/jquery-3.2.1.slim.min.js"></script>
    <script src="assets/lib/soundjs-0.6.2.min.js"></script>
    <script src="assets/play.js"></script>
</body>
</html>
