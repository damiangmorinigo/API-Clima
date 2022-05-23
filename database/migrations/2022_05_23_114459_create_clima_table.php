<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClimaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clima', function (Blueprint $table) {
            $table->id();
            $table->string('query') ->comment('Query con la que el usuario realiza en la petición'); 
            $table->string('queryAPI') ->comment('Query que es devuelta por en End Point');
            $table->string('type');
            $table->string('name');
            $table->string('country');
            $table->string('region');
            $table->string('latitud');  
            $table->string('longitud');
            $table->string('timezone_id');
            $table->integer('temperature');
            $table->integer('weather_code'); 
            $table->string('weather_icons'); 
            $table->string('weather_descriptions'); 
            $table->integer('wind_speed'); 
            $table->integer('wind_degree'); 
            $table->string('wind_dir'); 
            $table->integer('pressure'); 
            $table->double('precip'); 
            $table->double('humidity'); 
            $table->double('cloudcover'); 
            $table->double('feelslike'); 
            $table->double('uv_index'); 
            $table->double('visibility');
            $table->string('is_day');         
            $table->Time('hora_consulta');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('clima');
    }
}
