<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class RegisterController extends BaseController
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'c_password' => 'required|same:password',
            'is_admin' => 'required',
        ]);
   
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }
   
        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);
        $success['tokenx'] =  $user->createToken('MyApp')->accessToken;
        $success['name'] =  $user->name;
   
        return $this->sendResponse($success, 'User register successfully.');
    }

    public function login(Request $request)
    {
        $email = $request->email;
        $password = $request->password;

        //dd($email);
        $credentials = [
            'email' => $email,
            'password' => $password
        ];
        if(Auth::attempt($credentials)){ 
            $user = Auth::user(); 
            $token =  $user->createToken('MyApp')-> accessToken; 
            $name =  $user->name;

            //dd( $success);

            $remember_token=User::where('email',$request->email)
            ->update([
                'remember_token' => $token,
            ]);
   
            $response = [
                'success' => true,
                'token' => $token,
                'user' => $name,
                'message' => 'User login successfully.',
            ];
    
            return response()->json($response, 200);
        } 
        else{ 
            return $this->sendError('Unauthorised.', ['error'=>'Unauthorised']);
        } 
    }
}
