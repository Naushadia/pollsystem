<?php

namespace App\Http\Controllers;

use App\Models\question;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\option;
use App\Http\Requests\StorequestionRequest;
use App\Http\Requests\UpdatequestionRequest;
use Illuminate\Support\Facades\Auth;

class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function addQuestion(Request $request)
    {
        try {
            $question = new question;
            $question->UserId = Auth::user()->id;
            $question->title = $request->title;
            

            $question->save();

            foreach($request->options as $option) {
                $obj = array(
                    'questionId' => $question->id,
                    'text' => $option['text'],
                    'preferred' => $option['preferred']
                );

                option::create($obj);
            }

            $question_obj = question::with('options')->find($question->id);

            return response()->json(['msg' => 'Question created successfully', 'data' => $question_obj]);
        } catch (\Throwable $th) {
            return response()->json(['status' => 500, 'message' => $th->getMessage()]);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorequestionRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function getQuestion(Request $request)
    {
        try {
            $question_obj = question::with('options')->paginate();

            return response()->json(['msg' => 'Question found successfully', 'data' => $question_obj]);
        } catch (\Throwable $th) {
            return response()->json(['status' => 500, 'message' => $th->getMessage()]);
        }
    }

    public function getUserQuestion(Request $request)
    {
        try {
            $userId = Auth::user()->id;
            $question_obj = question::with('options')->where('userId', $userId)->paginate();

            return response()->json(['msg' => 'Question found successfully', 'data' => $question_obj]);
        } catch (\Throwable $th) {
            return response()->json(['status' => 500, 'message' => $th->getMessage()]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(question $question)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatequestionRequest $request, question $question)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(question $question)
    {
        //
    }
}
