<?php

namespace App\Http\Controllers\api;

use App\Content;
use App\Category;
use App\User;
use App\Poll;
use App\Http\Controllers\ApiResponseController;
use App\Http\Controllers\Controller\api;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SectionContentController extends ApiResponseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $section_id = $request->segment(4);

        $contents = Content::where('section_id', $section_id)
                        ->where('category_id', 1)
                        ->orderBy('position', 'ASC')
                        ->get();
        
        return $this->successResponse($contents);
    }
}