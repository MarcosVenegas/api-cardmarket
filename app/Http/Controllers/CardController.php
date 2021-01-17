<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \Firebase\JWT\JWT;

use App\Models\User;
use App\Models\Card;
use App\Models\Colection;

class cardController extends Controller
{
    //
	public function createCard(Request $request)
	{
		
		$response = "";
		$getHeaders = apache_request_headers ();
        $token = $getHeaders['Authorization'];
        $key = "25634qswy6dctjuvykuil9o8ui7y9tW6ETUIYOGBFjuytgvbUCVUIJ€tcuyvibgh867ui6yftvygcguti7565rtyfrduit68it";

        $decoded = JWT::decode($token, $key, array('HS256'));

        //primero verificamos que tiene permisos con su id de usuario
        $permiso = User::where('name', $decoded)->get()->first();

		if ($permiso->rol == "admin") {
			//Leer el contenido de la petición
			$data = $request->getContent();

			//Decodificar el json
			$data = json_decode($data);

			//Si hay un json válido, crear el card
			if($data){
				$card = new Card();
				
				//TODO: Validar los datos antes de guardar el card

				$card->name = $data->name;
				$card->description = $data->description;
				$card->colection = $data->colection;
				$colectionName = $data->colection;

				if (Colection::where('colectionName', $colectionName)->get()->first()) {
	                 $response = "Carta añadida a colección ya existente ";
	            } else{
	               $colection = new colection();
	                $colection->colectionName = $data->colection;
	                $colection->save();
	            }
				try{
					$card->save();
					$response = "OK";
				}catch(\Exception $e){
					$response = $e->getMessage();
				}
				
			}
		} else {
			$response = "No tienes permisos";
		}

		return response($response);
	}
}