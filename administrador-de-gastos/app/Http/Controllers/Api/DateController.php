<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Date as ModelsDate;
use Illuminate\Http\Request;

class DateController extends Controller
{
    public function list(){
        $dates = ModelsDate::all();
        $list = [];
        foreach($dates as $date)
        {
            $object =[
                "id" => $date->id,
                "user_id" => $date->user_id,
                "Date" => $date->date,
                "created" => $date->created_at,
                "updated" => $date->updated_at
            ];
            array_push($list, $object);
        }
        return response()->json($list);
    }

    public function item($id)
    {
        $date = ModelsDate::where('id', '=', $id) ->first();
        {
            {
            $object =
                [
                "id" => $date->id,
                "user_id" => $date->user_id,
                "Date" => $date->date,
                "created" => $date->created_at,
                "updated" => $date->updated_at
                ];
            }
        }
        return response()->json($object);
    } 

    public function create(Request $request)
    {
        $data = $request->validate([
            'date' => 'required',
            'user_id'=> 'required|integer',
        ]);

        $date=ModelsDate::create([
            'date' => $data['date'],
            'user_id' => $data['user_id']
        ]);
        if($date){
            return response()->json([
                'message' => 'Se ha creado un registro',
                'data' => $date
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
            'user_id' => 'required|integer',
            'date' => 'required',
        ]);

        $date = ModelsDate::where('id', '=', $data['id'])->first();
        
        if($date)
        {
            $old = clone $date;
            $date->user_id =$data['user_id'];
            $date->date =$data['date'];
            if($date->save()){
                $object =
                [
                    "response" => 'success, Item update correctly',
                    "old" => $old,
                    "new" => $date,
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
