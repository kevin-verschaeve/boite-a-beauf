<?php

if (!isset($_FILES['sound'])) {
    die(json_encode(['success' => false, 'message' => 'Rien à uploader']));
}

$uploaded = move_uploaded_file($_FILES['sound']['tmp_name'], 'sounds/records/'.$_FILES['sound']['name']);

if (false === $uploaded) {
    die(json_encode(['success' => false, 'message' => 'Une erreur est survenue pendant l\'upload']));
}

die(json_encode(['success' => true, 'message' => 'Fichier uploadé !']));
