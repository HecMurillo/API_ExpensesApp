<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Reason as modelReason;
use Illuminate\Http\Request;

class ReasonController extends Controller
{
    public function list(){
        $reasons = modelReason::all();
        $list = [];
        foreach($reasons as $reason)
        {
            $object =[
                "id" => $reason->id,
                "user_id" => $reason->user_id,
                "reason" => $reason->reason,
                "created" => $reason->created_at,
                "updated" => $reason->updated_at
            ];
            array_push($list, $object);
        }
        return response()->json($list);
    }

    public function item($id)
    {
        $reason = modelReason::where('id', '=', $id) ->first();
        {
            $object =[
                "id" => $reason->id,
                "user_id" => $reason->user_id,
                "reason" => $reason->reason,
                "created" => $reason->created_at,
                "updated" => $reason->updated_at
            ];
        }
        return response()->json($object);
    }

    public function create(Request $request)
    {
        $data = $request->validate([
            'reason' => 'required',
            'user_id'=> 'required|integer',
        ]);

        $reason=modelReason::create([
            'reason' => $data['reason'],
            'user_id' => $data['user_id']
        ]);
        if($reason){
            return response()->json([
                'message' => 'Se ha creado un registro',
                'data' => $reason
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
            'id' => 'required|integer',
            'user_id'=> 'required|integer',
            'reason' => 'required'
        ]);
        $reason = modelReason::where('id', '=', $data['id'])->first();
        
        if($reason)
        {
            $old = clone $reason;
            $reason->reason =$data['reason'];
            $reason->user_id =$data['user_id'];

            if($reason->save()){
                $object =
                [
                    "response" => 'success, Item update correctly',
                    "old" => $old,
                    "new" => $reason,
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

    public function ListUser($userId){
        $reasons = modelReason::where('user_id', $userId)->get();
        $reasonArray = [];
        foreach ($reasons as $reason) {
            $reasonArray[] = [
                "id" => $reason->id,
                "user_id" => $reason->user_id,
                "reason" => $reason->reason,
            ];
        }    
    
        return response()->json($reasonArray);
    }
}