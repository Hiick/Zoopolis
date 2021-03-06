<?php

namespace App\Controller;

use App\Entity\Main\Admin;
use App\Entity\Secondary\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Validator\Constraints\Date;

class UsersController extends BaseController {

    /**
     * @Route("/admin/users", name="users")
     */
    public function start(): Response {
        return $this->render('Dashboard/Users/base.html.twig');
    }

    public function addUserForm(): Response {
        return $this->render('Dashboard/Add-user/base.html.twig');
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

    public function getAllActiveUsers(EntityManagerInterface $entityManager): Response {
        $entityManager = $this->getDoctrine()->getManager('customer');
        $listUsers = $entityManager->getRepository(User::class)->getAllActiveUsers();
        return $this->responseApi([
            $listUsers[0][1],
        ]);
    }

    public function getByAges(EntityManagerInterface $entityManager): Response {
        $entityManager = $this->getDoctrine()->getManager('customer');
        $listUsers = $entityManager->getRepository(User::class)->getByAges();

        $list_final = [];

        for ($i = 0; $i < count($listUsers); $i++) {
            array_push($list_final, $listUsers[$i]["COUNT(*)"]);
        }

        return $this->responseApi($list_final);
    }

    public function listUsers(EntityManagerInterface $entityManager, Request $request): Response {
        $entityManager = $this->getDoctrine()->getManager('customer');

        $content = $request->getContent();

        $params = json_decode($content, true);
        $record_per_page = 10;
        $page=$params["page"];
        $start_from = ($page - 1)*$record_per_page;
        $listUsers = $entityManager->getRepository(User::class)->listUsers($start_from, $record_per_page);

        return $this->responseApi($listUsers);

    }

    public function listUsersDesc(EntityManagerInterface $entityManager, Request $request): Response {
        $entityManager = $this->getDoctrine()->getManager('customer');

        $content = $request->getContent();

        $params = json_decode($content, true);
        $record_per_page = 10;
        $page=$params["page"];
        $start_from = ($page - 1)*$record_per_page;
        $listUsers = $entityManager->getRepository(User::class)->listUsersDesc($start_from, $record_per_page);

        return $this->responseApi($listUsers);

    }

    public function countListUsers(EntityManagerInterface $entityManager, Request $request): Response {
        $entityManager = $this->getDoctrine()->getManager('customer');
        $listUsers = $entityManager->getRepository(User::class)->countListUsers();
        return $this->responseApi($listUsers);
    }

    public function deleteUser(EntityManagerInterface $entityManager): Response {
        $entityManager = $this->getDoctrine()->getManager('customer');
        $listUsers = $entityManager->getRepository(User::class)->countListUsers();
        return $this->responseApi($listUsers);
    }

    public function getId(EntityManagerInterface $entityManager): Response {
        $entityManager = $this->getDoctrine()->getManager('customer');
        $listUsers = $entityManager->getRepository(User::class)->getId();
        return $this->responseApi($listUsers);
    }

    public function newUser(EntityManagerInterface $entityManager, UserPasswordEncoderInterface $encoder, Request $request): Response {
        $content = $request->getContent();

        if (!empty($content)) {
            $params = json_decode($content, true);

            $user = new User();
            $user->setFirstname($params['firstname']);
            $user->setLastname($params['lastname']);
            $user->setEmail($params['email']);
            $user->setSexe($params['sexe']);
            $user->setBirthday($params['birthday']);
            $user->setCity($params['city']);
            $user->setZip($params['zip']);
            $user->setStreet($params['address']);
            $hash = $encoder->encodePassword($user, $params['password']);
            $user->setPassword($hash);
            $user->setCreatedat(new \DateTime());
            $user->setUpdetedat(new \DateTime());

            $entityManager = $this->getDoctrine()->getManager('customer');
            $entityManager->persist($user);
            $entityManager->flush();
        }

        return $this->responseApi([
            "data" => json_decode($content, true)
        ], 200);
    }

}