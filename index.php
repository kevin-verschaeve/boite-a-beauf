<?php

require __DIR__.'/vendor/autoload.php';

use BAB\Player;
use BAB\Utils;

$player = new Player();
$files = $player->findAll();

?>

<html>
<head>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <h1>La boite a beauf</h1>
    <ul>
        <?php foreach ($files as $file) : ?>
        <li>
            <a href="#" class="js-play" data-sound="<?php echo Utils::getPublicPath($file); ?>">
                <?php echo Utils::humanizePath($file); ?>
            </a>
        </li>
        <?php endforeach; ?>
    </ul>

    <script src="assets/lib/jquery-3.2.1.slim.min.js"></script>
    <script src="assets/lib/soundjs-0.6.2.min.js"></script>
    <script src="assets/play.js"></script>
</body>
</html>
