<?php

namespace App\Http\Controllers\API;
   
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\User;
use App\Models\UserType;
use Illuminate\Support\Facades\Auth;
use Validator;
   
class AuthController extends BaseController
{
    /**
     * Signup api
     *
     * @return \Illuminate\Http\Response
     */
    public function signup(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:users',
            'password' => 'required',
            'confirm_password' => 'required|same:password',
        ]);
   
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }
   
        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);
        $success['token'] =  $user->createToken('MyApp')->accessToken;
        $success['email'] =  $user->email;
   
        return $this->sendResponse($success, 'User register successfully.');
    }
   
    /**
     * Signin api
     *
     * @return \Illuminate\Http\Response
     */
    public function signin(Request $request)
    {
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){ 
            $user = auth()->user();
			$role = $user->role->name; 
            $success['token'] =  $user->createToken('MyApp')-> accessToken; 
            $success['email'] =  $user->email;
            $success['role'] =  $user->role->name;
			
            return $this->sendResponse($success, 'User login successfully.');
        } 
        else{ 
            return $this->sendError('Unauthorised.', ['error'=>'Unauthorised']);
        } 
    }
	
	public function user(){
		$user = auth()->user();
		$role = $user->role->name; 
		
		$success['email'] =  $user->email;
		$success['created_at'] =  $user->created_at;
		$success['updated_at'] =  $user->updated_at;
		$success['role'] =  $user->role->name;
		
		return $this->sendResponse($success, 'User retrieve successfully.');
	}
	
	public function signout() {
        auth()->logout();
		return $this->sendResponse('Success', 'User signout successfully.');
    }
}