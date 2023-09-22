<?php

namespace App\Http\Controllers;

use App\Models\participate;
use App\Models\option;
use App\Models\poll;
use App\Models\participatequestion;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreparticipateRequest;
use App\Http\Requests\UpdateparticipateRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ParticipateController extends Controller
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
    public function postParticipate(Request $request)
    {
        try {
            $this->validate($request, [
                'pollId' => 'required|string',
                'question.*' => 'required|array',
            ]);
            $count = 0;
            $userId = Auth::user()->id;

            foreach($request->question as $quest) {
                $obj = array(
                    'userId' => $userId,
                    'questionId' => $quest['questionId'],
                    'optionId' => $quest['optionId']
                );
                participatequestion::create($obj);
                $option = option::find($quest['optionId']);
                $count = $option->preferred === 1 && $quest['questionId'] == $option->questionId ? $count + 1 : $count;
            }
            $poll = new participate();

            $poll->UserId = $userId;
            $poll->pollId = $request->pollId;
            $poll->result = $count;

            $poll->save();
            $participate_obj = poll::with('poll_questions.options')->find($poll->pollId);

            return response()->json(['msg' => 'Participated successfully', 'data' => $participate_obj, 'result' => $count]);
        } catch (\Exception $ex) {
            return response()->json(['status' => 500, 'message' => $ex->getMessage()]);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreparticipateRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function getParticipate(Request $request)
    {
        try {
            $userId = Auth::user()->id;
            $participate_obj = participate::where(['userId' => $userId])->paginate();

            return response()->json(['msg' => 'success', 'data' => $participate_obj]);
        } catch (\Exception $ex) {
            return response()->json(['status' => 500, 'message' => $ex->getMessage()]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(participate $participate)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateparticipateRequest $request, participate $participate)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(participate $participate)
    {
        //
    }
}
