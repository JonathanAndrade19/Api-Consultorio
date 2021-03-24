<?php

namespace App\Helper;


use Symfony\Component\HttpFoundation\Request;

class ExtratorDadosRequest
{

    private function buscaDadosRequest(Request $request)
    {
        $queryString = $request->query->all();
        $dadosOrdenacao = array_key_exists('sort', $queryString)
            ? $queryString['sort']
            : null;
        unset($queryString['sort']);

    return [$queryString, $dadosOrdenacao];
    }
    
    public function buscarDadosOrdenacao(Request $request)
    {
        [, $ordenacao] = $this->buscaDadosRequest($request);

        return $ordenacao;
    }

    public function buscarDadosFiltro(Request $request)
    {
        [$filtro, ] = $this->buscaDadosRequest($request);

        return $filtro;
    }
}