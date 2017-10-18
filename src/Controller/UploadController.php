<?php

namespace BAB\Controller;

use BAB\Builder\SoundBuilder;
use BAB\Manager\SoundManager;
use BAB\Model\Sound;
use BAB\Service\Finder;
use BAB\Service\Utils;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class UploadController
{
    const RECORDS_DIR = '/sounds/records';

    /** @var SoundManager*/
    private $soundManager;

    /** @var \Twig_Environment */
    private $twig;

    /** @var string */
    private $publicPath;

    public function __construct(SoundManager $soundManager, \Twig_Environment $twig, string $publicPath)
    {
        $this->soundManager = $soundManager;
        $this->twig = $twig;
        $this->publicPath = $publicPath;
    }

    public function __invoke(Request $request)
    {
        /** @var UploadedFile $file */
        $file = $request->files->get('sound');

        if (null === $file) {
            return new JsonResponse(['success' => false, 'message' => 'Rien à uploader']);
        }

        try {
            $new = $file->move($this->publicPath.self::RECORDS_DIR, $file->getClientOriginalName());

            $sound = new Sound();
            $sound->label = $new->getBasename('.'.$new->getExtension());
            $sound->publicPath = self::RECORDS_DIR.'/'.$new->getBasename();
            $sound->isRecord = true;

            $this->soundManager->insert($sound);

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
