<?php

namespace App\Controller;


use App\Helper\EntidadeFactory;
use App\Helper\ExtratorDadosRequest;
use App\Helper\ResponseFactory;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

abstract class BaseController extends AbstractController
{

    /**
     * @var ObjectRepository
     */
    protected $repository;
    protected $entityManager;
    /**
     * @var EntidadeFactory
     */
    protected $factory;
    /**
     * @var ExtratorDadosRequest
     */
    private $extratorDadosRequest;

    public function __construct(ObjectRepository $repository,
                                EntityManagerInterface $entityManager,
                                EntidadeFactory $factory,
                                ExtratorDadosRequest $extratorDadosRequest)
    {

        $this->repository = $repository;
        $this->entityManager = $entityManager;
        $this->factory = $factory;
        $this->extratorDadosRequest = $extratorDadosRequest;
    }

    public function novo(Request $request): Response
    {
        $dadosRequest = $request->getContent();
        $entidade = $this->factory->criarEntidade($dadosRequest);

        $this->entityManager->persist($entidade);
        $this->entityManager->flush();

        return new JsonResponse($entidade);

    }

    /**
     * @param Request $request
     * @return Response
     */
    public function buscarTodos(Request $request): Response
    {
        $filtro = $this->extratorDadosRequest->buscarDadosFiltro($request);
        $informacoesDeOrdenacao = $this->extratorDadosRequest->buscarDadosOrdenacao($request);

        [$paginaAtual, $itensPorPagina] = $this->extratorDadosRequest->buscaDadosPaginacao($request);
        $lista = $this->repository->findBy(
            $filtro,
            $informacoesDeOrdenacao,
            $itensPorPagina,
            ($paginaAtual - 1) * $itensPorPagina);

        $fabricaResposta = new ResponseFactory(
            true,
            $lista,
            Response::HTTP_OK,
            $paginaAtual,
            $itensPorPagina
        );
        return $fabricaResposta->getResponse();
    }

    public function buscarUm(int $id): Response
    {
        $entidade = $this->repository->find($id);
        $statusResposta = is_null($entidade) ? Response::HTTP_NO_CONTENT : Response::HTTP_OK;
        $fabricaResposta = new ResponseFactory(
            true,
            $entidade,
            $statusResposta
        );
        return $fabricaResposta->getResponse();
    }

    public function atualiza(int $id, Request $request): Response
    {
        $corpoRequisicao = $request->getContent();
        $entidadeEnviada = $this->factory->criarEntidade($corpoRequisicao);

        $entidadeExistente = $this->repository->find($id);

        if (is_null($entidadeExistente)) {
            return new Response('', Response::HTTP_NOT_FOUND);
        }

        $this->atualizarEntidadeExixtente($entidadeExistente, $entidadeEnviada);

        $this->entityManager->flush();

        return new JsonResponse($entidadeExistente);
    }

    public function remove(int $id): Response
    {
        $entidade = $this->repository->find($id);
        $this->entityManager->remove($entidade);
        $this->entityManager->flush();

        return new Response('',Response::HTTP_NO_CONTENT);
    }

    abstract public function atualizarEntidadeExixtente($entidadeExistente, $entidadeEnviada);

}