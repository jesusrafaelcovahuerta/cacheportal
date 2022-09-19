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

        $contents = Content::from('contents as c')
                        ->selectRaw('c.*')
                        ->leftJoin('categries', 'categories.category_id', '=', 'c.category_id')
                        ->leftJoin('sections', 'sections.section_id', '=', 'categories.category_id')
                        ->where('sections.section_id', $section_id)
                        ->orderBy('c.created_at', 'DESC')
                        ->get();
        
        return $this->successResponse($contents);
    }
}