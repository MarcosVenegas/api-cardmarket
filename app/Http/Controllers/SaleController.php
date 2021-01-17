<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \Firebase\JWT\JWT;
use App\Models\User;
use App\Models\Sale;
use App\Models\Card;
use App\Models\Colection;

class saleController extends Controller
{
    //
    public function createSale(Request $request)
    {

        $response = "";

        $getHeaders = apache_request_headers ();
        $token = $getHeaders['Authorization'];
        $key = "25634qswy6dctjuvykuil9o8ui7y9tW6ETUIYOGBFjuytgvbUCVUIJ€tcuyvibgh867ui6yftvygcguti7565rtyfrduit68it";

        $decoded = JWT::decode($token, $key, array('HS256'));

        //primero verificamos que tiene permisos con su id de usuario
        $permiso = User::where('name', $decoded)->get()->first();

        if ($permiso->rol == "particular" || $permiso->rol == "profesional" ) {
            //Leer el contenido de la petición
            $data = $request->getContent();

            //Decodificar el json
            $data = json_decode($data);

            //Si hay un json válido, crear el sale
            if($data){
                $sale = new Sale();
               //buscamos los datos del ususario
                $user = User::where('name', $data->nombre)->get()->first();
                //buscamos los datos de la carta

                //TODO: Validar los datos antes de guardar el sale
                 $sale->card_id = $data->card_id;
                //guardamos el id del ususario
                $sale->user_id = $user->id;
                $sale->stock = $data->stock;
                $sale->cost = $data->cost;

                try{
                    $sale->save();

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

    public function cardsList($cardname){

        $response = "";

        $cards = card::where('name', stripos($cardname))->get()->first();

        $response= [];

        foreach ($cards as $card) {
            $response[] = [
                "id" => $cards->id,
                "nombre" => $cards->name,
                "coleccion" => $cards->colection,
                "descripcion" => $cards->description


            ];

        }


        return response()->json($response);
    }
    }