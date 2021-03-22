<?php

namespace App\Controller;

use App\Entity\Medico;
use App\Helper\MedicoFactory;
use App\Repository\MedicosRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\Id;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MedicosController extends BaseController
{
    public function __construct(EntityManagerInterface $entityManager,
                                MedicoFactory $medicoFactory,
                                MedicosRepository $medicosRepository)
    {
        parent::__construct($medicosRepository, $entityManager, $medicoFactory);
    }

    /**
     * @Route("/medicos/{id}", methods={"PUT"})
     */
    public function atualiza(int $id, Request $request): Response
    {
        $corpoRequisicao = $request->getContent();
        $medicoEnviado = $this->medicoFactory->criarMedico($corpoRequisicao);

        $medicoExistente = $this->buscaMedico($id);

        if (is_null($medicoExistente)) {
            return new Response('', Response::HTTP_NOT_FOUND);
        }

        $medicoExistente->setCrm($medicoEnviado->getCrm())
                        ->serNome( $medicoEnviado->getNome());

        $this->entityManager->flush();

        return new JsonResponse($medicoExistente);
    }
    
    /**
     * @param int $id
     * @return object|null
     */
    public function buscaMedico(int $id)
    {

        $medico = $this->repository->find($id);
        return $medico;
    }

    /**
     * @Route("/especialidades/{especialidadeId}/medicos/", methods={"GET"})
     */
    public function buscarPorEspecialidade(int $especialidadeId): Response
    {

        $medicos = $this->repository->findBy([
            'especialidade' => $especialidadeId
        ]);

        return new JsonResponse($medicos);
    }

}