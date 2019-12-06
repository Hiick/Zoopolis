<?php

namespace App\Controller;

use App\Entity\Secondary\Token;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TokensController extends BaseController {

    public function start(): Response {
        return $this->render('Dashboard/Tokens/base.html.twig');
    }

    public function connectionsByDays(EntityManagerInterface $entityManager, Request $request): Response {
        $entityManager = $this->getDoctrine()->getManager('customer');
        $content = $request->getContent();
        $params = json_decode($content, true);

        $listUsers = $entityManager->getRepository(Token::class)->connectionsByDays($params["day"]);
        return $this->responseApi([
            $listUsers[0]["COUNT(*)"],
        ]);
    }

}