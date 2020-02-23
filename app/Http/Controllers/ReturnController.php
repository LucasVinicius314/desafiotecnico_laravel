<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class ReturnController extends Controller
{
    function RetornarRedesSociais($redes_sociais)
    {
        // Converter mês para integer
        foreach ($redes_sociais as $key => $value) $redes_sociais[$key] = (int) $value;

        return json_encode($redes_sociais);
    }

    function OrdenarRedesSociais($redes_sociais)
    {
        $temp_array = [];

        // Montar lista
        foreach ($redes_sociais as $value) $temp_array[$value->nome] = DB::select("select count(*) from rede_socials where nome = '$value->nome'")[0]->{'count(*)'};

        // Organizar lista
        arsort($temp_array);

        return $temp_array;
    }

    function ranking()
    {
        // Montar e organizar a lista de todas as redes sociais usadas
        $redes_sociais = DB::select("select distinct nome from rede_socials");

        $redes_sociais = ReturnController::OrdenarRedesSociais($redes_sociais);

        // Retornar redes sociais
        return ReturnController::RetornarRedesSociais($redes_sociais);
    }

    function Ordenar_Verbas($verbas)
    {
        $temp_array = [];

        // Montar lista
        foreach ($verbas as $value) array_push($temp_array, array(
            'idDeputado' => (int) $value->idDeputado,
            'nome' => DB::select("select nome from verba_indenizatorias where idDeputado = '$value->idDeputado';")[0]->nome,
            'quantidade' => (int) DB::select("select count(*) from verba_indenizatorias where idDeputado = '$value->idDeputado'")[0]->{'count(*)'}
        ));

        // Organizar lista
        usort($temp_array, function ($a, $b) {
            return $a['quantidade'] < $b['quantidade'];
        });

        return $temp_array;
    }

    function RetornarVerbas($verbas)
    {
        // Selecionar os primeiros 5 itens da lista
        $verbas = array_slice($verbas, 0, 5);

        return json_encode($verbas);
    }

    function reembolso()
    {
        // Montar e organizar a lista de verbas
        $verbas = DB::select("select distinct idDeputado from verba_indenizatorias");

        $verbas = ReturnController::Ordenar_Verbas($verbas);

        // Retornar verbas
        return json_decode(ReturnController::RetornarVerbas($verbas));
    }
}
