<?php

namespace App\Http\Controllers\API;
   
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Validator;

class UserController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
		$users = User::where('user_type_id',1)->get();
		if(!$users->count()){
			return $this->sendError('Not found.', ['error'=>'User not found']);
        }else {
			
            return $this->sendResponse($users, 'User listed successfully.');
		}
		//return response()->json(["code" => 200,"data" => $users]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
	 
	public function trash(){
		$user = User::onlyTrashed()->get();
		
		if(!$user->count()){
            return $this->sendError('Not found.', ['error'=>'User not found']);
        }else {
			return $this->sendResponse($user, 'User listed successfully.');
		}
	}
	
	public function restore($id){
		$user = User::onlyTrashed()->where('id', $id);
		
		if(!$user->count()){
			return $this->sendError('Not found.', ['error'=>'User not found']);
        }else {
			$user->restore();
            return $this->sendResponse($user, 'User restore successfully.');
		}
	}
	
	public function restoreAll(){
		$user = User::onlyTrashed();
		
		if(!$user->count()){
			return $this->sendError('Not found.', ['error'=>'User not found']);
        }else {
			$user->restore();
            return $this->sendResponse($user, 'User restore successfully.');
		}
	}
	
	public function erase($id){
		$user = User::onlyTrashed()->where('id', $id);
		
		if(!$user->count()){
			return $this->sendError('Not found.', ['error'=>'User not found']);
        }else {
			$user->forceDelete();
            return $this->sendResponse($user, 'User permanently deleted.');
		}
	}
	
	public function eraseAll(){
		$user = User::onlyTrashed();
		
		if(!$user->count()){
			return $this->sendError('Not found.', ['error'=>'User not found']);
        }else {
			$user->forceDelete();
            return $this->sendResponse($user, 'User permanently deleted.');
		}
	}
	
    public function destroy($id)
    {
        //
		$user = User::find($id);
        if($user){
            $user->delete();
			return $this->sendResponse('success', 'User delete successfully.');
        }else {
			return $this->sendError('Not found.', ['error'=>'User not found']);
		}
    }
	
	
}
