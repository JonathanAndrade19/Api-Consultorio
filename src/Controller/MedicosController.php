<?php

namespace App\Controller;

use App\Entity\Medico;
use App\Helper\ExtratorDadosRequest;
use App\Helper\MedicoFactory;
use App\Repository\MedicosRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\Id;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class MedicosController extends BaseController
{
    public function __construct(EntityManagerInterface $entityManager,
                                MedicoFactory $medicoFactory,
                                MedicosRepository $medicosRepository,
                                ExtratorDadosRequest $extratorDadosRequest)
    {
        parent::__construct($medicosRepository, $entityManager, $medicoFactory, $extratorDadosRequest);
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

    /**
     * @param Medico $entidadeExistente
     * @param Medico $entidadeEnviada
     */
    public function atualizarEntidadeExixtente($entidadeExistente, $entidadeEnviada)
    {
        $entidadeExistente
            ->setCrm($entidadeEnviada->getCrm())
            ->setNome($entidadeEnviada->getNome())
            ->setEspecialidade($entidadeEnviada->getEspecialidade());
    }

}