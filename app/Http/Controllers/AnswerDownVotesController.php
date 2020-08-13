<?php

namespace App\Http\Controllers;

use App\Models\Answer;

class AnswerDownVotesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(Answer $answer)
    {
        $answer->voteDown(auth()->user());
        return response([], 201);
    }

    public function destroy(Answer $answer)
    {
        $answer->cancelVoteDown(auth()->user());
        return response([], 201);
    }
}
