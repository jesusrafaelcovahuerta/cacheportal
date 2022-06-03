<?php

namespace App\Http\Controllers\api;

use App\Category;
use App\Content;
use App\User;
use App\Poll;
use App\Http\Controllers\ApiResponseController;
use App\Http\Controllers\Controller\api;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CategoryController extends ApiResponseController
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
        $section_id = $request->segment(4);

        if(($section_id == 'null')
        || ($section_id == '')
        ) {
            $categories = Category::from('categories as c')
                        ->selectRaw('c.category_id as category_id, c.name as name, alliances.name as alliance, c.position as position, sections.section_title as section_title, c.status as status')
                        ->leftJoin('alliances', 'alliances.rut', '=', 'c.alliance_id')
                        ->leftJoin('sections', 'sections.section_id', '=', 'c.section_id')
                        ->orderBy('c.position', 'ASC')
                        ->paginate(10);
        } else {
            $query = "";

            if ($section_id != 'null') {
                $query .= 'sections.section_id = "'.$section_id.'"';
            }

            $categories = Category::from('categories as c')
                        ->selectRaw('c.category_id as category_id, c.name as name, alliances.name as alliance, c.position as position, sections.section_title as section_title, c.status as status')
                        ->leftJoin('alliances', 'alliances.rut', '=', 'c.alliance_id')
                        ->leftJoin('sections', 'sections.section_id', '=', 'c.section_id')
                        ->whereRaw($query)
                        ->orderBy('c.position', 'ASC')
                        ->paginate(10);
        }
        
        return $this->successResponse($categories);
    }

        /**
     * Update the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function move(Request $request)
    {
        $id = $request->segment(4);
        $position = $request->segment(5) + 1;

        $fix_categories = Category::orderBy('position', 'ASC')->get();

        $i = 1;

        foreach($fix_categories as $fix_category) {
            $category_detail = Category::find($fix_category->category_id);
            $category_detail->position = $i;
            $category_detail->save();
            $i = $i + 1;
        }

        $another_category = Category::where('position', $position)->first();
        $category = Category::find($id);

        if($category->position > $another_category->position) {
            $category->position = $position;

            $another_category->position = $another_category->position + 1;
        } else {
            $category->position = $position;

            $another_category->position = $another_category->position - 1;
        }
        
        $another_category->save();
        $category->save();

        return $this->errorResponse($category);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function poll(Request $request)
    {
        $id = $request->segment(4);

        $category = Poll::where('category_id', $id)->where('status', 1)->first();
        $category_qty = Poll::where('category_id', $id)->where('status', 1)->count();
        
        if($category_qty > 0) {
            return $this->successResponse($category->content_id);
        } else {
            return $this->successResponse('');
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function list(Request $request)
    {
        $id = $request->segment(4);

        if($id != '') {
            $categories = Category::where('section_id', $id)->where('status', 1)->orderBy('name', 'ASC')->get();
        } else {
            $categories = Category::where('status', 1)->orderBy('name', 'ASC')->get();
        }
        
        return $this->successResponse($categories);
    }

    /**
     * Store the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if($request->file != 'undefined') { 
            $fileName = time().'_'.'banner'.'_'.$request->alliance_id.'_'.$request->section_id.'.'.$request->file->getClientOriginalExtension();
        }

        if($request->icon_type_id == 1) {
            if($request->icon_image != 'undefined') {
                $icon_fileName = time().'_'.'scategory_icon'.'.'.$request->icon_image->getClientOriginalExtension();
            }
        } else {
            $icon_fileName = $request->icon;
        }

        $category = new Category();
        $category->alliance_id = $request->alliance_id;
        $category->section_id = $request->section_id;
        $category->highlight_id = $request->highlight_id;
        $category->name = $request->name;
        $category->color = $request->color;
        $category->position = $request->position;

        $move_position_categories = Category::where('position', '>=', $request->position)->get();
        $position = $request->position;
        foreach($move_position_categories as $move_position_category) {
            $position = $position + 1;
            $detail_category = Category::find($move_position_category->category_id);
            $detail_category->position = $position;
            $detail_category->save();
        }

        $category->status = 1;
        if($request->file != 'undefined') { 
            $category->banner = $fileName;
        }
        if(isset($icon_fileName)) {
            if($icon_fileName != '' && $icon_fileName != null) {
                $category->icon = 'icon ion-'.$icon_fileName.' home_icon_size2';
            }
        }
        if($category->save()) {
            if($request->file != 'undefined') { 
                Storage::disk('local')->putFileAs(
                    '/public',
                    $request->file,
                    $fileName
                );
            }

            if($request->icon_image != 'undefined') {
                if($request->icon_type_id == 1) {
                    Storage::disk('local')->putFileAs(
                        '/public',
                        $request->icon_image,
                        $icon_fileName
                    );
                }
            }

            return $this->successResponse($category);
        } else {
            return $this->errorResponse($category);
        }
    }

    /**
     * Store the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if($request->file != 'undefined') { 
            $fileName = time().'_'.'banner'.'_'.$request->alliance_id.'_'.$request->section_id.'.'.$request->file->getClientOriginalExtension();
        }

        if($request->icon_type_id == 1) {
            if($request->icon_image != 'undefined') {
                $icon_fileName = time().'_'.'scategory_icon'.'.'.$request->icon_image->getClientOriginalExtension();
            }
        } else {
            $icon_fileName = $request->icon;
        }

        $category = Category::find($id);
        $category->alliance_id = $request->alliance_id;
        $category->section_id = $request->section_id;
        $category->name = $request->name;
        $category->color = $request->color;
        $old_position = $category->position;
        $category->position = $request->position;
        
        if($old_position != $request->position) {
            $move_position_categories = Category::where('position', '>=', $request->position)->get();
            $position = $request->position;
            foreach($move_position_categories as $move_position_category) {
                $position = $position + 1;
                $detail_category = Category::find($move_position_category->category_id);
                $detail_category->position = $position;
                $detail_category->save();
            }
        }

        $category->highlight_id = $request->highlight_id;
        $category->status = 1;
        if($request->file != 'undefined') { 
            $category->banner = $fileName;
        }
        if(isset($icon_fileName)) {
            if($icon_fileName != '' && $icon_fileName != null) {
                $category->icon = 'icon ion-'.$icon_fileName.' home_icon_size2';
            }
        }
        if($category->save()) {
            if($request->file != 'undefined') { 
                Storage::disk('local')->putFileAs(
                    '/public',
                    $request->file,
                    $fileName
                );
            }

            if($request->icon_image != 'undefined') {
                if($request->icon_type_id == 1) {
                    Storage::disk('local')->putFileAs(
                        '/public',
                        $request->icon_image,
                        $icon_fileName
                    );
                }
            }

            return $this->successResponse($category);
        } else {
            return $this->errorResponse($category);
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
        $category = Category::find($id);

        return $this->successResponse($category);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $id = $request->segment(4);
        $categories = Category::where('section_id', $id)->where('status', 1)->get();

        return $this->successResponse($categories);
    }

    /**
     * Destroy the specified resource.
     *
     * @param  int  $id
     * @return \App\Http\Controllers\ApiResponseController
     */
    public function destroy($id)
    {
        $check_category_contents = Content::where('category_id', $id)->count();

        if($check_category_contents == 0) {
            $category = Category::find($id);
            if(Storage::exists('public/'.$category->icon)) {
                if(Storage::delete('public/'.$category->icon)) {
                    if($category->delete()) {
                        return $this->successResponse($category);
                    } else {
                        return $this->errorResponse($category);
                    }
                }
            } else {
                if($category->delete()) {
                    return $this->successResponse($category);
                } else {
                    return $this->errorResponse($category);
                }
            }
        } else {
            $category = Category::find($id);
            $category->status = 0;
            if($category->save()) {
                return $this->successResponse($category);
            } else {
                return $this->errorResponse($category);
            }
        }
    }
}