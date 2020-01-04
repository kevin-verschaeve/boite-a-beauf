<?php

namespace BAB\Controller;

use BAB\Service\Player;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class PlayerController
{
    private $secret;

    public function __construct(string $secret)
    {
        $this->secret = $secret;
    }

    public function __invoke(Request $request, Player $player)
    {
        if (false === $request->isXmlHttpRequest() || $this->secret !== $request->request->get('secret')) {
            throw new NotFoundHttpException();
        }

        $sound = $request->request->get('sound');

        try {
            if (null === $sound) {
                $played = $player->playRandom();
            } else {
                $played = $player->playExact($sound);
            }
        } catch (\Exception $e) {
            return new JsonResponse(['success' => false, 'message' => $e->getMessage()]);
        }

        return new JsonResponse(['success' => true, 'message' => "Played $played"]);
    }
}
