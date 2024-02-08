<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\expense as ModelExpense;
use Illuminate\Http\Request;

class ExpenseController extends Controller
{
    public function list(){
        $expenses = ModelExpense::all();
        $list = [];
        foreach($expenses as $expense)
        {
            $object =[
                "id" => $expense->id,
                "expense" => $expense->expense,
                "earning" => $expense->earning,
                "users_id" => $expense->users_id,
                "purchase_id" => $expense->purchase_id,
                "date_id" => $expense->date_id,
                "reason_id" => $expense->reason_id,
                "created" => $expense->created_at,
                "updated" => $expense->updated_at
            ];
            array_push($list, $object);
        }
        return response()->json($list);
    }

    public function item($id)
    {
        $expenses = ModelExpense::where('id', '=', $id) ->first();
        {
            {
            $object =[
                "id" => $expenses->id,
                "expense" => $expenses->expense,
                "earning" => $expenses->earning,
                "users_id" => $expenses->users_id,
                "purchase_id" => $expenses->purchase_id,
                "date_id" => $expenses->date_id,
                "reason_id" => $expenses->reason_id,
                "created" => $expenses->created_at,
                "updated" => $expenses->updated_at
            ];
        }
        }
        return response()->json($object);
    }

    public function create(Request $request)
    {
        $data = $request->validate([
            'expense' => 'required|numeric',
            'earning' => 'required|numeric',
            'users_id'=> 'required|integer',
            'purchase_id'=> 'required|integer',
            'date_id'=> 'required|integer',
            'reason_id'=> 'required|integer',
        ]);
        $expense=ModelExpense::create([
            'expense' => $data['expense'],
            'earning' => $data['earning'],
            'users_id'=> $data['users_id'],
            'purchase_id'=> $data['purchase_id'],
            'date_id'=> $data['date_id'],
            'reason_id'=> $data['reason_id']
            
        ]);
        if($expense){
            return response()->json([
                'message' => 'Se ha creado un registro',
                'data' => $expense
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
            'expense' => 'required',
            'earning' => 'required',
            'users_id' => 'required|integer',
            'purchase_id' => 'required|integer',
            'date_id' => 'required|integer',
            'reason_id' => 'required|integer',
        ]);

        $reason = ModelExpense::where('id', '=', $data['id'])->first();
        
        if($reason)
        {
            $old = clone $reason;
            
            $reason->expense =$data['expense'];
            $reason->earning =$data['earning'];
            $reason->users_id =$data['users_id'];
            $reason->purchase_id =$data['purchase_id'];
            $reason->date_id =$data['date_id'];
            $reason->reason_id =$data['reason_id'];

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
}
