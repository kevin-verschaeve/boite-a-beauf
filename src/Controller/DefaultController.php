<?php

namespace BAB\Controller;

use BAB\Manager\SoundManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DefaultController
{
    private $twig;
    private $soundManager;

    public function __construct(\Twig_Environment $twig, SoundManager $soundManager)
    {
        $this->twig = $twig;
        $this->soundManager = $soundManager;
    }

    public function __invoke(Request $request)
    {
        return new Response($this->twig->render('default/index.html.twig', [
            'sounds' => $this->soundManager->findAll(),
            'onPi' => $request->query->getBoolean('pi', false),
        ]));
    }
}
