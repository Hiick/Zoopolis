<?php

namespace App\Controller;

use App\Entity\Main\Admin;
use App\Entity\Secondary\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UsersController extends BaseController {

    /**
     * @Route("/admin/users", name="users")
     */
    public function start(): Response {
        return $this->render('Dashboard/Users/base.html.twig');
    }

    public function getMens(EntityManagerInterface $entityManager): Response {
        $entityManager = $this->getDoctrine()->getManager('customer');
        $listUsers = $entityManager->getRepository(User::class)->getBySexe('Homme');
        return $this->responseApi([
            $listUsers[0][1],
        ]);
    }

    public function getWomens(EntityManagerInterface $entityManager): Response {
        $entityManager = $this->getDoctrine()->getManager('customer');
        $listUsers = $entityManager->getRepository(User::class)->getBySexe('Femme');
        return $this->responseApi([
            $listUsers[0][1],
        ]);
    }

    public function getAllUsers(EntityManagerInterface $entityManager): Response {
        $entityManager = $this->getDoctrine()->getManager('customer');
        $listUsers = $entityManager->getRepository(User::class)->getAllUsers();
        return $this->responseApi([
            $listUsers[0][1],
        ]);
    }

}