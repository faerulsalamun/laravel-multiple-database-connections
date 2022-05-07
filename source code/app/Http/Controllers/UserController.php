<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Log;

class UserController extends Controller
{
    public function create(Request $request){
        // Insert to MySQL
        $user = new User();
        $user->email = $request->input('email');
        $user->name = $request->input('name');
        $user->password = Hash::make($request->input('password'));
        $user->save();

        // Insert to MongoDB
        $log = new Log();
        $log->activity = 'created';
        $log->table = 'users';
        $log->save();

        return response()->json(['success' => true]);
    }

    public function delete($id){
        $user = User::find($id);
        $user->delete();

         // Insert to MongoDB
         $log = new Log();
         $log->activity = 'deleted';
         $log->table = 'users';
         $log->save();
 
         return response()->json(['success' => true]);
    }
}
