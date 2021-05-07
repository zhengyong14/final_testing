<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\UsersImport;
use App\Exports\UsersExport;
use App\Http\Requests\StoreExcelRequest;
use Illuminate\Support\Facades\DB;
use Validator;
use App\Models\User;

class UserController extends Controller
{
    /**
    * @return \Illuminate\Support\Collection
    */

    public function fileImportExport()
    {
        return view('file-import');
    }
   
    /**
    * @return \Illuminate\Support\Collection
    */

    public function fileImport(StoreExcelRequest $request) 
    {
        $users = Excel::toCollection(new UsersImport, $request->file('file'));       
        foreach ($users[0] as $user) {
            $validate = Validator::make([
                'name' => $user[1],
                'email' => $user[2],
                'password' => $user[4],
            ]
            ,
            [
                'name' => 'required|min:2',
                'email' => 'required|email|unique:users',
                'password' => 'required|min:4',
            ]);
            $check = User::where('email','=',$user[2])->first();
            if (!isset($user[7])) {
                continue;
            } else {
                if ($check && $user[7] == "update") {
                    User::where('email',$user[2])->update([
                        'name' => $user[1],
                ]);
                }
                if (!$check && $user[7] == "create") {
                    if ($validate->fails()) {
                        continue;
                    } else {
                        User::create ([
                            'name'     => $user[1],
                            'email'    => $user[2],
                            'password' => bcrypt($user[4])
                ]);
                }
                }
                if($check && $user[7] == "delete"){
                    User::where('email',$user[2])->delete();
                }
            }
        }
        return back();
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function fileExport() 
    {
        return Excel::download(new UsersExport, 'users-collection.xlsx');
    }      
}