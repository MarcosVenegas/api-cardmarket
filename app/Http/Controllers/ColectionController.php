<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Card;
use App\Models\Colection;

class colectionController extends Controller
{
	public function createColection(Request $request)
	{
		
		$response = "";
		//Leer el contenido de la petición
		$data = $request->getContent();

		//Decodificar el json
		$data = json_decode($data);

		//Si hay un json válido, crear el colection
		if($data){
			$colection = new colection();

			//TODO: Validar los datos antes de guardar el colection

			$colection->colectionName = $data->colectionName;
			//$colection->simbol = $data->simbol;
			try{
				$colection->save();
				$response = "OK";
			}catch(\Exception $e){
				$response = $e->getMessage();
			}
			
		}
		
		return response($response);
	}

	public function updateColection(Request $request, $id){

		$response = "";

		//Buscar el colection por su id

		$colection = Colection::find($id);

		if($colection){

			//Leer el contenido de la petición
			$data = $request->getContent();

			//Decodificar el json
			$data = json_decode($data);

			//Si hay un json válido, buscar el colection
			if($data){
			
				//TODO: Validar los datos antes de guardar el colection
				$colection->name = (isset($data->name) ? $data->name : $colection->name);
				$colection->simbol = (isset($data->simbol) ? $data->simbol : $colection->simbol);
				try{
					$colection->save();
					$response = "OK";
				}catch(\Exception $e){
					$response = $e->getMessage();
				}
			}

			
		}else{
			$response = "No colection";
		}

		
		return response($response);
	}

}