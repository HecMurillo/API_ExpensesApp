<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Expense;
use App\Models\Reason;
use Illuminate\Http\Request;

class ExpenseController extends Controller
{
    public function list(){
        $expenses = Expense::all();
        $list = [];
        foreach($expenses as $expense)
        {
            $object =[
                "id" => $expense->id,
                "expense" => $expense->expense,
                "user" => $expense->user,
                "purchase" => $expense->purchase,
                "date" => $expense->date,
                "reason" => $expense->reason,
                "created" => $expense->created_at,
                "updated" => $expense->updated_at
            ];
            array_push($list, $object);
        }
        return response()->json($list);
    }

    public function item($id)
    {
        $expenses = Expense::where('id', '=', $id) ->first();
        {
            {
            $object =[
                "id" => $expenses->id,
                "expense" => $expenses->expense,
                "user" => $expenses->user,
                "purchase" => $expenses->purchase,
                "date" => $expenses->date,
                "reason" => $expenses->reason,
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
            'user_id'=> 'required|integer',
            'purchase_id'=> 'required|integer',
            'date_id'=> 'required|integer',
            'reason_id'=> 'required|integer',
        ]);
        $expense=Expense::create([
            'expense' => $data['expense'],
            'user_id'=> $data['user_id'],
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
            'user_id' => 'required|integer',
            'purchase_id' => 'required|integer',
            'date_id' => 'required|integer',
            'reason_id' => 'required|integer',
        ]);

        $reason = Expense::where('id', '=', $data['id'])->first();
        
        if($reason)
        {
            $old = clone $reason;
            
            $reason->expense =$data['expense'];
            $reason->user_id =$data['user_id'];
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

    public function Elements2($reasons){
        $reasonss= Reason::where('name', 'LIKE', "%{$reasons}%")->first();
        $expenses = Expense::where('reason_id', '=', $reasonss -> id)->get();

        $expensesArray = [];
        foreach ($expenses as $expense) {
            $expensesArray[] = [
                "id" => $expense->id,
                "expense" => $expense->expense,
                "purchase_id" => $expense->purchase_id,
                "date_id" => $expense->date_id,
                "reason_id" => $expense->reason_id,
                "created_at" => $expense->created_at,
                "updated_at" => $expense->updated_at,
                "user_id" => $expense->user_id,
            ];
        }    

        return response()->json($expensesArray);
    }

    public function Elements($reasons){
        $reasonss= Reason::where('reason', 'LIKE', "%{$reasons}%")->first();
        $expenses = Expense::where('reason_id', '=', $reasonss -> id)->get();

        $expensesArray = [];
        foreach ($expenses as $expense) {
            $expensesArray[] = [
                "id" => $expense->id,
                "expense" => $expense->expense,
                "purchase_id" => $expense->purchase_id,
                "date_id" => $expense->date_id,
                "reason_id" => $expense->reason_id,
                "created_at" => $expense->created_at,
                "updated_at" => $expense->updated_at,
                "user_id" => $expense->user_id,
            ];
        }    

        return response()->json($expensesArray);
    }

    public function ListUser($userId){
        $expenses = Expense::where('user_id', $userId)->get();
        $expensesArray = [];
        foreach ($expenses as $expense) {
            $expensesArray[] = [
                "id" => $expense->id,
                "expense" => $expense->expense,
                "user" => $expense->user,
                "purchase" => $expense->purchase,
                "date" => $expense->date,
                "reason" => $expense->reason,
                "created" => $expense->created_at,
                "updated" => $expense->updated_at
            ];
        }    
    
        return response()->json($expensesArray);
    }

    public function ListReasonUser($userId, $reason){
        $expenses = Expense::where('user_id', $userId)
        ->whereHas('reason', function ($query) use ($reason) {
        $query->where('reason', $reason);})->get();
    
        $totalExpenses = 0;
        
        $resultArray = [];
    
        
        foreach ($expenses as $expense) {
            $purchaseDetails = [
                "id" => $expense->id,
                "purchase" => $expense->purchase,
                "expense" => $expense->expense,
            ];
    
            $resultArray[] = $purchaseDetails;
            $totalExpenses += $expense->expense;
        }
    
        $resultArray['total_expenses'] = $totalExpenses;
    
        return response()->json($resultArray);
    }


    public function updatedepobres(Request $request)
    {
        $data = $request->validate([
            'id' => 'required|integer|min:1',
            'expense' => 'required',
        ]);

        $reason = Expense::where('id', '=', $data['id'])->first();
        
        if($reason)
        {
            $old = clone $reason;
            
            $reason->expense =$data['expense'];

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

    public function RecentExpenses($userId){
        $expenses = Expense::where('user_id', $userId)
            ->latest()
            ->take(5)
            ->get();
    
        $resultArray = [];
    
        foreach ($expenses as $expense) {
            $purchaseDetails = [
                "id" => $expense->id,
                "expense" => $expense->expense,
                "user" => $expense->user, 
                "purchase" => $expense->purchase,
                "date" => $expense->date, 
                "reason" => $expense->reason,
            ];
            $resultArray[] = $purchaseDetails; // Agrega los detalles de la compra al array resultante
        }
    
        return response()->json($resultArray); // Devuelve el array completo como JSON
    }

    public function SearchExpenses($userId, $searchTerm) {
        $expenses = Expense::where('user_id', $userId)
            ->whereHas('purchase', function ($query) use ($searchTerm) {
                $query->where('buy', 'like', $searchTerm . '%'); // Busca por coincidencia con los primeros caracteres
            })
            ->latest()
            ->get();
    
        $resultArray = [];
    
        foreach ($expenses as $expense) {
            $purchaseDetails = [
                "id" => $expense->id,
                "expense" => $expense->expense,
                "user" => $expense->user,
                "purchase" => $expense->purchase,
                "date" => $expense->date,
                "reason" => $expense->reason,
            ];
            $resultArray[] = $purchaseDetails; // Agrega los detalles de la compra al array resultante
        }
    
        return response()->json($resultArray); // Devuelve el array completo como JSON
    }

    public function TotalGlobal($userId) {
        // Calcula el total de gastos del usuario
        $totalExpenses = Expense::where('user_id', $userId)->sum('expense');
    
        // Prepara el resultado con el total de gastos
        $resultArray = [
            'total' => $totalExpenses
        ];
    
        // Devuelve los datos como JSON
        return response()->json($resultArray);
    }


    
}

