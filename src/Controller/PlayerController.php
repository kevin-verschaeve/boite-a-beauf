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
    private $authorizedIps;

    public function __construct(string $secret, array $authorizedIps)
    {
        $this->secret = $secret;
        $this->authorizedIps = $authorizedIps;
    }

    public function __invoke(Request $request, Player $player)
    {
        if (!(\in_array($request->getClientIp(), $this->authorizedIps, true) || $this->secret === $request->request->get('secret'))) {
            throw new NotFoundHttpException('This page does not exists.');
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
