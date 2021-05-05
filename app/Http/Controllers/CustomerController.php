<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Support\Facades\DB;

class CustomerController extends Controller
{
    public function index()
    {   

        $customer = User::paginate(10);
        return response()->json($customer,200);
    }
    

    /**
    * Store a newly created resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
    public function store(Request $request)
    {
    $input = $request->all();
    $validator = Validator::make($input, [
        'name' => 'required|min:2',
        'email' => 'required|email|unique:users',
        'password' => 'required|min:4',
    ]);
    if($validator->fails()){
        return response()->json([
            'success' => false,
            'message' => 'Input Format Incorrect! '
        ], 400);        
    }
    $customer = User::create($input);
    return response()->json([
    "success" => true,
    "message" => "User Added successfully.",
    "data" => $customer
    ]);
    } 
    /**
    * Display the specified resource.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function show($id)
    {
    $customer = User::find($id);
    if (!$customer) {
        return response()->json([
            'success' => false,
            'message' => 'User is not available! '
        ], 400);
    }
    return response()->json([
    "success" => true,
    "message" => "User retrieved successfully.",
    "data" => $customer
    ]);
    }
    /**
    * Update the specified resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  \App\User $customer
    * @return \Illuminate\Http\Response
    */
    public function update(Request $request,User $customer)
    {
    
        $input = $request->all();
        $validator = Validator::make($input, [
        'name' => 'required',
        ]);
        if($validator->fails()){
            return response()->json([
                'success' => false,
                'message' => 'Input Format Incorrect! '
            ], 400);    
        }
        $customer->name = $input['name'];
        $customer->save();
        return response()->json([
        "success" => true,
        "message" => "user updated successfully.",
        "data" => $customer
        ]);
    } 
 
       
    
   
    
    /**
    * Remove the specified resource from storage.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function destroy(User $customer)
    {
    $customer->delete();
    return response()->json([
    "success" => true,
    "message" => "User deleted successfully.",
    "data" => $customer
    ]);
    }
}
