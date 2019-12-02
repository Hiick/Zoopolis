<?php

namespace App\Controller;

use App\Entity\Admin;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use App\Controller\BaseController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class LandingPageController extends BaseController {

    public function start(): Response {
        return $this->render('LandingPage/base.html.twig');
    }

    public function createAdmin(Request $request, UserPasswordEncoderInterface $encoder): Response {
        $content = $request->getContent();

        if (!empty($content)) {
            $params = json_decode($content, true);

            $admin = new Admin();
            $admin->setFirstname($params['firstname']);
            $admin->setLastname($params['lastname']);
            $admin->setEmail($params['email']);
            $admin->setRole($params['role']);
            $hash = $encoder->encodePassword($admin, $params['password']);
            $admin->setPassword($hash);

            $em = $this->getDoctrine()->getManager();
            $em->persist($admin);
            $em->flush();
        }

        return $this->responseApi([
            "data" => json_decode($content, true)
        ], 200);
    }
}