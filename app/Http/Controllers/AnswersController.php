<?php

namespace App\Http\Controllers;

use App\Http\Requests\AnswerRequest;
use App\Question;
use Illuminate\Support\Facades\Auth;

class AnswersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function store(Question $question, AnswerRequest $request)
    {
        $question->answers()->create([
            'user_id' => Auth::user()->id,
            'content' => $request->input('content'),
        ]);

        return response()->json([], 201);
    }
}
