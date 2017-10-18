<?php

namespace BAB\Controller;

use BAB\Manager\SoundManager;
use BAB\Model\Sound;
use BAB\Service\Finder;
use Symfony\Component\HttpFoundation\Response;

class DefaultController
{
    /** @var \Twig_Environment */
    private $twig;

    /** @var SoundManager */
    private $soundManager;

    public function __construct(\Twig_Environment $twig, SoundManager $soundManager)
    {
        $this->twig = $twig;
        $this->soundManager = $soundManager;
    }

    public function __invoke()
    {
        return new Response($this->twig->render('default/index.html.twig', [
            'sounds' => $this->soundManager->findAll(),
        ]));
    }
}
