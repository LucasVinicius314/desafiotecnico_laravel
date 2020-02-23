<?php

namespace App\Http\Controllers;

use App\Deputado;
use App\RedeSocial;
use App\VerbaIndenizatoria;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;

class PopulateController extends Controller
{
    function RedesSociaisRequest()
    {
        // Iniciar curl
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "http://dadosabertos.almg.gov.br/ws/deputados/lista_telefonica?formato=json",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_CUSTOMREQUEST => "GET"
        ));

        // Executar curl
        $redes_sociais_response = curl_exec($curl);

        curl_close($curl);

        return json_decode($redes_sociais_response);
    }

    function InserirDeputado($redes_sociais_response)
    {
        foreach ($redes_sociais_response->list as $value) {

            Deputado::create($columns = [
                'id' => $value->id,
                'nome' => $value->nome,
                'nomeServidor' => $value->nomeServidor,
                'partido' => $value->partido,
                'email' => $value->email
            ]);

            foreach ($value->redesSociais as $rede_social) {

                RedeSocial::create($columns = [
                    'nome' => $rede_social->redeSocial->nome,
                    'url' => $rede_social->redeSocial->url,
                    'deputados_id' => $value->id
                ]);
            }
        }
    }

    function GerarListaURL($meses)
    {
        // Retornar lista de todos os deputados
        $deputados = Deputado::all($columns = [
            'id'
        ]);

        $temp_array = [];

        // Montar lista de links
        foreach ($meses as $value1) {

            foreach ($deputados as $value2) {

                array_push($temp_array, array(
                    'url' => 'http://dadosabertos.almg.gov.br/ws/prestacao_contas/verbas_indenizatorias/legislatura_atual/deputados/' . $value2->id . '/2019' . '/' . $value1 . '?formato=json',
                    'id' => $value2->id,
                    'mes' => $value1
                ));
            }
        }

        return $temp_array;
    }

    function MultiRequest($lista_URL)
    {
        $temp_array = [];

        // Iniciar curl
        foreach ($lista_URL as $key => $value) {

            array_push($temp_array, array(
                'curl' => curl_init($value['url']),
                'id' => $value['id'],
                'mes' => $value['mes']
            ));

            curl_setopt($temp_array[$key]['curl'], CURLOPT_RETURNTRANSFER, true);
        }

        // Preparar curl_multi
        $multi_URL = curl_multi_init();

        foreach ($temp_array as $value) curl_multi_add_handle($multi_URL, $value['curl']);

        $running = null;

        // Executar curl
        do {
            curl_multi_exec($multi_URL, $running);
        } while ($running);

        foreach ($temp_array as $key => $value) curl_multi_remove_handle($multi_URL, $value['curl']);

        curl_multi_close($multi_URL);

        return $temp_array;
    }

    function InserirVerbas($meses)
    {
        $lista_URL = PopulateController::GerarListaURL($meses);

        // Recuperar informações das verbas através da API usando curl
        $verbas_response = PopulateController::MultiRequest($lista_URL);

        // Inserir informações das verbas no banco de dados
        foreach ($verbas_response as $key => $value) {

            // Decodificar dados
            $conteudo = json_decode(curl_multi_getcontent($verbas_response[$key]['curl']));

            if ($conteudo == null) continue;

            foreach ($conteudo->list as $value) {

                if ($value->idDeputado == null) continue;

                try {
                    // Inserir verbas no banco
                    VerbaIndenizatoria::create($columns = [
                        'nome' => DB::select("select nome from deputados where id = $value->idDeputado")[0]->nome,
                        'mes' => $verbas_response[$key]['mes'],
                        'idDeputado' => $verbas_response[$key]['id']
                    ]);
                } catch (QueryException $ex) {

                    //

                }
            }
        }
    }

    public function index()
    {
        // Recuperar informações das redes sociais através da API usando curl
        $redes_sociais_response = PopulateController::RedesSociaisRequest();

        // Inserir informações dos deputados e redes sociais no banco de dados
        PopulateController::InserirDeputado($redes_sociais_response);

        // Inserir informações das verbas no banco de dados para o mes 4
        PopulateController::InserirVerbas([4]); // altere o valor para mudar os meses buscados:
                                                // [4]    => abril
                                                // [5]    => maio
                                                // [4, 5] => abril e maio

        return response('Sucesso.', 200);
    }
}
