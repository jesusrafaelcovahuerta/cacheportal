<?php

namespace App\Http\Controllers;
use App\Section;
use App\Http\Controllers\ApiResponseController;
use Illuminate\Http\Request;

class SectionController extends ApiResponseController
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $sections = Section::paginate(100);

        return $this->successResponse($sections);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return view('welcome');
    }
}
