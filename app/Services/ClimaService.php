<?php

namespace app\Services;

use App\Models\clima;
use Illuminate\Support\Facades\DB;

class ClimaService
{

    public function ConsultarCima($query)
    {      

           $hora_actual = date("H:00");  //HORA ACTUAL DE CONSULTA
           //DE CUMPLIRSE ESTA CONDICIÓN SOLO DEBO CONSULTAR A LA BASE DE DATOS Y NO A AL END POINT EXTERNO
           if (DB::table('clima')->where('query', $query) -> whereTime('hora_consulta',$hora_actual )->exists()) { 

              $tablaClima = DB::table('clima')->where('query', $query)->whereTime('hora_consulta',$hora_actual )
              ->select(
                    'queryAPI as query',
                    'type',
                    'name',
                    'country',
                    'region',
                    'latitud',
                    'longitud',
                    'timezone_id' ,
                    'temperature',
                    'weather_code',
                    'weather_icons',
                    'weather_descriptions',
                    'wind_speed',
                    'wind_degree',
                    'wind_dir',
                    'pressure',
                    'precip',
                    'humidity',
                    'cloudcover',
                    'feelslike' ,
                    'uv_index',
                    'visibility',
                    'is_day',
            )
             -> get();
            
             return $tablaClima;

           }else{
              
                $curl = curl_init();
                $access_key = env('API_ACCESS_KEY');
                curl_setopt_array($curl, array(
                CURLOPT_URL => 'http://api.weatherstack.com/current?access_key='. $access_key . '&query='. $query,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'GET',
                ));
    
                $response = curl_exec($curl);
                $responseData = json_decode($response, TRUE);	
                $statusRequest = curl_getinfo($curl);
            
                if ($statusRequest['http_code'] == 200) {
                    //##############################################################
                    if($responseData['success'] == false){ //DE CUMPLIRSE ESTA CONDICIÓN QUIERE DECIR QUE NO SE ENCONTARON COINCIDENCIAS
                        return $responseData;
                    }
                    
                    $data=array(); 
                    $data['queryAPI'] = $responseData['request']['query']; 
                    $data['query'] = $query; 
                    $data['type'] = $responseData['request']['type']; 
                    $data['name'] = $responseData['location']['name']; 
                    $data['country'] = $responseData['location']['country']; 
                    $data['region'] = $responseData['location']['region']; 
                    $data['latitud'] = $responseData['location']['lat'];
                    $data['longitud'] = $responseData['location']['lon'];
                    $data['timezone_id'] = $responseData['location']['timezone_id'];
                    $data['temperature'] = $responseData['current']['temperature'];
                    $data['weather_code'] = $responseData['current']['weather_code'];
                    $data['weather_icons'] = $responseData['current']['weather_icons'][0]; 
                    $data['weather_descriptions'] = $responseData['current']['weather_descriptions'][0];
                    $data['wind_speed'] = $responseData['current']['wind_speed'];
                    $data['wind_degree'] = $responseData['current']['wind_degree'];     
                    $data['wind_dir'] = $responseData['current']['wind_dir'];
                    $data['pressure'] = $responseData['current']['pressure'];
                    $data['precip'] = $responseData['current']['precip'];
                    $data['humidity'] = $responseData['current']['humidity'];
                    $data['cloudcover'] = $responseData['current']['cloudcover'];
                    $data['feelslike'] = $responseData['current']['feelslike'];
                    $data['uv_index'] = $responseData['current']['uv_index'];
                    $data['visibility'] = $responseData['current']['visibility'];
                    $data['is_day'] = $responseData['current']['is_day'];   
                    $data['created_at']  = DB::raw('CURRENT_TIMESTAMP'); 
                    $data['hora_consulta']  =$hora_actual;       
                    
                    DB::beginTransaction();
                    try{
                               
                        DB::table('clima')->insert($data);
                        DB::commit();
         
                    }catch (Throwable $e)
                    {
                            DB::rollback();
                            return response()->json("ERROR => ERROR INTERNAL SERVER", 500);
                    }
                     //elimino el dato para no mostrarlo en la respuesta
                     unset($data['queryAPI']); unset($data['created_at']); unset($data['hora_consulta']);
                     $data['query'] = $responseData['request']['query'];
                     return $data;
                    //##############################################################
                } else {
                
                    return curl_error($curl);
                }
    
                curl_close($curl);
    
            }
    }


}