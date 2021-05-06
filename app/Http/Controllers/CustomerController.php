<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\StoreUserRequest;
use Validator;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\UserResource;

class CustomerController extends Controller
{
    public function index()
    {   

        return UserResource::collection(User::paginate(10));
    }
    

    /**
    * Store a newly created resource in storage.
    *
    * @param  \App\Http\Requests\StoreUserRequest  $request
    * @return \Illuminate\Http\Response
    */
    public function store(StoreUserRequest $request)
    {
    $input = $request->all();
    $input['password'] = bcrypt($input['password']);
    $customer = User::create($input);
    return new UserResource($customer);
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
    return new UserResource($customer);
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
        'name' => 'required|min:2',
        ]);
        if($validator->fails()){
            return response()->json([
                'success' => false,
                'message' => 'Input Format Incorrect! '
            ], 400);    
        }
        $customer->name = $input['name'];
        $customer->save();
        return new UserResource($customer);
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
    ],200);
    }
}
