<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\purchase;
use Illuminate\Http\Request;

class PurchaseController extends Controller
{
    public function list(){
        $shoppings = Purchase::all();
        $list = [];
        foreach($shoppings as $shopping)
        {
            $object =[
                "id" => $shopping->id,
                "users_id" => $shopping->users_id,
                "buy" => $shopping->buy,
                "created" => $shopping->created_at,
                "updated" => $shopping->updated_at
            ];
            array_push($list, $object);
        }
        return response()->json($list);
    }

    public function item($id)
    {
        $shopping = Purchase::where('id', '=', $id) ->first();
        {
            $object =[
                "id" => $shopping->id,
                "users_id" => $shopping->users_id,
                "buy" => $shopping->buy,
                "created" => $shopping->created_at,
                "updated" => $shopping->updated_at
            ];
        }
        return response()->json($object);
    }

    public function create(Request $request)
    {
        $data = $request->validate([
            'buy' => 'required|numeric',
            'users_id'=> 'required|integer',
        ]);

        $purchase=purchase::create([
            'buy' => $data['buy'],
            'users_id' => $data['users_id']
        ]);
        if($purchase){
            return response()->json([
                'message' => 'Se ha creado un registro',
                'data' => $purchase
            ]);
        }else{
            return response()->json([
                'message' => 'Error al crear el registro',
            ]);
        }
    } 

    public function update(Request $request)
    {
        $data = $request->validate([
            'id' => 'required|integer|min:1',
            'users_id'=> 'required|integer',
            'buy' => 'required'
        ]);

        $shopping = Purchase::where('id', '=', $data['id'])->first();
        
        if($shopping)
        {
            $old = clone $shopping;
            $shopping->buy =$data['buy'];
            $shopping->users_id =$data['users_id'];
            
            if($shopping->save()){
                $object =
                [
                    "response" => 'success, Item update correctly',
                    "old" => $old,
                    "new" => $shopping,
                ];
                return response()->json($object);
            } else{
                $object =
                [
                    "response" =>'Error: stupid',
                ];
                return response()->json($object);
            }
        }else
        {
            $object =
            [
                "response" =>'Error: stupid',
            ];
            return response()->json($object);
        }
    } 
}
