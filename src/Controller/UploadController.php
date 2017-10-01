<?php

namespace BAB\Controller;

use BAB\Builder\SoundBuilder;
use BAB\Service\Finder;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class UploadController
{
    /** @var Finder */
    private $finder;

    /** @var SoundBuilder */
    private $soundBuilder;

    /** @var \Twig_Environment */
    private $twig;

    public function __construct(Finder $finder, SoundBuilder $soundBuilder, \Twig_Environment $twig)
    {
        $this->finder = $finder;
        $this->soundBuilder = $soundBuilder;
        $this->twig = $twig;
    }

    public function __invoke(Request $request)
    {
        /** @var UploadedFile $file */
        $file = $request->files->get('sound');

        if (null === $file) {
            return new JsonResponse(['success' => false, 'message' => 'Rien à uploader']);
        }

        try {
            $new = $file->move($this->finder->getRecordsSoundsPath(), $file->getClientOriginalName());

            return new JsonResponse([
                'success' => true,
                'message' => 'Fichier uploadé !',
                'html' => $this->twig->render('upload/sound_button.html.twig', [
                    'sound' => $this->soundBuilder->buildSound($new->getRealPath())->get(),
                ]),
            ]);
        } catch (FileException $e) {
            return new JsonResponse(['success' => false, 'message' => $e->getMessage()]);
        }
    }
}
