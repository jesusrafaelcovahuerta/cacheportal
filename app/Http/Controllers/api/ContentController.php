<?php

namespace App\Http\Controllers\api;

use App\Content;
use App\User;
use App\Http\Controllers\ApiResponseController;
use App\Http\Controllers\Controller\api;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ContentController extends ApiResponseController
{
    public function __construct(Request $request)
    {
        $this->user = User::from('users as c')
                        ->selectRaw('c.*, members.rol_id as rol_id')
                        ->leftJoin('members', 'members.user_id', '=', 'c.rut')
                        ->where('api_token', $request->api_token)
                        ->first();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $title = $request->segment(4);
        $alliance_id = $request->segment(5);
        $section_id = $request->segment(6);
        $category_id = $request->segment(7);

        if(($title == 'null' && $alliance_id == 'null' && $section_id == 'null' && $category_id == 'null')
        || ($title == '' && $alliance_id == '' && $section_id == '' && $category_id == '')
        ) {
            $contents = Content::from('contents as c')
                        ->selectRaw('c.content_id as content_id, CONCAT(c.title) as title, categories.name as category, sections.section_title as section, c.start_date as start_date, c.end_date as end_date, c.status as status, c.position as position')
                        ->leftJoin('categories', 'categories.category_id', '=', 'c.category_id')
                        ->leftJoin('sections', 'sections.section_id', '=', 'categories.section_id')
                        ->orderBy('c.position', 'ASC')
                        ->paginate(10);
        } else {
            $query = "";

            if ($title != 'null') {
                $query .= 'c.title LIKE "%'.$title.'%"';
            }

            if ($alliance_id != 'null') {
                if ($title != 'null') {
                    $query .= ' AND ';
                }

                $query .= 'alliances.rut = "'.$alliance_id.'"';
            }

            if ($section_id != 'null') {
                if ($title != 'null' || $alliance_id != 'null') {
                    $query .= ' AND ';
                }

                $query .= 'sections.section_id = "'.$section_id.'"';
            }

            if ($category_id != 'null') {
                if ($title != 'null' || $alliance_id != 'null' || $section_id != 'null') {
                    $query .= ' AND ';
                }

                $query .= 'categories.category_id = "'.$category_id.'"';
            }

            $contents = Content::from('contents as c')
                        ->selectRaw('c.content_id as content_id, CONCAT(c.title) as title, categories.name as category, sections.section_title as section, c.start_date as start_date, c.end_date as end_date, c.status as status, c.position as position')
                        ->leftJoin('categories', 'categories.category_id', '=', 'c.category_id')
                        ->whereRaw($query)
                        ->leftJoin('sections', 'sections.section_id', '=', 'categories.section_id')
                        ->leftJoin('alliances', 'alliances.rut', '=', 'categories.alliance_id')
                        ->orderBy('c.position', 'ASC')
                        ->paginate(10);
        }
        
        return $this->successResponse($contents);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function date()
    {
        $contents = Content::all();

        foreach($contents as $content) {
            if(date('Y-m-d') >= $content->end_date) {
                $update_content = Content::find($content->content_id);
                $update_content->status = 2;
                $update_content->save();
            }
        }
        
        return $this->successResponse($contents);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if($request->file != 'undefined') { 
            $fileName = time().'_'.'audio'.'_'.$request->category_id.'.'.$request->file->getClientOriginalExtension();
        } else {
            $fileName = '';
        }

        $content = new Content();
        $content->category_id = $request->category_id;
        $content->type_id = $request->type_id;
        $content->video_id = $request->video_id;
        $content->title = $request->title;
        $content->google_tags = $request->google_tags;
        $content->start_date = $request->start_date;
        $content->icon = 'icon ion-'.$request->fai.' home_icon_size2';
        $content->end_date = $request->end_date;
        $content->description = $request->description;
        $content->position = $request->position;

        $move_position_contents = Content::where('position', '>=', $request->position)->get();
        $position = $request->position;
        foreach($move_position_contents as $move_position_content) {
            $position = $position + 1;
            $detail_content = Content::find($move_position_content->content_id);
            $detail_content->position = $position;
            $detail_content->save();
        }

        $content->image = $fileName;
        $content->src = $request->src;
        if($this->user->rol_id == 1) {
            $content->status = 1;
        } else {
            $content->status = 2;
        }
        if($content->save()) {
            if($request->file != 'undefined') { 
                Storage::disk('local')->putFileAs(
                    '/public',
                    $request->file,
                    $fileName
                );
            }
        }

        return $this->successResponse($content);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function accept(Request $request)
    {
        $id = $request->segment(4);

        $content = Content::find($id);
        $content->status = 1;
        $content->save();

        return $this->successResponse($content);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $content = Content::find($id);
        $content->category_id = $request->category_id;
        $content->type_id = $request->type_id;
        $content->video_id = $request->video_id;
        $content->title = $request->title;
        $content->google_tags = $request->google_tags;
        $content->start_date = $request->start_date;
        $content->icon = 'icon ion-'.$request->fai.' home_icon_size2';
        $content->end_date = $request->end_date;
        $content->description = $request->description;
        $content->position = $request->position;

        $move_position_contents = Content::where('position', '>=', $request->position)->get();
        $position = $request->position;
        foreach($move_position_contents as $move_position_content) {
            $position = $position + 1;
            $detail_content = Content::find($move_position_content->content_id);
            $detail_content->position = $position;
            $detail_content->save();
        }

        if($this->user->rol_id == 1) {
            $content->status = 1;
        } else {
            $content->status = 2;
        }
        
        $content->save();

        return $this->successResponse($content);
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
        $contents = Content::where('category_id', $id)->where('status', 1)->get();

        return $this->successResponse($contents);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function image(Request $request)
    {
        $id = $request->segment(4);
        $content = Content::find($id);
echo \Storage::url($content->image);
        die();
        return $this->successResponse($content);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function detail(Request $request)
    {
        $id = $request->segment(4);
        $content = Content::where('content_id', $id)->where('status', 1)->first();

        return $this->successResponse($content);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $content = Content::find($id);

        return $this->successResponse($content);
    }

    /**
     * Destroy the specified resource.
     *
     * @param  int  $id
     * @return \App\Http\Controllers\ApiResponseController
     */
    public function destroy($id)
    {
        $content = Content::find($id);

        $content->delete();

        return $this->successResponse($content);
    }

    /**
     * Destroy the specified resource.
     *
     * @param  int  $id
     * @return \App\Http\Controllers\ApiResponseController
     */
    public function stop($id)
    {
        $content = Content::find($id);
        $content->status = 2;
        $content->save();

        return $this->successResponse($content);
    }
}