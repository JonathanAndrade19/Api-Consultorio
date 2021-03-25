<?php

namespace App\Helper;


use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class ResponseFactory
{
    /**
     * @var bool
     */
    private $sucesso;
    /**
     * @var int
     */
    private $paginaAtual;
    /**
     * @var int
     */
    private $itensPorPagina;
    private $conteudoResposta;
    /**
     * @var int
     */
    private $statusResposta;

    public function __construct(bool $sucesso,
                                $conteudoResposta,
                                int $statusResposta = Response::HTTP_OK,
                                int $paginaAtual = null,
                                int $itensPorPagina = null)
    {

        $this->sucesso = $sucesso;
        $this->paginaAtual = $paginaAtual;
        $this->itensPorPagina = $itensPorPagina;
        $this->conteudoResposta = $conteudoResposta;
        $this->statusResposta = $statusResposta;
    }

    public function getResponse(): JsonResponse
    {
        $conteudoResposta = [
            'sucesso' => $this->sucesso,
            'paginalAtual' => $this->paginaAtual,
            'itensPorPagina' => $this->itensPorPagina,
            'conteudoResposta' => $this->conteudoResposta
        ];

        if (is_null($this->paginaAtual)){
            unset($conteudoResposta['paginalAtual']);
            unset($conteudoResposta['itensPorPagina']);
        }

        return new JsonResponse($conteudoResposta, $this->statusResposta);
    }
}