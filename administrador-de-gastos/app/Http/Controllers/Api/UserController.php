<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User as modelUser;

class UserController extends Controller
{
    public function list(){
        $users = modelUser::all();
        $list = [];
        foreach($users as $user)
        {
            $object =[
                "id" => $user->id,
                "name" => $user->name,
                "email" => $user->email,
                "created" => $user->created_at,
                "updated" => $user->updated_at
            ];
            array_push($list, $object);
        }
        return response()->json($list);
    }

    public function item($id)
    {
        $user = modelUser::where('id', '=', $id) ->first();
        {
            $object =[
                "id" => $user->id,
                "name" => $user->name,
                "email" => $user->email,
                "created" => $user->created_at,
                "updated" => $user->updated_at
            ];
        }
        return response()->json($object);
    }

    public function create(Request $request)
    {
        $data = $request->validate([
            'name' => 'required',
            'email'=> 'required',
            'password'=> 'required',
        ]);

        $user=modelUser::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => $data['password'],
        ]);
        if($user){
            return response()->json([
                'message' => 'Se ha creado un registro',
                'data' => $user
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
            'name' => 'required',
            'email'=> 'required',
        ]);
        $user = modelUser::where('id', '=', $data['id'])->first();
        
        if($user)
        {
            $old = clone $user;

            $user->name =$data['name'];
            $user->email =$data['email'];
            
            if($user->save()){
                $object =
                [
                    "response" => 'success, Item update correctly',
                    "old" => $old,
                    "new" => $user,
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

    public function updatepass(Request $request)
    {
        $data = $request->validate([
            'id' => 'required|integer',
            'password'=> 'required',
        ]);
        $user = modelUser::where('id', '=', $data['id'])->first();
        
        if($user)
        {
            $old = clone $user;

            $user->password =$data['password'];

            if($user->save()){
                $object =
                [
                    "response" => 'success, Item update correctly',
                    "old" => $old,
                    "new" => $user,
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
