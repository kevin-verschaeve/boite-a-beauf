<?php

namespace BAB\Controller;

use BAB\Service\Finder;
use Symfony\Component\HttpFoundation\Response;

class DefaultController
{
    /** @var \Twig_Environment */
    private $twig;

    /** @var Finder */
    private $finder;

    public function __construct(\Twig_Environment $twig, Finder $finder)
    {
        $this->twig = $twig;
        $this->finder = $finder;
    }

    public function __invoke()
    {
        return new Response($this->twig->render('default/index.html.twig', [
            'sounds' => $this->finder->findAll(),
        ]));
    }
}
