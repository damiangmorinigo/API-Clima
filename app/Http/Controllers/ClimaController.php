<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\clima;
use DB;
use App\Services\ClimaService;

class ClimaController extends Controller
{
    //

   /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * return \Illuminate\Http\JsonResponse
     * @return \Illuminate\Http\Response 
     */
    public function obtenerClima(Request $request, ClimaService $ClimaService)
    {

      /*$request->validate([
        'query' => 'required',
      ],
      [
        'query.required' => '(*) La query es requerida. Debe ingresarla.',
      ]);  */
      
      $data=array();
      $consulta = strtolower($request->input('query'));

      if($consulta == ""){   
        $data['ERROR'] = "Debe ingresarse la Query.";
        return response()->json($data['ERROR'], 403);
      }

      $ClimaResponse = $ClimaService->ConsultarCima($consulta);
      return response()->json($ClimaResponse, 200);

    }
}
