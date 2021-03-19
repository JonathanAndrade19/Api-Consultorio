<?php


namespace App\Controller;
use Symfony\Component\Routing\Annotation\Route;


class OlaMundoController
{
    /**
     * @Route("/cursoSymfony")
     */
    public function olaMundoAction() {

        echo 'Olá Mundo! ';
        echo 'Curso de Symfony, Doctrine, Routes, Migrations, Entre outros;';
        exit();
    }
}