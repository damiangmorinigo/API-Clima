<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class clima extends Model
{
    use HasFactory;
    protected $table = "clima";

    // Atributos que se pueden asignar de manera masiva.
    protected $fillable = [
      'query',
      'queryAPI',
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
      
    ]; 

      // Aquí ponemos los campos que no queremos que se devuelvan en las consultas.
	    protected $hidden = ['created_at','updated_at']; 
}
