<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\User;
use App\Models\Message;
use Illuminate\Support\Facades\Auth;   
use Validator;

class MessageController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
		$message = Message::all();
		if(!$message->count()){
			return $this->sendError('Not found.', ['error'=>'Message not found']);
        }else {
			return $this->sendResponse($message, 'Message listed successfully.');
		}
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
		$validator = Validator::make($request->all(), [
            'sender' => 'required',
            'receiver' => 'required',
            'message' => 'required',
        ]);
   
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }
		
		$input = $request->all();
		$message = Message::create($input);
        return $this->sendResponse('success', 'Message successfully sending.');
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
	
	public function showUserMessage(){
		$id = auth()->user()->id;
		$message = Message::where('sender', '=' ,$id)->orWhere('receiver', '=' ,$id)->get();
		if(!$message->count()){
			return $this->sendError('Not found.', ['error'=>'Message not found']);
        }else {
			return $this->sendResponse($message, 'Message listed successfully.');
		}
	}
	
	public function sendMessage(){
		
	}

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
