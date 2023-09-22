<?php

namespace App\Http\Controllers;

use App\Models\poll;
use App\Http\Controllers\Controller;
use App\Http\Requests\StorepollRequest;
use App\Http\Requests\UpdatepollRequest;
use App\Models\option;
use App\Models\pollQuestion;
use App\Models\question;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PollController extends Controller
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
    public function postPoll(Request $request)
    {
        try {
            $this->validate($request, [
                'title' => 'required|string',
                'description' => 'required|string',
                'pollQuestions.*' => 'required|array',
            ]);
            $poll = new poll();

            $poll->UserId = Auth::user()->id;
            $poll->title = $request->title;
            $poll->description = $request->description;

            $poll->save();

            foreach($request->pollQuestions as $question) {
                $obj = array(
                    'pollId' => $poll->id,
                    'questionId' => $question['questionId']
                );

                pollQuestion::create($obj);
            }

            $poll = poll::with('poll_questions.options')->find($poll->id);

            return response()->json(['msg' => 'Poll created successfully', 'data' => $poll]);
        } catch (\Exception $ex) {
            return response()->json(['status' => 500, 'message' => $ex->getMessage()]);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorepollRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function getPoll(Request $request)
    {
        try {
            $poll = poll::with('poll_questions.options')->paginate();

            return response()->json(['msg' => 'Poll found successfully', 'data' => $poll]);
        } catch (\Exception $ex) {
            return response()->json(['status' => 500, 'message' => $ex->getMessage()]);
        }
    }

    public function getUserPoll(Request $request)
    {
        try {
            $userId = Auth::user()->id;
            $poll = poll::with('poll_questions.options')->where('userId', $userId)->paginate();

            return response()->json(['msg' => 'Poll found successfully', 'data' => $poll]);
        } catch (\Exception $ex) {
            return response()->json(['status' => 500, 'message' => $ex->getMessage()]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(poll $poll)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatepollRequest $request, poll $poll)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(poll $poll)
    {
        //
    }
}
