<?php

namespace BAB\Controller;

use BAB\Service\Player;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class PlayerController
{
    public function __invoke(Request $request, Player $player)
    {
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
