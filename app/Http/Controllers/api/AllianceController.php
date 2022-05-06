<?php

namespace App\Http\Controllers\api;

use App\Alliance;
use App\User;
use App\Http\Controllers\ApiResponseController;
use App\Http\Controllers\Controller\api;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AllianceController extends ApiResponseController
{
    public function __construct(Request $request)
    {
        $this->user = User::where('api_token', $request->api_token)->first();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $alliances = Alliance::orderBy('rut', 'ASC')
                        ->paginate(10);
        
        return $this->successResponse($alliances);
    }

    /**
     * A listing of the resources.
     *
     * @return \Illuminate\Http\Response
     */
    public function list(Request $request)
    {
        $alliances = Alliance::where('status', 1)
                        ->orderBy('rut', 'ASC')
                        ->get();
        
        return $this->successResponse($alliances);
    }

    /**
     * Store the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $alliance = new Alliance();
        $alliance->rut = $request->rut;
        $alliance->name = $request->name;
        $alliance->alias = $request->alias;
        $alliance->contact = $request->contact;
        $alliance->contact_email = $request->email;
        $alliance->contact_phone = $request->phone;
        $alliance->start_date = $request->start_date;
        $alliance->end_date = $request->end_date;
        $alliance->status = 1;
        if($alliance->save()) {
            return $this->successResponse($alliance);
        } else {
            return $this->errorResponse($alliance);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $alliance = Alliance::find($id);

        return $this->successResponse($alliance);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $alliance = Alliance::find($id);
        $alliance->status = 0;
        if($alliance->save()) {
            return $this->successResponse($alliance);
        } else {
            return $this->errorResponse($alliance);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $alliance = Alliance::find($id);
        $alliance->rut = $request->rut;
        $alliance->name = $request->name;
        $alliance->alias = $request->alias;
        $alliance->contact = $request->contact;
        $alliance->contact_email = $request->email;
        $alliance->contact_phone = $request->phone;
        $alliance->start_date = $request->start_date;
        $alliance->end_date = $request->end_date;
        $alliance->status = 1;
        if($alliance->save()) {
            return $this->successResponse($alliance);
        } else {
            return $this->errorResponse($alliance);
        }
    }

    /**
     * Activate the specified resource.
     *
     * @param  Request $request
     * @return \Illuminate\Http\Response
     */
    public function activate(Request $request)
    {
        $id = $request->segment(4);

        $alliance = Alliance::find($id);
        $alliance->status = 1;
        if($alliance->save()) {
            return $this->successResponse($alliance);
        } else {
            return $this->errorResponse($alliance);
        }
    }
}