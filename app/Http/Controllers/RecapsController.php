<?php

namespace App\Http\Controllers;

use App\Http\Requests\RecapsRequest;
use App\Models\Recap;
use Illuminate\Http\Request;

class RecapsController extends Controller
{
    public function store(RecapsRequest $recapsRequest){

        try{
            Recap::create($recapsRequest->all());

            return response()->json([
                "message"=> "sucess",
            ],201);

        }catch(\Exception $e){
            return response()->json([
                "message"=> $e->getMessage(),
            ],500);
        }
    }
}
