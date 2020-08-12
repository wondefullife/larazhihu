<?php

namespace App\Http\Controllers;

use App\Models\Answer;

class AnswerUpVotesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(Answer $answer)
    {
        $answer->voteUp(auth()->user());
        return response([], 201);
    }

    public function destroy(Answer $answer)
    {
        $answer->cancelVoteUp(auth()->user());

        return response([], 201);
    }
}
