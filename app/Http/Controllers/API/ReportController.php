<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\Report;
use Illuminate\Support\Facades\Auth;
use Validator;


class ReportController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
		$report = Report::all();
		if(!$report->count()){
			return $this->sendError('Not found.', ['error'=>'Report not found']);
        }else {
			return $this->sendResponse($report, 'Report listed successfully.');
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
	public function sendReport(Request $request)
    {
        //
		$validator = Validator::make($request->all(), [
            'from' => 'required',
            'to' => 'required',
            'subject' => 'required',
            'message' => 'required',
        ]);
   
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }
		
		$input = $request->all();
		$report = Report::create($input);
        return $this->sendResponse('success', 'Message successfully sending.');
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
