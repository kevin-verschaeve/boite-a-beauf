<?php

namespace BAB\Controller;

use BAB\Uploader\SoundUploader;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Twig\Environment;

class UploadController
{
    private $twig;
    private $soundUploader;

    public function __construct(Environment $twig, SoundUploader $soundUploader)
    {
        $this->twig = $twig;
        $this->soundUploader = $soundUploader;
    }

    public function __invoke(Request $request)
    {
        /** @var UploadedFile $file */
        $file = $request->files->get('sound');

        if (null === $file) {
            return new JsonResponse(['success' => false, 'message' => 'Rien à uploader']);
        }

        try {
            $sound = $this->soundUploader->upload($file);

            return new JsonResponse([
                'success' => true,
                'message' => 'Fichier uploadé !',
                'html' => $this->twig->render('upload/sound_button.html.twig', [
                    'sound' => $sound,
                ]),
            ]);
        } catch (FileException $e) {
            return new JsonResponse(['success' => false, 'message' => $e->getMessage()]);
        }
    }
}
