<?php

namespace App\Controller;

use App\Entity\Admin;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use App\Controller\BaseController;

class LandingPageController extends BaseController {

    public function start(): Response {
        return $this->render('LandingPage/base.html.twig');
    }

    public function createAdmin(EntityManagerInterface $em, Request $request): Response {
        $content = $request->getContent();

        if (!empty($content)) {
            $params = json_decode($content, true);

            $admin = new Admin();
            $admin->setFirstname($params['firstname']);
            $admin->setLastname($params['lastname']);
            $admin->setEmail($params['email']);
            $admin->setRole($params['role']);
            $admin->setPassword($params['password']);

            $em = $this->getDoctrine()->getManager();
            $em->persist($admin);
            $em->flush();
        }

        return $this->responseApi([
            "data" => json_decode($content, true)
        ], 200);
    }

    public function login() {
        return $this->render('LandingPage/test.html.twig');
    }
}