<?php

namespace App\Http\Controllers\api;

use App\Poll;
use App\PollQuestion;
use App\PollQuestionAnswer;
use App\User;
use App\Http\Controllers\ApiResponseController;
use App\Http\Controllers\Controller\api;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PollController extends ApiResponseController
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
        $polls = Poll::from('polls as c')
                        ->selectRaw('c.title as title, c.poll_id as poll_id, sections.section_title as section, c.status as status')
                        ->leftJoin('sections', 'sections.section_id', '=', 'c.section_id')
                        ->orderBy('c.created_at', 'DESC')
                        ->paginate(10);
        
        return $this->successResponse($polls);
    }

    /**
     * Store the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $informations = json_decode($request->informations);

        $poll = new Poll;
        $poll->title = $request->title;
        $poll->section_id = $request->section_id;
        $poll->status = 1;
        $poll->save();

        foreach($informations as $information) {
            $poll_question = new PollQuestion;
            $poll_question->poll_id = $poll->poll_id;
            $poll_question->answer_type_id = $information->answer_type_id;
            $poll_question->question = $information->question;
            $poll_question->save();
        }

        return $this->successResponse($poll);
    }

    /**
     * Store the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $id = $request->segment(4);
        $poll = Poll::where('section_id', $id)->first();

        $poll_questions = PollQuestion::where('poll_id', $poll->poll_id)->get();

        return $this->successResponse($poll_questions);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $poll = Poll::find($id);

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
        $poll = Poll::find($id);
        $poll_id = $poll->poll_id;
        $poll->delete();

        $poll_questions = PollQuestion::where('poll_id', $poll_id)->get();

        foreach($poll_questions as $poll_question) {
            $poll_question_delete = PollQuestion::find($poll_question->poll_question_id);
            $poll_question_delete->delete();
        }

        $poll_answers = PollQuestionAnswer::where('poll_id', $poll_id)->get();

        foreach($poll_answers as $poll_answer) {
            $poll_answer_delete = PollQuestionAnswer::find($poll_answer->poll_question_answer_id);
            $poll_answer_delete->delete();
        }

        return $this->successResponse($poll);
    }

    public function answer(Request $request)
    {
        $yes_no_asnwers = explode(',', $request->yes_no_answers);
        $text_answers = explode(',', $request->text_answers);

        $poll = Poll::where('section_id', $request->poll_id)->first();

        $poll_questions = PollQuestion::where('poll_id', $poll->poll_id)->get();

        $i = 0;

        foreach($poll_questions as $poll_question) {
            $poll_question_answer = new PollQuestionAnswer;
            $poll_question_answer->poll_id = $poll->poll_id;
            $poll_question_answer->question_id = $poll_question->poll_question_id;
            if($poll_question->answer_type_id == 1) {
                $poll_question_answer->answer = $yes_no_asnwers[$i];
            } else if($poll_question->answer_type_id == 2) {
                $poll_question_answer->answer = $text_answers[$i];
            }
            
            $i = $i + 1;

            $poll_question_answer->save();
        }
    }
}