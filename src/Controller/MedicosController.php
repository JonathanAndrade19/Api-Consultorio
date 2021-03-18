<?php
/**
 * Created by PhpStorm.
 * User: jonathan
 * Date: 17/03/21
 * Time: 23:48
 */

namespace App\Controller;


use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MedicosController
{
    /**
     *@Route("/medicos")
     **/
    public function novo(Request $request): Response
    {
        $corpoRequisicao = $request->getContent();

         return new Response($corpoRequisicao);
    }
}