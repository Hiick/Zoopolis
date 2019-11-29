<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BaseController extends AbstractController {

    public function responseApi($data, int $statusCode = 200): Response {
        $retourData = json_encode($data);
        return new Response($retourData, $statusCode, [
            'Content-type' => 'application/json'
        ]);
    }

}